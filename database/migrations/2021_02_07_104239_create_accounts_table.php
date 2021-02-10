<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            /**
             * Id tài khoản trong hệ thống
             */
            $table->uuid('id')->primary();

            /**
             * Tạo khoá ngoại user_id
             * Khi tài khoản bị xoá thì các token cũng sẽ bị xoá theo
             */
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();

            /**
             * Tên bí danh của kho lưu trữ
             */
            $table->string('alias_name', 20);

            /**
             * Địa chỉ email của kho lưu trữ
             */
            $table->string('email');

            /**
             * Dùng để phân biệt tài khoản này của Google hay của Dropbox,...
             * @see \App\Enums\Provider Định nghĩa các giá trị của provider ở trong class này
             */
            $table->string('provider');

            /**
             * Lưu trữ access_token
             */
            $table->string('access_token');

            /**
             * Dùng để làm mới access_token khi access_token hết hạn
             */
            $table->string('refresh_token');

            /**
             * Thời gian hết hạn của access_token
             */
            $table->integer('expires_in');

            /**
             * Email có thể trùng lặp nhưng không thể trùng cả kho lưu trữ
             */
            $table->unique(['user_id', 'email', 'provider']);

            /**
             * Bí danh của kho lưu trữ không được trùng nhau trong 1 tài khoản
             */
            $table->unique(['user_id', 'alias_name']);

            /**
             * Thời gian token được tạo
             */
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
