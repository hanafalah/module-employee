<?php

namespace Hanafalah\ModuleEmployee\Concerns;

trait HasAccessAttendence{
    public function authorAttendence(){return $this->morphOneModel('Attendence','author');}
    public function authorAttendences(){return $this->morphManyModel('Attendence','author');}
}