<?php

namespace Hanafalah\ModuleEmployee\Controllers\API\AbsenceRequest;

use Hanafalah\ModuleEmployee\Contracts\Schemas\AbsenceRequest;
use Hanafalah\ModuleEmployee\Controllers\API\ApiController;
use Hanafalah\ModuleEmployee\Requests\API\AbsenceRequest\{
    ViewRequest, StoreRequest, DeleteRequest
};

class AbsenceRequestController extends ApiController{
    public function __construct(
        protected AbsenceRequest $__absencerequest_schema
    ){
        parent::__construct();
    }

    public function index(ViewRequest $request){
        return $this->__absencerequest_schema->viewAbsenceRequestList();
    }

    public function store(StoreRequest $request){
        return $this->__absencerequest_schema->storeAbsenceRequest();
    }

    public function destroy(DeleteRequest $request){
        return $this->__absencerequest_schema->deleteAbsenceRequest();
    }
}