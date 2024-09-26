<?php

namespace App\Services\Salla\Merchant\Enums;

enum OrdersSort: string
{
    case ID_ASC = 'id-asc';
    case ID_DESC = 'id-desc';
    case TOTAL_ASC = 'total-asc';
    case TOTAL_DESC = 'total-desc';
    case UPDATED_AT_ASC = 'updated_at-asc';
    case UPDATED_AT_DESC = 'updated_at-desc';
    case CREATED_AT_ASC = 'created_at-asc';
    case CREATED_AT_DESC = 'created_at-desc';
}
