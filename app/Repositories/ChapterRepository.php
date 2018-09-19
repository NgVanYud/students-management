<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/8/2018
 * Time: 2:46 AM
 */

namespace App\Repositories;

use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\GeneralException;

class ChapterRepository extends BaseRepository
{
    public function model()
    {
        return Chapter::class;
    }

    public function active(Subject $subject, Chapter $chapter)
    {
        if ($chapter->isActived()) {
            throw new GeneralException(__('exceptions.backend.subjects.chapters.already_actived'));
        }
        $chapter->is_actived = Chapter::ACTIVE_CODE;
        $actived = $chapter->save();

        if ($actived) {
            return $chapter;
        }

        throw new GeneralException(__('exceptions.backend.subjects.chapters.cant_active'));
    }

    public function inactive(Subject $subject, Chapter $chapter) {
        if(!$chapter->isActived()) {
            throw new GeneralException(__('exceptions.backend.subjects.chapters.not_actived'));
        }
        $chapter->is_actived = Chapter::INACTIVE_CODE;
        $inactived = $chapter->save();
        if($inactived) {
            return $chapter;
        }
        throw new GeneralException(__('exceptions.backend.subjects.chapters.cant_inactive'));
    }

    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function getDeletedPaginatedByModelParent(Subject $subject, $paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->whereSubjectId($subject->id)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

//    public function create(array $data) : Chapter
//    {
//        return DB::transaction(function () use ($data) {
//            $chapter = parent::create([
//                'name' => $data['name'],
//                'is_actived' => isset($data['is_actived']) && $data['is_actived'] == '1' ? Chapter::ACTIVE_CODE : Chapter::INACTIVE_CODE,
//            ]);
//
//            $chapter->$lecturer->associated();
//            // See if adding any additional permissions
//            if (! isset($data['permissions']) || ! count($data['permissions'])) {
//                $data['permissions'] = [];
//            }
//
//            if ($user) {
//                // User must have at least one role
//                if (! count($data['roles'])) {
//                    throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
//                }
//
//                // Add selected roles/permissions
//                $user->syncRoles($data['roles']);
//                $user->syncPermissions($data['permissions']);
//
//                //Send confirmation email if requested and account approval is off
//                if (isset($data['confirmation_email']) && $user->confirmed == 0 && ! config('access.users.requires_approval')) {
//                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
//                }
//
//                event(new UserCreated($user));
//
//                return $user;
//            }
//
//            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
//        });
//    }

    public function restore(Subject $subject, Chapter $chapter) : Chapter
    {
        if(!is_null($subject->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.subjects.chapters.cant_restore_for_deleted_subject'));
        }

        if (is_null($chapter->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.subjects.chapters.cant_restore'));
        }

        if ($chapter->restore()) {
            return $chapter;
        }

        throw new GeneralException(__('exceptions.backend.subjects.chapters.restore_error'));
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
            ->with('subject')
            ->select($columns)
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

}
