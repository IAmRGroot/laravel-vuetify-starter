<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 * @covers \App\Http\Controllers\VueController
 */
class VuePageTest extends TestCase
{
    /**
     * @dataProvider routeProvider
     */
    public function testVueHtmlRoutes(string $route, int $status)
    {
        $response = $this->get($route);
        $response->assertStatus($status);
    }

    public function routeProvider(): array
    {
        return [
            ['/', Response::HTTP_OK],
            ['home', Response::HTTP_OK],
            ['login', Response::HTTP_OK],
            ['test123', Response::HTTP_OK],
            ['api/test123', Response::HTTP_NOT_FOUND],
            ['async/test123', Response::HTTP_NOT_FOUND],
            ['assets/test123', Response::HTTP_NOT_FOUND],
        ];
    }
}
