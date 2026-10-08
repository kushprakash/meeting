<?php

use App\Models\Meeting;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$meetings = Meeting::with(['host', 'participants.user'])->get();
foreach ($meetings as $m) {
    echo "ID: {$m->id} | UUID: {$m->uuid} | Title: {$m->title} | HostID: {$m->host_id} | Status: {$m->status} | CreatedAt: {$m->created_at} | StartsAt: {$m->starts_at} | EndsAt: {$m->ends_at}\n";
}
