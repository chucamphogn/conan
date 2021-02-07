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
             * Địa chỉ email của kho lưu trữ (Cho phép 1 kho lưu trữ được quản lý bởi nhiều tài khoản nên không đặt unique)
             */
            $table->string('email');

            /**
             * Dùng để phân biệt token này của Google hay của Dropbox,...
             * @see \App\Enums\TokenType Định nghĩa các giá trị của token_type ở trong class này
             */
            $table->string('token_type');

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
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
