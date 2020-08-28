<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateHyperfAdminUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * 后台管理员表
         */
        Schema::create('hyperf_admin_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->comment('账号');
            $table->string('password')->comment('密码');
            $table->string('name')->comment('昵称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hyperf_admin_users');
    }
}
