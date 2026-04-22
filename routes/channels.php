<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('presence.{roomId}', function ($user, $roomId) {
    [$a, $b] = explode('-', $roomId);
    $ids = [(int) $a, (int) $b];

    if (in_array((int) $user->id, $ids)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    return false;
});
