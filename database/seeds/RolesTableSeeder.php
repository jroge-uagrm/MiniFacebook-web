<?php

use Illuminate\Database\Seeder;
use App\Role;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=new Role();
        $role->name="Administrator";
        $role->created_at=Carbon::now();
        $role->updated_at=Carbon::now();
        $role->save();

        $role=new Role();
        $role->name="User";
        $role->created_at=Carbon::now();
        $role->updated_at=Carbon::now();
        $role->save();

        $role=new Role();
        $role->name="Deleted";
        $role->created_at=Carbon::now();
        $role->updated_at=Carbon::now();
        $role->save();
    }
}
