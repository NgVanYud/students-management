<?php
/**
 * Created by PhpStorm.
 * User: duynv
 * Date: 9/15/2018
 * Time: 11:01 PM
 */

namespace App\Repositories\Backend;


use App\Models\Examination;
use App\Repositories\BaseRepository;

class ExaminationRepository extends BaseRepository
{
    public function model()
    {
        return Examination::class;
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function active(Examination $examination)
    {
        if ($examination->isActived()) {
            throw new GeneralException(__('exceptions.backend.examinations.already_actived'));
        }
        $examination->is_actived = Examination::ACTIVE_CODE;
        $actived = $examination->save();

        if ($actived) {
            return $examination;
        }

        throw new GeneralException(__('exceptions.backend.examinations.cant_active'));
    }

    public function inactive(Examination $examination) {
        if(!$examination->isActived()) {
            throw new GeneralException(__('exceptions.backend.examinations.not_actived'));
        }
        $examination->is_actived = Examination::INACTIVE_CODE;
        $inactived = $examination->save();
        if($inactived) {
            return $examination;
        }
        throw new GeneralException(__('exceptions.backend.examinations.cant_inactive'));
    }

}