<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Iluvatar']);
        $role2 = Role::create(['name' => 'Ainur']);
        $role3 = Role::create(['name' => 'Valar']);
        $role4 = Role::create(['name' => 'Maiar']);
        $role5 = Role::create(['name' => 'Elfos']);
        $role6 = Role::create(['name' => 'Enanos']);
        $role7 = Role::create(['name' => 'Hombres']);


        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'buffet'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'buffet.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dolar.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dolar.update'])->syncRoles([$role1, $role2]);


    }
}
