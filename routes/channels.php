<?php

use App\Models\User;
use App\Models\Employee;
use App\Models\Support;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('test.broadcast.public', function ($user) {
//     return true;
// });

Broadcast::channel(
    channel: 'order-sync-channel',
    callback: function ($user) {
        return $user instanceof User || $user instanceof Employee || $user instanceof Support;
    },
    options: ['guards' => ['admin', 'employee', 'support']]
);

Broadcast::channel(
    channel: 'order-assign-channel',
    callback: function ($user) {
        return $user instanceof User || $user instanceof Employee || $user instanceof Support;
    },
    options: ['guards' => ['admin', 'employee', 'support']]
);

Broadcast::channel(
    channel: 'order-delay-channel',
    callback: function ($user) {
        return $user instanceof Employee;
    },
    options: ['guards' => ['employee']]
);

Broadcast::channel(
    channel: 'order-transfer-channel',
    callback: function ($user) {
        return $user instanceof Support;
    },
    options: ['guards' => ['support']]
);
