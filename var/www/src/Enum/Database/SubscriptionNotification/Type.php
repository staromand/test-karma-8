<?php

namespace App\Enum\Database\SubscriptionNotification;

enum Type: string {
    case OneDayLeft = 'O';
    case ThreeDaysLeft = 'T';
    
    /**
     * @return string[]
     */
    public static function getAll(): array
    {
        return array_column(self::cases(), 'value');
    }
}
