<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            // 外部キー制約
            // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints

            // 親テーブル(users)のidを参照する外部キー
            $table->unsignedBigInteger('user_id');
            // 外部キー制約を定義
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade') // 親テーブルの変更に連動
                ->onDelete('cascade'); // 親テーブルの削除に連動
            $table->string('title', 100); // max100文字
            // S3のpathを格納
            $table->string('img_post')->nullable();

            // $table->string('title', 50); // max50文字
            // $table->unsignedTinyInteger('img'); # unsignedTinyInteger => 0 - 255
            // $table->unsignedTinyInteger('gender')->comment('1: 男性, 2: 女性, 3: その他');
            // $table->string('email', 255)->unique(); # ユニーク。重複を抑止。
            // $table->string('url', 2048)->nullable($value = true); # （デフォルトで）NULL値をカラムに挿入
            // $table->boolean('confirmed'); # mysqlのboolean型はtinyint(1)で、これは1bitを表す。1=true、0=false。

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 外部キーの制約を削除
        // https://readouble.com/laravel/6.x/ja/migrations.html#foreign-key-constraints
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('posts');
    }
}
