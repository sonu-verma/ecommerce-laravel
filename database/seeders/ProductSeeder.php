<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'category_name' => 'Electronics',
                'name' => 'Smartphone X1',
                'description' => 'Latest smartphone with advanced features, high-resolution camera, and long battery life.',
                'price' => 599.99,
                'sale_price' => 549.99,
                'stock_quantity' => 50,
                'sku' => 'ELEC-SMART-X1',
                'is_featured' => true,
                'weight' => 0.18,
                'dimensions' => '15.5x7.5x0.8',
            ],
            [
                'category_name' => 'Electronics',
                'name' => 'Laptop Pro',
                'description' => 'Professional laptop with powerful processor, large storage, and high-performance graphics.',
                'price' => 1299.99,
                'stock_quantity' => 25,
                'sku' => 'ELEC-LAPTOP-PRO',
                'is_featured' => true,
                'weight' => 2.1,
                'dimensions' => '35x24x2',
            ],
            [
                'category_name' => 'Electronics',
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation and long battery life.',
                'price' => 199.99,
                'sale_price' => 179.99,
                'stock_quantity' => 100,
                'sku' => 'ELEC-HEAD-WIRE',
                'weight' => 0.25,
                'dimensions' => '18x16x8',
            ],

            // Clothing
            [
                'category_name' => 'Clothing',
                'name' => 'Cotton T-Shirt',
                'description' => 'Comfortable cotton t-shirt available in multiple colors and sizes.',
                'price' => 24.99,
                'stock_quantity' => 200,
                'sku' => 'CLOTH-TSHIRT-COT',
                'weight' => 0.15,
                'dimensions' => '30x25x2',
            ],
            [
                'category_name' => 'Clothing',
                'name' => 'Denim Jeans',
                'description' => 'Classic denim jeans with perfect fit and durability.',
                'price' => 79.99,
                'sale_price' => 69.99,
                'stock_quantity' => 150,
                'sku' => 'CLOTH-JEANS-DEN',
                'is_featured' => true,
                'weight' => 0.4,
                'dimensions' => '35x30x3',
            ],

            // Home & Garden
            [
                'category_name' => 'Home & Garden',
                'name' => 'Coffee Maker',
                'description' => 'Automatic coffee maker with programmable timer and multiple brewing options.',
                'price' => 89.99,
                'stock_quantity' => 75,
                'sku' => 'HOME-COFFEE-AUTO',
                'weight' => 1.2,
                'dimensions' => '25x15x35',
            ],
            [
                'category_name' => 'Home & Garden',
                'name' => 'Garden Tool Set',
                'description' => 'Complete garden tool set with ergonomic handles and durable construction.',
                'price' => 149.99,
                'stock_quantity' => 30,
                'sku' => 'HOME-GARDEN-TOOL',
                'is_featured' => true,
                'weight' => 2.5,
                'dimensions' => '50x30x15',
            ],

            // Books
            [
                'category_name' => 'Books',
                'name' => 'Programming Guide',
                'description' => 'Comprehensive guide to modern programming languages and best practices.',
                'price' => 49.99,
                'stock_quantity' => 100,
                'sku' => 'BOOK-PROG-GUIDE',
                'weight' => 0.8,
                'dimensions' => '23x15x3',
            ],
            [
                'category_name' => 'Books',
                'name' => 'Fiction Novel',
                'description' => 'Bestselling fiction novel with captivating storyline and memorable characters.',
                'price' => 19.99,
                'sale_price' => 15.99,
                'stock_quantity' => 200,
                'sku' => 'BOOK-FICTION-NOV',
                'weight' => 0.4,
                'dimensions' => '20x13x2',
            ],

            // Sports & Outdoors
            [
                'category_name' => 'Sports & Outdoors',
                'name' => 'Running Shoes',
                'description' => 'Professional running shoes with advanced cushioning and breathable design.',
                'price' => 129.99,
                'stock_quantity' => 80,
                'sku' => 'SPORT-SHOES-RUN',
                'is_featured' => true,
                'weight' => 0.3,
                'dimensions' => '30x12x12',
            ],
            [
                'category_name' => 'Sports & Outdoors',
                'name' => 'Yoga Mat',
                'description' => 'Premium yoga mat with non-slip surface and comfortable thickness.',
                'price' => 39.99,
                'stock_quantity' => 120,
                'sku' => 'SPORT-YOGA-MAT',
                'weight' => 0.8,
                'dimensions' => '180x60x0.5',
            ],

            // Beauty & Health
            [
                'category_name' => 'Beauty & Health',
                'name' => 'Facial Cleanser',
                'description' => 'Gentle facial cleanser suitable for all skin types with natural ingredients.',
                'price' => 29.99,
                'stock_quantity' => 150,
                'sku' => 'BEAUTY-CLEAN-FAC',
                'weight' => 0.2,
                'dimensions' => '8x5x15',
            ],
            [
                'category_name' => 'Beauty & Health',
                'name' => 'Vitamin Supplements',
                'description' => 'Complete multivitamin supplement for daily health and wellness.',
                'price' => 34.99,
                'sale_price' => 29.99,
                'stock_quantity' => 200,
                'sku' => 'BEAUTY-VITAMIN-MULTI',
                'is_featured' => true,
                'weight' => 0.1,
                'dimensions' => '6x4x8',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category_name'])->first();
            
            if ($category) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'] ?? null,
                    'stock_quantity' => $product['stock_quantity'],
                    'sku' => $product['sku'],
                    'is_active' => true,
                    'is_featured' => $product['is_featured'] ?? false,
                    'weight' => $product['weight'],
                    'dimensions' => $product['dimensions'],
                ]);
            }
        }
    }
}
