<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItemImagesSeeder extends Seeder
{
    public function run(): void
    {
        $fromDir = public_path('dummy/items'); // Git管理
        $toDir = 'items'; // storage/app/public/items

        Storage::disk('public')->makeDirectory($toDir);

        if (!File::exists($fromDir)) {
            return;
        }

        foreach (File::files($fromDir) as $file) {
            $filename = $file->getFilename();

            Storage::disk('public')->put(
                $toDir . '/' . $filename,
                File::get($file->getRealPath())
            );
        }
    }
}
