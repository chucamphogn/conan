<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            /**
             * Tạo khoá ngoại user_id
             * Khi tài khoản bị xoá thì các token cũng sẽ bị xoá theo
             */
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();

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
        Schema::dropIfExists('tokens');
    }
}
