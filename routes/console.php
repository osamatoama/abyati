<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command(
    command: 'backup:clean',
)->twiceDaily();

Schedule::command(
    command: 'backup:run --only-db',
)->twiceDaily();

Schedule::command(
    command: 'queue:prune-batches',
)->daily();

Schedule::command(
    command: 'webhooks:prune-stale',
)->daily();
