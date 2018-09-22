<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/6/2018
 * Time: 12:38 AM
 */

namespace App\Repositories\Backend;


use App\Exceptions\GeneralException;
use App\Models\Subject;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class SubjectRepository extends BaseRepository
{
    public function model()
    {
        return Subject::class;
    }

    public function active(Subject $subject)
    {
        if ($subject->isActived()) {
            throw new GeneralException(__('exceptions.backend.subjects.already_actived'));
        }
        $subject->is_actived = Subject::ACTIVE_CODE;
        $actived = $subject->save();

        if ($actived) {
            return $subject;
        }

        throw new GeneralException(__('exceptions.backend.subjects.cant_active'));
    }

    public function inactive(Subject $subject) {
        if(!$subject->isActived()) {
            throw new GeneralException(__('exceptions.backend.subjects.not_actived'));
        }
        $subject->is_actived = Subject::INACTIVE_CODE;
        $inactived = $subject->save();
        if($inactived) {
            return $subject;
        }
        throw new GeneralException(__('exceptions.backend.subjects.cant_inactive'));
    }

    public function forceDelete(Subject $subject) : Subject
    {
        if (is_null($subject->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.subjects.delete_first'));
        }
        return $subject;

//        return DB::transaction(function () use ($subject) {
//            // Delete associated relationships
//            $user->passwordHistories()->delete();
//            $user->providers()->delete();
//            $user->sessions()->delete();
//
//            if ($user->forceDelete()) {
//                event(new UserPermanentlyDeleted($user));
//
//                return $user;
//            }
//
//            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
//        });
    }

    public function restore(Subject $subject) : Subject
    {
        if (is_null($subject->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.subjects.cant_restore'));
        }

        if ($subject->restore()) {
            return $subject;
        }

        throw new GeneralException(__('exceptions.backend.subjects.restor e_error'));
    }

    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function getActive(array $columns = ['*'], $orderBy = 'created_at', $sort='asc') {
        return $this->model
            ->select($columns)
            ->active()
            ->orderBy($orderBy, $sort)
            ->get();
    }

    public function getActivePaginated(array $columns = ['*'], $paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->with('chapters', 'lecturers')
            ->select($columns)
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function getExaminationBySubjects($subjects) {
        $examinations = collect([]);
        foreach ($subjects as $subject) {
            $examinations = $examinations->concat($subject->examinations);
        }
        return $examinations;
    }
}