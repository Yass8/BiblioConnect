<?php

namespace App\Enum;

enum ReservationStatus: string
{
    case PENDING = 'pending';
    case RESERVED = 'reserved';
    case CANCELLED = 'cancelled';
}
