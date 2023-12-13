<?php

namespace Database\Seeders;

use App\Models\Space;
use App\Models\SpacePhoto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SpaceSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $spaces = [
            [
                "name" => "Peter Pipper Pizza",
                "description" => "Peter Pipper Pizza is a pizza restaurant in the heart of the city. We serve the best pizza in town. Come and visit us!",
                "address" => "123 Main Street",
                "city" => "New York",
                "state" => "NY",
                "country" => "USA",
                "schedule" => [
                    "monday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "tuesday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "wednesday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "thursday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "friday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "saturday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "sunday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ]
                ],
                "color" => "#f2ff3d",
            ],
            [
                "name" => "Versalles Palace",
                "description" => "Versalles Palace is a palace in the heart of the city. We serve the best pizza in town. Come and visit us!",
                "address" => "123 Main Street",
                "city" => "New York",
                "state" => "NY",
                "country" => "USA",
                "schedule" => [
                    "monday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "tuesday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "wednesday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "thursday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "friday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "saturday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ],
                    "sunday" => [
                        "opening" => "09:00",
                        "closing" => "17:00"
                    ]
                ],
                "color" => "#70fdff",
            ]
        ];

        foreach ($spaces as $space) {
            $space["tenant_id"] = $user->tenant_id;
            $space = Space::create($space);

            $id = $space->id;
            $name = $space->name;

            $storagePath = "public/space/$id/photos";

            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }

            $photos = Storage::files("seeder/space/$name");

            foreach ($photos as $photo) {
                $photoName = basename($photo);
                Storage::copy($photo, "$storagePath/$photoName");
                SpacePhoto::create([
                    "space_id" => $id,
                    "url" => "/storage/space/$id/photos/$photoName"
                ]);
            }
        }
    }
}
