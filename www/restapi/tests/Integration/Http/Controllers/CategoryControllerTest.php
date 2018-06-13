<?php

namespace Tests\Integration\Http\Controllers;

use Tests\TestCaseIntegration;

class CategoryControllerTest extends TestCaseIntegration
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param array $inputParams
     * @param array $expectedResponse
     *
     * @dataProvider createFailProvider
     */
    public function testCreateWillFailForRequiredFields(array $inputParams, array $expectedResponse)
    {
        $this->json('post', '/api/v1/categories', $inputParams)->seeJsonEquals($expectedResponse);
    }

    public function createFailProvider(): array
    {
        return [
            'Name required error'       => [
                [
                    'is_visible' => '1',
                ],
                [
                    "name" => ['The name field is required.'],
                ],
            ],
            'Is Visible required error' => [
                [
                    'name' => '1',
                ],
                [
                    "is_visible" => ['The is visible field is required.'],
                ],
            ],
        ];
    }

    public function testCreateSuccess()
    {
        $this->json('post', '/api/v1/categories', [
            'name'       => 'Category 1',
            'is_visible' => '1',
        ])->seeJsonEquals(['created' => 'success']);
    }

    public function testGetOneById()
    {
        $response = $this->call('get', '/api/v1/categories/1');

        $this->assertEquals(200, $response->status());
    }

    public function testGetAll()
    {
        $response = $this->call('get', '/api/v1/categories');

        $this->assertEquals(200, $response->status());
    }

    /**
     * @param array $inputParams
     * @param array $expectedResponse
     *
     * @dataProvider updateFailProvider
     */
    public function testUpdateVisibilityFailsForRequiredParams(array $inputParams, array $expectedResponse)
    {
        $this->json('patch', '/api/v1/categories/1', $inputParams)->seeJsonEquals($expectedResponse);
    }

    public function updateFailProvider(): array
    {
        return [
            'Is Visible required error' => [
                [],
                [
                    "is_visible" => ['The is visible field is required.'],
                ],
            ],
        ];
    }

    public function testUpdateVisibilityReturnsUnprocessableEntity()
    {
        $response = $this->call('patch', '/api/v1/categories/1');

        $this->assertEquals(422, $response->status());
    }

    public function testUpdateVisibilityReturnsZeroWhenNothingToUpdate()
    {
        $this->json('patch', '/api/v1/categories/1', [
            'is_visible' => '1',
        ])->seeJsonEquals(['status' => 0]);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}