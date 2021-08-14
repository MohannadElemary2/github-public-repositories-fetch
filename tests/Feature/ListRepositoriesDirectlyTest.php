<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class ListRepositoriesDirectlyTest extends TestCase
{

    const ROUTE_LIST = 'repository.getDirectly';

    protected function setUp(): void
    {
        parent::setUp();
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
