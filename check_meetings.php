<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meetings = App\Models\Meeting::with(['host', 'participants.user'])->get();
foreach ($meetings as $m) {
    echo "ID: {$m->id} | UUID: {$m->uuid} | Title: {$m->title} | HostID: {$m->host_id} | Status: {$m->status} | CreatedAt: {$m->created_at} | StartsAt: {$m->starts_at} | EndsAt: {$m->ends_at}\n";
}
