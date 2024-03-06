<?php

namespace App\Enums;

enum BookStatusEnum: string
{
    case AVAILABLE = 'available';
    case BORROWED = 'borrowed';
    case LOST = 'lost';
}
