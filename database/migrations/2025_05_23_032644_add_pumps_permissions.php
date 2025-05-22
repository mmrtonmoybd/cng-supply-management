<?php

use Illuminate\Database\Migrations\Migration;

class AddPumpsPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'pump_crud',
            'display_name' => 'Pump management',
            'description' => 'User can create, delete or modify the pumps',
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
            'name' => 'pumps',
            'display_name' => 'Pumps',
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

        DB::table('permissions_categories')->where('name', 'pumps')->delete();
    }
}
