<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function cleanStorageDir()
    {
        $dir = base_path("storage/app/public/");

        if (file_exists($dir)) {
            $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new \RecursiveIteratorIterator(
                $it,
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        }

        mkdir($dir);
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanStorageDir();

        $this->call(
            [
                PermissionSeeder::class,
                UserSeeder::class,
                ProductSeeder::class,
                CustomerSeeder::class,
                SpaceSeeder::class,
            ]
        );
    }
}
