<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest electronic gadgets and devices',
                'sort_order' => 1,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel for all ages',
                'sort_order' => 2,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Everything for your home and garden',
                'sort_order' => 3,
            ],
            [
                'name' => 'Books',
                'description' => 'Books, magazines, and educational materials',
                'sort_order' => 4,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'sort_order' => 5,
            ],
            [
                'name' => 'Beauty & Health',
                'description' => 'Beauty products and health supplements',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}
