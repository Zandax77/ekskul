<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $siswa = \App\Models\Siswa::create([
        'nama' => 'Test',
        'nis' => 'test_'.rand(1000, 9999),
        'kelas' => 'X MIPA',
        'password' => 'password123',
    ]);
    echo "Success! Siswa ID: " . $siswa->id . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
