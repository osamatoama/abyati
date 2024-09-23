<?php

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('test.broadcast.public', function ($user) {
//     return true;
// });

Broadcast::channel(
    channel: 'order-sync-channel',
    callback: function ($user) {
        return $user instanceof User || $user instanceof Employee;
    },
    options: ['guards' => ['admin', 'employee']]
);

Broadcast::channel(
    channel: 'order-assign-channel',
    callback: function ($user) {
        return $user instanceof User || $user instanceof Employee;
    },
    options: ['guards' => ['admin', 'employee']]
);
