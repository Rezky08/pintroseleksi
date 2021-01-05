<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AddDefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user_where = [
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ];
        $user_data = [
            'password' => Hash::make('secret'),
            'created_at' => new \DateTime,
            'role_id' => 1
        ];
        $count = DB::table('users')->where($user_where)->count();
        if ($count <= 0) {
            DB::table('users')->insert($user_where + $user_data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user_where = [
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ];
        DB::table('users')->where($user_where)->delete();
    }
}
