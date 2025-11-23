<?php
namespace App\Traits;

use App\Models\DeviceToken;

trait RetrievesDeviceTokens
{
    public function getDeviceTokens(array $userIds ): array
    {
        return DeviceToken::query()
            ->whereIn('user_id', $userIds)
            ->pluck('device_token')
            ->toArray();
    }
}