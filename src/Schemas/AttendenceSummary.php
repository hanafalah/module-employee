<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\{
    Supports\BaseModuleEmployee
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\AttendenceSummary as ContractsAttendenceSummary;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceSummaryData;

class AttendenceSummary extends BaseModuleEmployee implements ContractsAttendenceSummary
{
    protected string $__entity = 'AttendenceSummary';
    public static $attendence_summary_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'attendence_summary',
            'tags'     => ['attendence_summary', 'attendence_summary-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreAttendenceSummary(AttendenceSummaryData $attendence_summary_dto): Model{
        $add = [
            'name' => $attendence_summary_dto->name
        ];
        $guard  = ['id' => $attendence_summary_dto->id];
        $create = [$guard, $add];
        // if (isset($attendence_summary_dto->id)){
        //     $guard  = ['id' => $attendence_summary_dto->id];
        //     $create = [$guard, $add];
        // }else{
        //     $create = [$add];
        // }

        $attendence_summary = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($attendence_summary,$attendence_summary_dto->props);
        $attendence_summary->save();
        return static::$attendence_summary_model = $attendence_summary;
    }
}