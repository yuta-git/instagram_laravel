<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 100件のダミー投稿生成
        for($i = 1; $i <= 100; $i++) {
            DB::table('posts')->insert([
                'user_id' => 1,
                'title' => 'テストタイトル: ' . $i,
                'content' => 'テスト内容: ' . $i,
                'image' => '1.jpg'
            ]);
        }
    }
}
