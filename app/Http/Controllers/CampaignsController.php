<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class CampaignsController extends Controller
{

    public function Coupon()
    {
        $products = File::get('products.json');
        $products = json_decode($products);

        return view('coupon', compact('products'));
    }

    public function OnTop()
    {
        $categories = array();
        $products = File::get('products.json');
        $products = json_decode($products);
        foreach ($products as $product) {
            $categories[$product->category][] =[
            "name" => $product->name,
            "price" => $product->price,
            ];
        }
        // return $categories["Clothing"];
        return view('ontop', compact('products', 'categories'));
    }

    public function Seasonal()
    {
        $products = File::get('products.json');
        $products = json_decode($products);

        return view('seasonal', compact('products'));
    }

}
