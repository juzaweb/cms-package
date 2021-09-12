<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDatabaseV106 extends Migration
{
    public function up()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->string('email_hook', 100)->nullable();
        });

        DB::table('email_templates')
            ->where('code', '=', 'verification')
            ->update(['email_hook' => 'register_success']);
    }

    public function down()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn('email_hook');
        });
    }
}
