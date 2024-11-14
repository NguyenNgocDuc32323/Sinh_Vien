<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
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
    public function getAllProducts()
    {
        $products = $this->getProductsQuery()
            ->orderBy('products.updated_at', 'DESC')
            ->paginate(12);

        $this->processProducts($products);
        return $products;
    }
    public function index()
    {
        session()->forget('search_history');
        $newPrds = $this->getNewPrd();
        $products = $this->getAllProducts();
        $searchHistory = session()->get('search_history', []);
        $user = auth()->user();
        $colors = Color::all();
        $categories = Category::all();
        $sizes = Size::all();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view('User.shop', [
            'newPrds' => $newPrds,
            'products' => $products,
            'searchHistory' => $searchHistory,
            'user' => $user,
            'messages' => $messages,
            'colors' => $colors,
            'categories' => $categories,
            'sizes' => $sizes,
        ]);
    }
    public function filterByCategory(Request $request)
{
    $category = $request->input('category');
    $products = $this->getProductsQuery()
        ->where('categories.name', $category)
        ->orderBy('products.updated_at', 'DESC')
        ->paginate(12);

    $this->processProducts($products);
    $newPrds = $this->getNewPrd();
    session()->put('search_history', [
        'category' => $category,
        'timestamp' => now()
    ]);

    $user = auth()->user();
    $messages = [];
    if ($user) {
        $messages = $this->getMessage($user);
    }
    $categories = Category::all();
    $colors = Color::all();
    $sizes = Size::all();
    return view('User.shop', [
        'newPrds' => $newPrds,
        'products' => $products,
        'searchHistory' => session()->get('search_history'),
        'user' => $user,
        'messages' => $messages,
        'categories' => $categories,
        'colors' => $colors,
        'sizes' => $sizes,
    ]);
    }
    public function filterByColor(Request $request)
{
    $selectedColors = $request->input('colors', []);
    $products = $this->getProductsQuery()
        ->when($selectedColors, function ($query, $selectedColors) {
            return $query->whereIn('colors.name', $selectedColors);
        })
        ->orderBy('products.updated_at', 'DESC')
        ->paginate(12);

    $this->processProducts($products);
    $newPrds = $this->getNewPrd();
    session()->put('search_history', [
        'colors' => $selectedColors,
        'timestamp' => now()
    ]);

    $user = auth()->user();
    $messages = [];
    if ($user) {
        $messages = $this->getMessage($user);
    }
    $categories = Category::all();
    $colors = Color::all();
    $sizes = Size::all();
    return view('User.shop', [
        'newPrds' => $newPrds,
        'products' => $products->appends(['colors' => $selectedColors]),
        'selectedColors' => $selectedColors,
        'searchHistory' => session()->get('search_history'),
        'user' => $user,
        'messages' => $messages,
        'categories' => $categories,
        'colors' => $colors,
        'sizes' => $sizes,
    ]);
    }
    public function filterBySize(Request $request)
{
    $selectedSizes = $request->input('sizes', []);
    $products = $this->getProductsQuery()
        ->when($selectedSizes, function ($query, $selectedSizes) {
            return $query->whereIn('sizes.name', $selectedSizes);
        })
        ->orderBy('products.updated_at', 'DESC')
        ->paginate(12);

    $this->processProducts($products);
    $newPrds = $this->getNewPrd();
    session()->put('search_history', [
        'sizes' => $selectedSizes,
        'timestamp' => now()
    ]);

    $user = auth()->user();
    $messages = [];
    if ($user) {
        $messages = $this->getMessage($user);
    }
    $categories = Category::all();
    $sizes = Size::all();
    $colors = Color::all();
    return view('User.shop', [
        'newPrds' => $newPrds,
        'products' => $products->appends(['sizes' => $selectedSizes]),
        'selectedSizes' => $selectedSizes,
        'searchHistory' => session()->get('search_history'),
        'user' => $user,
        'messages' => $messages,
        'categories' => $categories,
        'sizes' => $sizes,
        'colors' => $colors,
    ]);
    }
    public function filterByPrice(Request $request)
    {
        $minPrice = 0;
        $maxPrice = $request->input('price', null);
        session()->put('search_history', [
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'timestamp' => now()
        ]);

        $products = $this->getProductsQuery()
            ->when($maxPrice !== null, function ($query) use ($minPrice, $maxPrice) {
                return $query->whereBetween('products.price', [$minPrice, $maxPrice]);
            })
            ->orderBy('products.updated_at', 'DESC')
            ->paginate(12);

        $this->processProducts($products);
        $newPrds = $this->getNewPrd();
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('User.shop', [
            'newPrds' => $newPrds,
            'products' => $products->appends(['price_max' => $maxPrice]),
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'searchHistory' => session()->get('search_history'),
            'user' => $user,
            'messages' => $messages,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
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
