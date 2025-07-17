<?php

namespace Hanafalah\ModuleEmployee\Enums\Employee;

enum CardIdentity: string
{
    case SIP = 'SIP';
    case SIK = 'SIK';
    case NIP = 'NIP';
    case STR = 'STR';
    case BPJS_KETENAGAKERJAAN = 'bpjs_ketenagakerjaan';
}
