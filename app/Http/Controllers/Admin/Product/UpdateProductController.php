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
use Illuminate\Support\Facades\Hash;

class UpdateProductController extends Controller
{
    public function update($id){
        $user = auth()->user();
        $product = $this->getProductsQuery()
        ->where('products.id', $id)
        ->firstOrFail();
        $this->processProducts([$product]);
        $categories = Category::all();
        $labels = Label::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('Admin.update-product', [
            'user' => $user,
            'product' => $product,
            'categories' => $categories,
            'labels' => $labels,
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }
    public function updateDetailPost($id, Request $request)
{
    $product = Product::findOrFail($id);

    if (!$product) {
        return redirect()->back()->withErrors(['error' => 'Product not found']);
    }
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|lt:200.00',
        'quantity' => 'required|numeric|lt:1000',
        'category_id' => 'required|exists:categories,id',
        'label_id' => 'nullable|exists:labels,id',
        'colors' => 'nullable|array',
        'colors.*' => 'exists:colors,id',
        'sizes' => 'nullable|array',
        'sizes.*' => 'exists:sizes,id',
    ]);

    $product->name = $validated['name'];
    $product->price = $validated['price'];
    $product->quantity = $validated['quantity'];
    $product->label_id = $validated['label_id'] ?? $product->label_id;
    $product->save();
    $existing = DB::table('product_category')
        ->where('product_id', $id)
        ->first();

    $createdAt = $existing ? $existing->created_at : now();
    $categoryId = $validated['category_id'];
    DB::table('product_category')
        ->where('product_id', $id)
        ->delete();

    DB::table('product_category')->insert([
        'product_id' => $id,
        'category_id' => $categoryId,
        'created_at' => $createdAt,
        'updated_at' => now(),
    ]);

    // Update colors
    $colorIds = $validated['colors'] ?? [];
    DB::table('product_color')
        ->where('product_id', $id)
        ->delete();

    foreach ($colorIds as $colorId) {
        DB::table('product_color')->insert([
            'product_id' => $id,
            'color_id' => $colorId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Update sizes
    $sizeIds = $validated['sizes'] ?? [];
    DB::table('product_size')
        ->where('product_id', $id)
        ->delete();

    foreach ($sizeIds as $sizeId) {
        DB::table('product_size')->insert([
            'product_id' => $id,
            'size_id' => $sizeId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    return redirect()->route('manage-product')->with('success', 'Product updated successfully');
    }
    public function updateImages($id, Request $request)
{
    $request->validate([
        'large_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'small_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $product = DB::table('products')
        ->join('product_category', 'product_category.product_id', '=', 'products.id')
        ->join('categories', 'categories.id', '=', 'product_category.category_id')
        ->select('products.*', 'categories.name as category_name')
        ->where('products.id', $id)
        ->first();

    if (!$product) {
        abort(404, 'Product not found');
    }

    $categoryFolder = match ($product->category_name) {
        'PET' => 'PET',
        'PC' => 'PC',
        'PP' => 'PP',
        default => 'default',
    };

    // Handle large images
    $largeImages = explode(',', str_replace('\"', '', $product->image));
    if ($request->hasFile('large_images')) {
        foreach ($request->file('large_images') as $key => $file) {
            if ($file) {
                $this->handleImageUpload($file, $largeImages, $key, $categoryFolder);
            }
        }
    }
    $largeImagesString = implode(',', $largeImages);

    // Handle small images
    $smallImages = explode(',', str_replace('\"', '', $product->images));
    if ($request->hasFile('small_images')) {
        foreach ($request->file('small_images') as $key => $file) {
            if ($file) {
                $this->handleImageUpload($file, $smallImages, $key, $categoryFolder);
            }
        }
    }
    $smallImagesString = implode(',', $smallImages);

    DB::table('products')->where('id', $id)->update([
        'image' => $largeImagesString,
        'images' => $smallImagesString
    ]);

    return redirect()->route('manage-product')->with('success', 'Images updated successfully.');
    }
    public function handleImageUpload($file, &$images, $index, $categoryFolder)
    {
        if ($file) {
            if (isset($images[$index]) && file_exists(public_path($images[$index]))) {
                unlink(public_path($images[$index]));
            }
            $fileName = Str::random(10);
            $extension = $file->getClientOriginalExtension();
            $storedImage = $fileName . '.' . $extension;
            $file->storeAs("public/images/Products/{$categoryFolder}", $storedImage);
            $sourcePath = storage_path('app/public/images/Products/' . $categoryFolder . '/' . $storedImage);
            $destinationPath = public_path('images/Products/' . $categoryFolder . '/' . $storedImage);
            File::copy($sourcePath, $destinationPath);
            $images[$index] = 'images/Products/' . $categoryFolder . '/' . $storedImage;
        }
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
}
