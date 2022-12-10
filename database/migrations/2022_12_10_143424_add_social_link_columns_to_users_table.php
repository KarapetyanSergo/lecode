<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialLinkColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_link')->nullable()->after('email');
            $table->string('linkedin_link')->nullable()->after('email');
            $table->string('facebook_link')->nullable()->after('email');
            $table->string('instagram_link')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('facebook_link');
            $table->dropColumn('instagram_link');
            $table->dropColumn('telegram_link');
        });
    }
}
