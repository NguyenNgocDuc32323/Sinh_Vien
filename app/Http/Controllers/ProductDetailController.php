<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $newPrds = $this->getNewPrd();
        $prd_id = $request->id;
        $product = $this->getProductDetail($prd_id);
        $relate_products = $this->getRelateProduct($product->category_name,$prd_id);
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view('User.product_detail', [
            'newPrds' => $newPrds,
            'product' => $product,
            'relate_products' => $relate_products,
            'user' => $user,
            'messages' => $messages
        ]);
    }
    public function getProductDetail($id){
        $product = $this->getProductsQuery()
                        ->where('products.id', $id)
                        ->firstOrFail();
        if ($product) {
            $this->processProducts([$product]);
        }
        return $product;
    }
    public function getProductsQuery()
    {
        return Product::leftJoin('product_category', 'product_category.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'product_category.category_id')
            ->leftJoin('labels', 'labels.id', '=', 'products.label_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->leftJoin('product_color', 'product_color.product_id', '=', 'products.id')
            ->leftJoin('colors', 'product_color.color_id', '=', 'colors.id')
            ->leftJoin('product_size','product_size.product_id','=','products.id')
            ->leftJoin('sizes','sizes.id','=','product_size.size_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'labels.name as label_name',
                DB::raw('GROUP_CONCAT(DISTINCT colors.name ORDER BY colors.name ASC) as color_names'),
                DB::raw('GROUP_CONCAT(DISTINCT colors.ratio_price ORDER BY colors.name ASC) as color_prices'),
                DB::raw('GROUP_CONCAT(DISTINCT sizes.name ORDER BY sizes.name ASC) as size_names'),
                DB::raw('GROUP_CONCAT(DISTINCT sizes.ratio_price ORDER BY sizes.name ASC) as size_prices'),
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
            //size and price
            $sizeNamesString = $product->size_names;
            $sizePricesString = $product->size_prices;

            $sizeNames = array_unique(explode(',', $sizeNamesString));
            $sizePrices = explode(',', $sizePricesString);

            $sizesWithPrices = [];
            foreach ($sizeNames as $index => $sizeName) {
                $sizesWithPrices[$sizeName] = isset($sizePrices[$index])? $sizePrices[$index] : null;
            }
            $product->sizes_with_prices = $sizesWithPrices;
        }
    }
    public function getNewPrd()
    {
        $newPrds = $this->getProductsQuery()
            ->orderBy('products.updated_at', 'DESC')
            ->limit(3)
            ->get();

        $this->processProducts($newPrds);
        return $newPrds;
    }
    public function getRelateProduct($category, $currentProductId)
{
    $relate_Product = $this->getProductsQuery()
        ->leftJoin('product_category as pc', 'products.id', '=', 'pc.product_id')
        ->leftJoin('categories as c', 'c.id', '=', 'pc.category_id')
        ->where('c.name', $category)
        ->where('products.id', '!=', $currentProductId)
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
