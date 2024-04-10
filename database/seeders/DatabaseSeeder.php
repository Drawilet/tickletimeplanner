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
        $this->call(
            [
                AppSeeder::class,
                PermissionSeeder::class,
                UserSeeder::class,
            ]
        );

        if (config('app.env') === 'local') {
            $this->call([
                TenantSeeder::class,
                /*          ProductSeeder::class,
                         CustomerSeeder::class,
                         SpaceSeeder::class,
                         EventSeeder::class, */
            ]);
        }
    }
}
