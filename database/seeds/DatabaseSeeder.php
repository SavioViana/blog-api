<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('authors')->insert([
            'name' => str_random(10),
        ]);
        DB::table('authors')->insert([
            'name' => str_random(10),
        ]);

        DB::table('tags')->insert([
            'name' => str_random(5),
        ]);
        DB::table('tags')->insert([
            'name' => str_random(5),
        ]);

        DB::table('posts')->insert([
            'author_id' => 1,
            'title' => 'Title Post One',
            'slug' => 'title-post-onde',
            'body' => str_random(500),
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'author_id' => 1,
            'title' => 'Title Post Two',
            'slug' => 'title-post-two',
            'body' => str_random(500),
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'author_id' => 1,
            'title' => 'Title Post Three',
            'slug' => 'title-post-three',
            'body' => str_random(500),
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'author_id' => 2,
            'title' => 'Title Post Four',
            'slug' => 'title-post-four',
            'body' => str_random(500),
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);

        DB::table('post_tag')->insert([
            'post_id' => 1,
            'tag_id' => 1
        ]);
        DB::table('post_tag')->insert([
            'post_id' => 1,
            'tag_id' => 2
        ]);
        DB::table('post_tag')->insert([
            'post_id' => 2,
            'tag_id' => 1
        ]);
        DB::table('post_tag')->insert([
            'post_id' => 3,
            'tag_id' => 2
        ]);

    }
}
