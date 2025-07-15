<?php

namespace Projects\GIR\Controllers\API\Attendence;

use Hanafalah\ModuleEmployee\Contracts\Schemas\Attendence;
use Projects\GIR\Requests\API\Navigation\Attendence\{
    StoreRequest
};
use Projects\GIR\Controllers\API\ApiController;

class AttendenceController extends ApiController{
    public function __construct(
        protected Attendence $__attendence_schema
    ){
        parent::__construct();
    }

    public function store(StoreRequest $request){
        return $this->__attendence_schema->storeAttendence();
    }
}