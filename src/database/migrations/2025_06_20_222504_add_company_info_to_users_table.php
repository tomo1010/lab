<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('postal')->nullable()->after('password');
            $table->string('address')->nullable()->after('postal');
            $table->string('company_name')->nullable()->after('address'); // ← 追加
            $table->string('tel')->nullable()->after('company_name'); // ← 位置調整
            $table->string('fax')->nullable()->after('tel');
            $table->string('company_mail')->nullable()->after('fax');
            $table->string('url')->nullable()->after('company_mail'); // ← 'mail' → 'company_mail' に修正
            $table->string('registration_number')->nullable()->after('url');
            $table->string('transfer_1')->nullable()->after('registration_number');
            $table->string('transfer_2')->nullable()->after('transfer_1');
            $table->string('transfer_3')->nullable()->after('transfer_2');
            $table->text('note')->nullable()->after('transfer_3');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'postal',
                'address',
                'company_name', // ← 追加
                'tel',
                'fax',
                'company_mail',
                'url',
                'registration_number',
                'transfer_1',
                'transfer_2',
                'transfer_3',
                'note',
            ]);
        });
    }
};
