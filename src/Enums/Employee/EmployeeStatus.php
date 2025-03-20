<?php

namespace Hanafalah\ModuleEmployee\Enums\Employee;

enum EmployeeStatus: int
{
    case DRAFT          = 0;
    case ACTIVE         = 1;
    case INACTIVE       = 2;
    case DELETED        = 3;
    case RETIRED        = 4;
    case CONTRACT_ENDED = 5;
    case INTERN         = 6;
    case PROBATION      = 7;
    case DECEASED       = 8;
    case RESIGNED       = 9;
}
