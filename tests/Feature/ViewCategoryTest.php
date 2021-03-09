<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_all_categories()
    {
        $this->withoutExceptionHandling();
        $category1 = Category::factory()->create(['name' => '기초']);
        Category::factory(1)->create(['name' => '스킨케어', 'category_id' => $category1->id])
            ->each(function ($category) {
                $category->categories()->saveMany([
                    Category::factory()->create(['name' => '스킨']),
                    Category::factory()->create(['name' => '미스터'])
                ]);
            });
        Category::factory(1)->create(['name' => '클렌징', 'category_id' => $category1->id])
            ->each(function ($category) {
                $category->categories()->saveMany([
                    Category::factory()->create(['name' => '클렌징폼']),
                    Category::factory()->create(['name' => '립&아이 리무버'])
                ]);
        });

        $category2 = Category::factory()->create(['name' => '메이크업']);
        Category::factory()->create(['name' => '페이스', 'category_id' => $category2->id]);
        Category::factory()->create(['name' => '립', 'category_id' => $category2->id]);

        $response = $this->json('GET', '/api/categories');

        $response->assertStatus(200);
        $response->assertJson(
        [
            [
                'name' => '기초',
                'categories' =>
                [
                    [
                        'name' => '스킨케어',
                        'categories' =>
                        [
                            ['name' => '스킨'],
                            ['name' => '미스터']
                        ]
                    ],
                    [
                        'name' => '클렌징',
                        'categories' =>
                        [
                            ['name' => '클렌징폼'],
                            ['name' => '립&아이 리무버']
                        ]
                    ]
                ]
            ],
            [
                'name' => '메이크업',
                'categories' =>
                [
                    ['name' => '페이스'],
                    ['name' => '립']
                ]
            ]
        ]);
    }
}
