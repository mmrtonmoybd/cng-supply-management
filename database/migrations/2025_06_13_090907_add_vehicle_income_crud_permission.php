<?php

use Illuminate\Database\Migrations\Migration;

class AddVehicleIncomeCrudPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'vehicle_income_crud',
            'display_name' => 'Vehicle Income management',
            'description' => 'User can modify the vehicle income',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            DB::table('permissions')->insert($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->where('name', $permission['name'])->delete();
        }
    }
}
