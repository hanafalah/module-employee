<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\SummaryData as DataSummaryData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class SummaryData extends Data implements DataSummaryData
{
    #[MapInputName('at')]
    #[MapName('at')]
    public ?string $at = null;

    #[MapInputName('present')]
    #[MapName('present')]
    public ?int $present = null;

    #[MapInputName('absent')]
    #[MapName('absent')]
    public ?int $absent = null;

    #[MapInputName('late')]
    #[MapName('late')]
    public ?int $late = null;

    #[MapInputName('sick')]
    #[MapName('sick')]
    public ?int $sick = null;

    #[MapInputName('vacation')]
    #[MapName('vacation')]
    public ?int $vacation = null;

    #[MapInputName('others')]
    #[MapName('others')]
    public ?int $others = null;

    #[MapInputName('note')]
    #[MapName('note')]
    public ?string $note = null;

    #[MapInputName('attachement')]
    #[MapName('attachement')]
    public string|UploadedFile|null $attachement = null;
}