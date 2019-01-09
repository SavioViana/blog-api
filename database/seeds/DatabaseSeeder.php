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

        DB::table('users')->insert([
            'name' => str_random(8),
            'email' => str_random(8) . '@gmail.com',
            'password' => str_random(6),
            'remember_token' => str_random(100),
        ]);
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10) . '@gmail.com',
            'password' => str_random(6),
            'remember_token' => str_random(100),
        ]);

        DB::table('tags')->insert([
            'name' => str_random(5),
        ]);
        DB::table('tags')->insert([
            'name' => str_random(5),
        ]);

        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Title Post One',
            'slug' => 'title-post-onde',
            'body' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquet ultrices mauris eu ultricies. Aliquam dapibus elit eget orci sagittis mattis. Vestibulum ultricies mi a metus porta scelerisque. Nullam luctus ex nisl. Nullam neque velit, faucibus nec ante non, commodo posuere magna. Sed auctor viverra justo eget tempus. Nam rhoncus quam at neque euismod, sed fermentum lectus dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam libero diam, tristique ut eleifend ut, tempus id leo.",
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Title Post Two',
            'slug' => 'title-post-two',
            'body' => "Vestibulum pharetra malesuada elit, semper dignissim mauris convallis in. Integer malesuada vel ante et malesuada. Vestibulum maximus, orci sed dapibus dapibus, leo nisi bibendum purus, nec venenatis diam nulla vitae augue. Etiam tincidunt non quam ac vulputate. Donec vel diam velit. Pellentesque et cursus magna, quis tempor neque. Aenean fringilla arcu quis mi vestibulum, vitae dictum tellus rhoncus. Integer tempor mollis diam, sit amet sagittis quam. Pellentesque lacinia quis magna pharetra aliquet. Nullam felis orci, lobortis vel rutrum ac, eleifend nec purus. Nulla fermentum ex ac sagittis congue. Donec congue sapien nunc, non congue massa cursus ut. Curabitur placerat porta tempor. Mauris ultrices molestie rutrum. In fringilla mi vel velit fermentum, et dictum eros aliquam. Etiam id luctus ex.",
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => 'Title Post Three',
            'slug' => 'title-post-three',
            'body' => "Praesent vel hendrerit diam. Nunc dignissim odio ac nulla tincidunt, sit amet sollicitudin sapien facilisis. Donec eleifend congue mattis. Praesent egestas et mi eu mollis. Suspendisse gravida tellus quis sapien tempus, a mollis neque interdum. Aenean euismod luctus odio, quis vehicula lorem tempor ut. Praesent ullamcorper facilisis dolor. Maecenas ex libero, pretium sollicitudin dignissim quis, semper scelerisque justo. Ut eget condimentum lacus, sed dictum lorem. Nunc sed congue justo. Praesent pellentesque tincidunt ante, nec facilisis est tincidunt ac. Sed vehicula, purus sit amet sagittis pharetra, nisi neque molestie lacus, ut ullamcorper nunc purus at diam. Vivamus sit amet felis et ante mattis rutrum. Praesent diam lectus, pulvinar ut lacus vitae, imperdiet tempus dolor.",
            'image' => 'image-'.str_random(5).'.jpg',
            'published' => True
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'title' => 'Title Post Four',
            'slug' => 'title-post-four',
            'body' => "Quisque malesuada tellus eu enim sodales vehicula. Nullam rhoncus sagittis elit, eget faucibus erat dignissim sit amet. Morbi pulvinar, dui a bibendum tincidunt, ante sapien aliquet enim, et tempus leo quam sed leo. Suspendisse viverra blandit justo, at auctor justo aliquam vitae. Pellentesque lacinia erat vel dui euismod elementum. Morbi ultrices tempus arcu pulvinar condimentum. Sed bibendum ante in tellus venenatis malesuada. In odio nisi, cursus in maximus et, interdum non massa. Ut sem risus, finibus eu aliquam id, ultrices ac magna. Morbi pellentesque viverra vestibulum. Fusce posuere sapien ut viverra varius. Aenean semper elit ut ligula congue, at sagittis sem interdum. Sed imperdiet id lacus vel interdum. In condimentum metus vel viverra malesuada. Mauris sagittis molestie massa, eu placerat odio laoreet",
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
