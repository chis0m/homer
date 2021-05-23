<?php

namespace Modules\Property\Services;

use Carbon\Carbon;
use App\Models\General\Configuration;
use Globals\Classes\Enum;
use Modules\Property\Models\Property;

class PropertyCronService {
    public static function validateActiveProperties(): void
    {
        Property::agentPropertyThatAre(Enum::ACTIVE)->chunkById(100, function ($chunk) {
            $setNotificationCount = Configuration::getPropertyExpiryCount();
            $expiryNotificationTimeInterval = Configuration::getPropertyExpiryTimeInterval();
            $totalNotificationTime = $setNotificationCount * $expiryNotificationTimeInterval;
            foreach ($chunk as $property) {
                $deletedAt = Carbon::parse($property['expired_at']);
                if ($deletedAt->lt(now())) {
                    continue;
                }
                $agent = $property->propertable;
                $notificationTimeLaps = $property['notification_time_laps'];
                if(($notificationTimeLaps >= $totalNotificationTime) && ($property->status === Enum::ACTIVE)) {
                    $property->update(['status' => Enum::INACTIVE]);
                    sendMail($agent, 'property.agent', 'ListingDeactivated');
                    continue;
                }
                if ($notificationTimeLaps < $totalNotificationTime && ($property->status === Enum::ACTIVE)) {
                    sendMail($agent, 'property.agent', 'ExpiredListing');
                    $property['notification_time_laps'] += $expiryNotificationTimeInterval;
                    $property->save();
                }
                if($notificationTimeLaps < $totalNotificationTime && ($property->status === Enum::INACTIVE)) {
                    $property->update(['status' => Enum::ACTIVE]);
                    sendMail($agent, 'property.agent', 'ExpiredListing');
                    $property['notification_time_laps'] += $expiryNotificationTimeInterval;
                    $property->save();
                }
                continue;
            }
        });
    }

    public static function checkInactiveProperties(): void
    {
        Property::agentPropertyThatAre(Enum::INACTIVE)->chunkById(100, function ($chunk) {

        });
    }
}
