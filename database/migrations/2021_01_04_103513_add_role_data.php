<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRoleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            [
                'id' => 1,
                'role_name' => 'admin',
                'created_at' => new \DateTime()
            ],
            [
                'id' => 2,
                'role_name' => 'employee',
                'created_at' => new \DateTime()
            ]
        ];
        DB::table('roles')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
    }
}
