<?php

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('test.broadcast.public', function ($user) {
//     return true;
// });

Broadcast::channel('order-assign-channel', function ($user) {
    return $user instanceof User || $user instanceof Employee;
}, ['guards' => ['admin', 'employee']]);
