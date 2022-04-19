<?php

use App\Models\BoosterPack;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('object');
            $table->string('action');
            $table->integer('object_id');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('booster_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price', 10)->default(0);
            $table->decimal('bank', 10)->default(0);
            $table->integer('us');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('assign_id');
            $table->integer('reply_id')->nullable()->default(null);
            $table->text('text');
            $table->integer('likes');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('text');
            $table->string('img', 1024);
            $table->integer('likes');
            $table->timestamps();
        });

        Schema::create('booster_pack_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booster_pack_id');
            $table->integer('item_id');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->integer('price');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 60)->nullable()->default(null);
            $table->string('password', 32)->nullable()->default(null);
            $table->string('personaname', 50)->default('');
            $table->string('avatarfull', 150)->default('');
            $table->tinyInteger('rights')->default(0);
            $table->integer('likes_balance')->default(0);
            $table->decimal('wallet_balance', 10)->default(0);
            $table->decimal('wallet_total_refilled', 10)->default(0);
            $table->decimal('wallet_total_withdrawn', 10)->default(0);
            $table->timestamps();
        });

        $this->insertDefaultData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    private function insertDefaultData(): void
    {
        BoosterPack::query()->insert([
            ['price' => 5, 'bank' => 0, 'us' => 1],
            ['price' => 20, 'bank' => 0, 'us' => 2],
            ['price' => 50, 'bank' => 0, 'us' => 5],
        ]);

        Comment::query()->insert([
            ['user_id' => 1, 'assign_id' => 1, 'reply_id' => null, 'text' => 'Comment #1', 'likes' => 0],
            ['user_id' => 1, 'assign_id' => 1, 'reply_id' => null, 'text' => 'Comment #2', 'likes' => 0],
        ]);

        Post::query()->insert([
            ['user_id' => 1, 'text' => 'Post 1', 'img' => '/images/posts/1.png', 'likes' => 0],
            ['user_id' => 1, 'text' => 'Post 2', 'img' => '/images/posts/2.png', 'likes' => 0],
        ]);

        Item::query()->insert([
            ['name' => '1 Likes', 'price' => 1],
            ['name' => '2 Likes', 'price' => 2],
            ['name' => '3 Likes', 'price' => 3],
            ['name' => '5 Likes', 'price' => 5],
            ['name' => '10 Likes', 'price' => 10],
            ['name' => '15 Likes', 'price' => 15],
            ['name' => '20 Likes', 'price' => 20],
            ['name' => '30 Likes', 'price' => 30],
            ['name' => '50 Likes', 'price' => 50],
            ['name' => '100 Likes', 'price' => 100],
            ['name' => '200 Likes', 'price' => 200],
            ['name' => '500 Likes', 'price' => 500],
        ]);

        User::query()->insert([
            [
                'email'       => 'admin@admin.pl',
                'password'    => '12345',
                'personaname' => 'Admin User',
                'avatarfull'  => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/96/967871835afdb29f131325125d4395d55386c07a_full.jpg',
            ],
            [
                'email'       => 'user@user.pl',
                'password'    => '123',
                'personaname' => 'User #1',
                'avatarfull'  => 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/86/86a0c845038332896455a566a1f805660a13609b_full.jpg',
            ],
        ]);
    }
};
