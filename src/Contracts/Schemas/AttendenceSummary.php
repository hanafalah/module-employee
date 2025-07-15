<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceSummaryData;
//use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceSummaryUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\AttendenceSummary
 * @method self conditionals(mixed $conditionals)
 * @method mixed getAttendenceSummary()
 * @method array storeAttendenceSummary(?AttendenceSummaryData $attendence_summary_dto = null);
 * @method Builder attendenceSummary(mixed $conditionals = null);
 */
interface AttendenceSummary extends DataManagement
{
    public function prepareStoreAttendenceSummary(AttendenceSummaryData $attendence_summary_dto): Model;
}