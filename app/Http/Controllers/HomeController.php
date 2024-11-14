<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
{
    $slides = Slider::all();
    $ppProducts = $this->getProducts('PP');
    $petProducts = $this->getProducts('PET');
    $pcProducts = $this->getProducts('PC');
    $top_Ads = $this->getAds(3);
    $down_Ads = $this->getAds(6);
    $bestSellerPrds = $this->getBestSellerPrd();
    $user = auth()->user();
    $messages = [];
    if ($user) {
        $messages = $this->getMessage($user);
    }

    return view("layouts.home", [
        "slides" => $slides,
        "ppProducts" => $ppProducts,
        "petProducts" => $petProducts,
        "pcProducts" => $pcProducts,
        "top_Ads" => $top_Ads,
        "down_Ads" => $down_Ads,
        'bestSellerPrds' => $bestSellerPrds,
        'search' => null,
        'user' => $user,
        'messages' => $messages
    ]);
    }

    public function getProducts($category)
    {
        $products = ProductCategory::join('products', 'products.id', '=', 'product_category.product_id')
            ->join('categories', 'categories.id', '=', 'product_category.category_id')
            ->leftJoin('labels', 'labels.id', '=', 'products.label_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'labels.name as label_name',
                DB::raw('AVG(reviews.stars) as product_reviews')
            )
            ->where('categories.name', 'like', $category . '%')
            ->groupBy('products.id', 'categories.name', 'labels.name')
            ->orderBy('products.updated_at', 'DESC')
            ->get();
        foreach ($products as $product) {
            $imagesString = $product->image;
            $imageUrls = explode(',', $imagesString);
            $product->image = $imageUrls;
        }
        return $products;
    }
    public function getBestSellerPrd()
    {
        $bestSellerPrd = Product::join('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_category', 'product_category.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'product_category.category_id')
            ->leftJoin('labels', 'labels.id', '=', 'products.label_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'labels.name as label_name',
                DB::raw('AVG(reviews.stars) as product_reviews'),
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->groupBy('products.id', 'categories.name', 'labels.name')
            ->orderBy('total_sold', 'DESC')
            ->limit(5)
            ->get();
        foreach ($bestSellerPrd as $product) {
            $imagesString = $product->image;
            $imageUrls = explode(',', $imagesString);
            $product->image = $imageUrls;
        }
        return $bestSellerPrd;
    }
    public function getAds($limit)
    {
        $ads = Ads::limit($limit)->orderBy('updated_at', 'DESC')->get();
        return $ads;
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
    public function searchProduct(Request $request)
{
    $searchQuery = $request->query("search");
    $productsQuery = $this->getProductsQuery();
    $search = null;
    if ($searchQuery) {
        $search = $searchQuery;
        $productsQuery->where(function ($query) use ($searchQuery) {
            $query->where('products.name', 'LIKE', "%$searchQuery%")
                ->orWhere('products.price', 'LIKE', "%$searchQuery%")
                ->orWhere('categories.name', 'LIKE', "%$searchQuery%")
                ->orWhere('labels.name', 'LIKE', "%$searchQuery%")
                ->orWhere('colors.name', 'LIKE', "%$searchQuery%");
        });
        $products = $productsQuery->paginate(10);
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view("layouts.home", [
            'products' => $products,
            'search' => $search,
            'slides' => [],
            'ppProducts' => [],
            'petProducts' => [],
            'pcProducts' => [],
            'top_Ads' => [],
            'down_Ads' => [],
            'bestSellerPrds' => [],
            'user' => $user,
            'messages' => $messages
        ]);
    } else {
        $slides = Slider::all();
        $ppProducts = $this->getProducts('PP');
        $petProducts = $this->getProducts('PET');
        $pcProducts = $this->getProducts('PC');
        $top_Ads = $this->getAds(3);
        $down_Ads = $this->getAds(6);
        $bestSellerPrds = $this->getBestSellerPrd();
        $products = collect();
        $user = auth()->user();
        $messages = [];
        if ($user) {
            $messages = $this->getMessage($user);
        }
        return view("layouts.home", [
            'slides' => $slides,
            'ppProducts' => $ppProducts,
            'petProducts' => $petProducts,
            'pcProducts' => $pcProducts,
            'top_Ads' => $top_Ads,
            'down_Ads' => $down_Ads,
            'bestSellerPrds' => $bestSellerPrds,
            'products' => $products,
            'search' => $search,
            'user' => $user,
            'messages' => $messages
        ]);
    }
    }
    public function sendFeedbackForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|digits:10',
            'content' => 'required|string',
            'title' => 'required|string'
        ]);
        $data = $request->only('name', 'email', 'phone', 'content', 'title');
        $newContact = Contact::create($data);
        if($newContact){
            return redirect()->route('home')->with('success', 'Thank you for Feedback Information!');
        }
        return redirect()->route('home')->with('error', 'Failed to send your message. Please try again later.');
    }
    public function uploadImage(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('images/Contact'), $fileName);

        $relativePath = 'images/Contact/' . $fileName;

        return response()->json([
            'fileName' => $fileName,
            'uploaded' => 1,
            'url' => $relativePath
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => ['message' => 'No file uploaded or file size too large.']
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
