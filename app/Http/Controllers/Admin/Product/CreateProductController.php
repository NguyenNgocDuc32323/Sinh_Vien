<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Label;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CreateProductController extends Controller
{
    public function index(){
        $user = auth()->user();
        $categories = Category::all();
        $labels = Label::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view("Admin.create-product",[
            'categories' => $categories,
            'labels' => $labels,
            'colors' => $colors,
           'sizes' => $sizes,
           'user' => $user
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
    public function createProduct(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|lt:200.00',
        'quantity' => 'required|numeric|lt:1000',
        'category_id' => 'required|exists:categories,id',
        'label_id' => 'nullable|exists:labels,id',
        'colors' => 'required|array',
        'colors.*' => 'required|exists:colors,id',
        'sizes' => 'required|array',
        'sizes.*' => 'required|exists:sizes,id',
        'large_images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'small_images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $categoryFolder = Category::findOrFail($validated['category_id'])->name;

    $largeImages = [];
    if ($request->hasFile('large_images')) {
        foreach ($request->file('large_images') as $file) {
            $largeImages[] = $this->handleImageUpload($file, $categoryFolder);
        }
    }
    $largeImagesString = implode(',', $largeImages);

    $smallImages = [];
    if ($request->hasFile('small_images')) {
        foreach ($request->file('small_images') as $file) {
            $smallImages[] = $this->handleImageUpload($file, $categoryFolder);
        }
    }
    $smallImagesString = implode(',', $smallImages);

    $product = Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'label_id' => $validated['label_id'] ?? null,
        'image' => $largeImagesString,
        'images' => $smallImagesString,
        'order_number' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('product_category')->insert([
        'product_id' => $product->id,
        'category_id' => $validated['category_id'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    foreach ($validated['colors'] as $colorId) {
        DB::table('product_color')->insert([
            'product_id' => $product->id,
            'color_id' => $colorId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    foreach ($validated['sizes'] as $sizeId) {
        DB::table('product_size')->insert([
            'product_id' => $product->id,
            'size_id' => $sizeId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('manage-product')->with('success', 'Product created successfully');
    }
    public function handleImageUpload($file, $categoryFolder)
{
    if ($file) {
        $fileName = Str::random(10);
        $extension = $file->getClientOriginalExtension();
        $storedImage = $fileName . '.' . $extension;

        $storagePath = 'public/images/Products/' . $categoryFolder;
        $file->storeAs($storagePath, $storedImage);

        $sourcePath = storage_path('app/' . $storagePath . '/' . $storedImage);
        $destinationPath = public_path('images/Products/' . $categoryFolder . '/' . $storedImage);
        File::copy($sourcePath, $destinationPath);

        return 'images/Products/' . $categoryFolder . '/' . $storedImage;
    }
    return null;
    }
}
