<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 product seeder contain name,quantity,price, description 
        $products = [
            [
                "name" => "Book",
                "quantity" => 10,
                "price" => 10000,
                "description" => "This is a book"
            ],
            [
                "name" => "Pen",
                "quantity" => 20,
                "price" => 5000,
                "description" => "This is a pen"
            ],
            [
                "name" => "Pencil",
                "quantity" => 30,
                "price" => 3000,
                "description" => "This is a pencil"
            ],
            [
                "name" => "Eraser",
                "quantity" => 40,
                "price" => 2000,
                "description" => "This is a eraser"
            ],
            [
                "name" => "Ruler",
                "quantity" => 50,
                "price" => 1000,
                "description" => "This is a ruler"
            ],
            [
                "name" => "Notebook",
                "quantity" => 60,
                "price" => 5000,
                "description" => "This is a notebook"
            ],
            [
                "name" => "Stapler",
                "quantity" => 70,
                "price" => 10000,
                "description" => "This is a stapler"
            ],
            [
                "name" => "Staple",
                "quantity" => 80,
                "price" => 1000,
                "description" => "This is a staple"
            ],
            [
                "name" => "Scissors",
                "quantity" => 90,
                "price" => 5000,
                "description" => "This is a scissors"
            ],
            [
                "name" => "Tape",
                "quantity" => 100,
                "price" => 10000,
                "description" => "This is a tape"
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
