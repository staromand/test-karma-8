<?php

namespace App\Enum\Database\SubscriptionNotification;

enum Type: string {
    case OneDayLeft = 'O';
    case ThreeDaysLeft = 'T';
}
