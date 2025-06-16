<?php

namespace Hanafalah\ModuleEmployee\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleEmployee\Resources\EmployeeStuff\{
    ViewEmployeeStuff,
    ShowEmployeeStuff
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class EmployeeStuff extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'name',
        'flag',
        'props',
    ];

    protected $casts = [
        'name' => 'string',
        'flag' => 'string',
    ];

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewEmployeeStuff::class;
    }

    public function getShowResource(){
        return ShowEmployeeStuff::class;
    }

    

    
}
