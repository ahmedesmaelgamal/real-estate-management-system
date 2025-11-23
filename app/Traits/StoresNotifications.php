<?php
namespace App\Traits;

use App\Models\Notification;

trait StoresNotifications
{
    public function storeNotifications(array $data, array $userIds): void
    {
        foreach ($userIds as $userId) {
            Notification::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $userId,
                'reference_id'=> $data['reference_id']?? null,
                'reference_table'=> $data['reference_table']?? null,

            ]);
        }
    }
}