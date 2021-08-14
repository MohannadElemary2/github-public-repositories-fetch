<?php

namespace Tests\Feature;

use App\Models\Repository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class ListRepositoriesFromSystemTest extends TestCase
{
    use DatabaseMigrations;

    const ROUTE_LIST = 'repository.getFromSystem';

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    /**
     * @test 
     */
    public function will_fail_if_creation_date_is_missing()
    {
        $response = $this->json(
            'GET',
            route(self::ROUTE_LIST)
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonValidationErrors('created');
    }

    /**
     * @test 
     */
    public function will_fail_if_invalid_per_page_sent()
    {
        $response = $this->json(
            'GET',
            route(self::ROUTE_LIST),
            [
                'per_page' => 'invalid',
                'page' => 1,
                'created' => '2021-10-01',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonValidationErrors('per_page');
    }

    /**
     * @test 
     */
    public function will_get_data_successfully()
    {
        $response = $this->json(
            'GET',
            route(self::ROUTE_LIST),
            [
                'per_page' => 10,
                'page' => 1,
                'created' => '2021-10-01',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);

        $this->assertArrayHasKey('data', $response->json());
    }
}
