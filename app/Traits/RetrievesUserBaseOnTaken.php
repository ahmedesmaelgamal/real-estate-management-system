<?php
namespace App\Traits;

use App\Models\DeviceToken;
use App\Models\User;

trait RetrievesUserBaseOnTaken
{


    public function getUserByToken(string $token): ?User
    {
        $deviceToken = DeviceToken::where('device_token', $token)->first();

        return $deviceToken ? User::find($deviceToken->user_id) : null;
    }



}