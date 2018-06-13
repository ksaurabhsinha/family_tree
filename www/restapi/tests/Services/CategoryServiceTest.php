<?php

namespace Tests\Services;

use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{

    /** @var CategoryRepository|\PHPUnit_Framework_MockObject_MockObject $categoryRepositoryMock */
    private $categoryRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        $this->categoryRepositoryMock = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategoryTreeByParentId'])
            ->getMock();
    }

    public function testBuildTree()
    {
        $parentId = 0;

        $categories = [
            ['id' => 100, 'parent_id' => 0, 'name' => 'a'],
            ['id' => 101, 'parent_id' => 100, 'name' => 'a'],
            ['id' => 102, 'parent_id' => 101, 'name' => 'a'],
            ['id' => 103, 'parent_id' => 101, 'name' => 'a'],
        ];

        $this->categoryRepositoryMock->expects($this->once())
            ->method('getCategoryTreeByParentId')
            ->with($parentId)
            ->willReturn($categories);

        $categoryService = new CategoryService($this->categoryRepositoryMock);
        $expectedTree = '[{"id":100,"parent_id":0,"name":"a","children":[{"id":101,"parent_id":100,"name":"a","children":[{"id":102,"parent_id":101,"name":"a"},{"id":103,"parent_id":101,"name":"a"}]}]}]';

        $actualTree = $categoryService->getCategoryTree($parentId);

        $this->assertEquals($expectedTree, json_encode($actualTree));
    }
}
