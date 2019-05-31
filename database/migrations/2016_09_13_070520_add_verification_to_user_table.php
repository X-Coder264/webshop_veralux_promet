<?php

declare(strict_types=1);
/**
 * This file is part of Jrean\UserVerification package.
 *
 * (c) Jean Ragouin <go@askjong.com> <www.askjong.com>
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationToUserTable extends Migration
{
    /**
     * Determine the user table name.
     *
     * @return string
     */
    public function getUserTableName()
    {
        $user_model = config('auth.providers.users.model', App\User::class);

        return (new $user_model())->getTable();
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table($this->getUserTableName(), function (Blueprint $table) {
            $table->boolean('verified')->default(false);
            $table->string('verification_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table($this->getUserTableName(), function (Blueprint $table) {
            $table->dropColumn('verified');
            $table->dropColumn('verification_token');
        });
    }
}
