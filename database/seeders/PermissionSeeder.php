<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Permission::create([
            "name"=>"add posts",
             "guard_name"=>"api"
        ]);
        //
        Permission::create([
            "name"=>"edit posts",
            "guard_name"=>"api"
        ]);
        Permission::create([
            'name'=>"view posts",
            "guard_name"=>"api"
        ]);
    }
}
