<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
        [
            'code' => 'a001',
            'name' => 'สิ้นค้าA1',
            'price' => '1500'
        ],
        [
            'code' => 'a002',
            'name' => 'สิ้นค้าA2',
            'price' => '1000'
        ],
        [
            'code' => 'a003',
            'name' => 'สิ้นค้าA3',
            'price' => '800'
        ],
        [
            'code' => 'a004',
            'name' => 'สิ้นค้าA4',
            'price' => '2500'
        ]];

        foreach($products as $keys=>$values){
            Product::create($values);
        }
    }
}
