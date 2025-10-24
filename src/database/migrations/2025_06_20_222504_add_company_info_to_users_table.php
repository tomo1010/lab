<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_postal')->nullable(); // 郵便番号
            $table->string('company_address')->nullable(); // 住所
            $table->string('company_name')->nullable(); // 会社名
            $table->string('company_tel')->nullable(); // 電話番号
            $table->string('company_handyphone')->nullable(); // 携帯番号
            $table->string('company_fax')->nullable(); // FAX
            $table->string('company_mail')->nullable(); // メール
            $table->string('company_url')->nullable(); // ホームページURL
            $table->string('company_registration_number')->nullable(); // 登録番号（法人番号など）
            $table->string('company_transfer_1')->nullable(); // 振込先1
            $table->string('company_transfer_2')->nullable(); // 振込先2
            $table->string('company_transfer_3')->nullable(); // 振込先3
            $table->text('company_note')->nullable(); // 備考欄
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_postal',
                'company_address',
                'company_name',
                'company_tel',
                'company_handyphone',
                'company_fax',
                'company_mail',
                'company_url',
                'company_registration_number',
                'company_transfer_1',
                'company_transfer_2',
                'company_transfer_3',
                'company_note',
            ]);
        });
    }
};
