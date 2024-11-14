<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(){
        $relate_products = $this->getRelateProduct();
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view("User.cart",[
            'relate_products' => $relate_products,
            'user' => $user,
            'messages' => $messages
        ]);
    }
    public function getProductsQuery()
    {
        return Product::leftJoin('product_category', 'product_category.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'product_category.category_id')
            ->leftJoin('labels', 'labels.id', '=', 'products.label_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->leftJoin('product_color', 'product_color.product_id', '=', 'products.id')
            ->leftJoin('colors', 'product_color.color_id', '=', 'colors.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'labels.name as label_name',
                DB::raw('GROUP_CONCAT(DISTINCT colors.name ORDER BY colors.name ASC) as color_names'),
                DB::raw('GROUP_CONCAT(DISTINCT colors.ratio_price ORDER BY colors.name ASC) as color_prices'),
                DB::raw('AVG(reviews.stars) as product_reviews')
            )
            ->groupBy('products.id', 'categories.name', 'labels.name');
    }
    public function processProducts($products)
    {
        foreach ($products as $product) {
            // image url
            $imagesString = $product->image;
            $imageUrls = explode(',', $imagesString);
            $product->image = array_filter($imageUrls);
            //images url
            $imagesManyString = $product->images;
            $imagesManyUrls = explode(',', $imagesManyString);
            $product->images = array_filter($imagesManyUrls);
            //color and price
            $colorNamesString = $product->color_names;
            $colorPricesString = $product->color_prices;

            $colorNames = array_unique(explode(',', $colorNamesString));
            $colorPrices = explode(',', $colorPricesString);

            $colorsWithPrices = [];
            foreach ($colorNames as $index => $colorName) {
                $colorsWithPrices[$colorName] = isset($colorPrices[$index]) ? $colorPrices[$index] : null;
            }
            $product->colors_with_prices = $colorsWithPrices;
        }
    }
    public function getRelateProduct()
{
    $relate_Product = $this->getProductsQuery()
        ->leftJoin('product_category as pc', 'products.id', '=', 'pc.product_id')
        ->leftJoin('categories as c', 'c.id', '=', 'pc.category_id')
        ->inRandomOrder()
        ->take(5)
        ->orderBy('products.updated_at', 'DESC')
        ->get();

    if ($relate_Product->isNotEmpty()) {
        $this->processProducts($relate_Product);
    }

    return $relate_Product;
    }
    public function getMessage($user) {
        $contacts = Contact::where('email', $user->email)->get();
        if ($contacts->isEmpty()) {
            return collect([]);
        }
        $contactIds = $contacts->pluck('id');
        $messages = ContactReply::whereIn('contact_id', $contactIds)->get();
        if ($messages->isEmpty()) {
            return collect([]);
        }
        return $messages;
    }
}

