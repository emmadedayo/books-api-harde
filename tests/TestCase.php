<?php

namespace Tests;

use App\Models\Book;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $book;

    public function setUp(): void
    {
        parent::setUp();
        /**
         * This disables the exception handling to display the stacktrace on the console
         * the same way as it shown on the browser
         */
       // $this->disableExceptionHandling();

        \Artisan::call('migrate');

        $books = Book::factory(10)->make();
        $this->book = $books[0];
    }

}
