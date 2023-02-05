<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Role::create([
            "name"=>"ADMIN",
            'guard_name'=>'api'
        ]);
        $writer=Role::create([
            "name"=>"WRITER",
            "guard_name"=>"api"
        ]);
        $permissions=Permission::all();
        $admin->givePermissionTo($permissions);
        //
        $writer->givePermissionTo("view posts");
    }
}
