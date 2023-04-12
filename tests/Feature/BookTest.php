<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 3:46 pm
*/

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BookTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_success_when_creating_a_book(): void
    {
        $data = [
            'name' => 'Harde should choose me',
            'isbn' => '0000-000-HARDE',
            'authors' => 'Adenagbe Emmanuel, Harde Emmanuel',
            'number_of_pages' => 25,
            'publisher' => 'emmadenagbe@gmail.com',
            'country' => 'Nigeria',
            'release_date' => '2023-04-12',
        ];

        $response = $this->postJson('/api/v1/books', $data);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(["status_code" => Response::HTTP_CREATED]);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_success_when_getting_all_books(): void
    {

        $response = $this->getJson('/api/v1/books');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["status_code" => Response::HTTP_OK]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_success_when_getting_filtered_books(): void
    {

        $response = $this->getJson('/api/v1/books?name=Asefon');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["status_code" => Response::HTTP_OK]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_error_when_getting_filtered_books(): void
    {

        $response = $this->getJson('/api/v1/books?wrongKey=Asefon');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["error" => "invalid search key supplied"]);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_single_book_when_is_fetched(): void
    {

        $response = $this->getJson('/api/v1/books/' . $this->book->id);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["status_code" => Response::HTTP_OK]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_error_when_book_was_updated(): void
    {
        $data = [
            'name' => 'Harde should choose me',
            'isbn' => '0000-000-HARDE',
            'authors' => 'Adenagbe Emmanuel, Harde Emmanuel',
            'number_of_pages' => 25,
            'publisher' => 'emmadenagbe@gmail.com',
            'country' => 'Nigeria',
            'release_date' => '2023-04-12',
        ];

        $response = $this->patchJson('/api/v1/books/' . 40, $data);
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(["error" => "Book to be updated not found"]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function return_Invalid_when_content_is_deleted(): void
    {

        $response = $this->getJson('/api/v1/external-books');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "error" => "Invalid Book name supplied"
            ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_error_when_wrong_data_is_supplied(): void
    {

        $response = $this->getJson('/api/v1/external-books/?name=' . "Wrong title of Kings");
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function returns_correct_from_External_api(): void
    {
        $query = "A Game of Thrones";
        $response = $this->getJson("/api/v1/external-books/?name=$query");
        $response->assertStatus(Response::HTTP_OK);

    }

}
