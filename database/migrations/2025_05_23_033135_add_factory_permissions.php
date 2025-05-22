<?php

use Illuminate\Database\Migrations\Migration;

class AddFactoryPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'dispansar_crud',
            'display_name' => 'Dispansar management',
            'description' => 'User can create, delete or modify the dispansars',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->insertGetId([
            'name' => 'factory',
            'display_name' => 'Factory',
        ]);

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

        DB::table('permissions_categories')->where('name', 'factory')->delete();
    }
}
