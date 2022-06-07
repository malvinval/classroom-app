<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Creator;
use App\Models\Forum;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Creator::factory(10)->create();
        
        Classroom::create([
            "name" => "Matematika Diskrit",
            "access_code" => password_hash("E45YF23E", PASSWORD_DEFAULT),
            "slug" => "matematika-diskrit",
            "creator_id" => 1,
            "description" => "Informatika"
        ]);

        Classroom::create([
            "name" => "Fisika Dasar",
            "access_code" => password_hash("A32HN16F", PASSWORD_DEFAULT),
            "slug" => "fisika-dasar",
            "creator_id" => 2,
            "description" => "Informatika"
        ]);

        Classroom::create([
            "name" => "Aljabar Linear",
            "access_code" => password_hash("V23CB11X", PASSWORD_DEFAULT),
            "slug" => "matematika-diskrit",
            "creator_id" => 3,
            "description" => "Informatika"
        ]);

        Forum::create([
            "classroom_access_code" => password_hash("E45YF23E", PASSWORD_DEFAULT),
            "caption" => "Lorem"
        ]);
    }
}
