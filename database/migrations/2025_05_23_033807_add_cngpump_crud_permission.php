<?php

use Illuminate\Database\Migrations\Migration;

class AddCngpumpCrudPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'cngpump_crud',
            'display_name' => 'CNG Pump Slip management',
            'description' => 'User can create, delete or modify the CNG Pump Slip',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->where('name', 'factory')->first('id')->id;

        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            $permission['category_id'] = $catId;
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
