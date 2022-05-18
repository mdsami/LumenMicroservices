<?php

use App\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfBooks = 150;

        factory(Book::class, $numberOfBooks)->create();
    }
}
