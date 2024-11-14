<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageProductController extends Controller
{
    public function index(){
        $user = auth()->user();
        $products = $this->getAllPrd();
        return view("Admin.manage-product",[
            'user' => $user,
            'products' => $products
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('search-input');
        $productsQuery = $this->getProductsQuery()
            ->where(function ($q) use ($query) {
                $q->where('products.name', 'like', '%' . $query . '%')
                ->orWhere('products.price', 'like', '%' . $query. '%')
                ->orWhere('products.quantity', 'like', '%' . $query. '%')
                ->orWhere('categories.name', 'like', '%' . $query . '%')
                ->orWhere('labels.name', 'like', '%' . $query . '%')
                ->orWhere('colors.name', 'like', '%' . $query . '%')
                ->orWhere('colors.ratio_price', 'like', '%' . $query . '%')
                ->orWhere('sizes.name', 'like', '%' . $query . '%')
                ->orWhere('sizes.ratio_price', 'like', '%' . $query . '%')
                ->orWhere('reviews.comment','like', '%' . $query . '%')
                ->orWhere('products.created_at','like', '%' . $query . '%')
                ->orWhere('products.updated_at','like', '%' . $query . '%');
            })
            ->orderBy('products.updated_at', 'DESC');
        $products = $productsQuery->paginate(5);
        $this->processProducts($products);
        $user = auth()->user();
        return view('Admin.manage-product', compact('products', 'user'));
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
                DB::raw('AVG(reviews.stars) as product_reviews'),
                DB::raw('GROUP_CONCAT(DISTINCT reviews.comment ORDER BY reviews.updated_at DESC) as product_comments')
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
    public function getAllPrd()
    {
        $products = $this->getProductsQuery()
            ->orderBy('products.updated_at', 'DESC')
            ->paginate(5);
        $this->processProducts($products);
        return $products;
    }
    public function delete($id){
        $product = Product::findOrFail($id);
        if($product){
            $check_delete = $product->delete();
            if($check_delete){
                return redirect()->route('manage-product')->with('success','Delete product successfully!');
            }else{
                return redirect()->route('manage-product')->with('error','Delete product failed!');
            }
        } else {
            return redirect()->route('manage-product')->with('error','Product not found!');
        }
    }
}
