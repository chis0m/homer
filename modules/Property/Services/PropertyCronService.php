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
            foreach ($chunk as $property) {
                $agent = $property->propertable;
                $deletedAt = Carbon::parse($property['expired_at']);
                $notificationCount = $property['notification_count'];
                if ($deletedAt->gt(now())) {
                    continue;
                }
                if($notificationCount >= $setNotificationCount) {
                    $property->update(['status' => Enum::INACTIVE]);
                    sendMail($agent, 'property.agent', 'ListingDeactivated');//mail will always be sent here so ajdust
                    continue;
                }
                sendMail($agent, 'property.agent', 'ExpiredListing');
                $property['notification_count'] += 1;
                $property->save();


            }
        });
    }

    public static function checkInactiveProperties(): void
    {
        Property::agentPropertyThatAre(Enum::INACTIVE)->chunkById(100, function ($chunk) {

        });
    }
}
