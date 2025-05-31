<?php

use Illuminate\Database\Migrations\Migration;

class AddCashbookCrudPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'cashbook_crud',
            'display_name' => 'Cashbook management',
            'description' => 'User can create, delete or modify the cashbook',
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
