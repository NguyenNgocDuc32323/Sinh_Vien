<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Ads\CreateAdsController;
use App\Http\Controllers\Admin\Ads\ManageAdsController;
use App\Http\Controllers\Admin\Ads\UpdateAdsController;
use App\Http\Controllers\Admin\Blog\CreateBlogController;
use App\Http\Controllers\Admin\Blog\ManageBlogController;
use App\Http\Controllers\Admin\Transaction\ManageTransactionController;
use App\Http\Controllers\Admin\Blog\UpdateBlogController;
use App\Http\Controllers\Admin\Category\CreateCategoryController;
use App\Http\Controllers\Admin\Category\ManageCategoryController;
use App\Http\Controllers\Admin\Category\UpdateCategoryController;
use App\Http\Controllers\Admin\Color\CreateColorController;
use App\Http\Controllers\Admin\Color\ManageColorController;
use App\Http\Controllers\Admin\Color\UpdateColorController;
use App\Http\Controllers\Admin\Contact\ManageContactController;
use App\Http\Controllers\Admin\Contact_Reply\ManageContactReplyController;
use App\Http\Controllers\Admin\Contact_Reply\ReplyContactController;
use App\Http\Controllers\Admin\Contact_Reply\UpdateContactReplyController;
use App\Http\Controllers\Admin\Label\CreateLabelController;
use App\Http\Controllers\Admin\Label\ManageLabelController;
use App\Http\Controllers\Admin\Label\UpdateLabelController;
use App\Http\Controllers\Admin\Order\ManageOrderController;
use App\Http\Controllers\Admin\Order\UpdateOrderController;
use App\Http\Controllers\Admin\Order_Detail\ManagerOrderDetailController;
use App\Http\Controllers\Admin\Order_Detail\UpdateOrderDetailController;
use App\Http\Controllers\Admin\Product\CreateProductController;
use App\Http\Controllers\Admin\Product\ManageProductController;
use App\Http\Controllers\Admin\Product\UpdateProductController;
use App\Http\Controllers\Admin\Size\CreateSizeController;
use App\Http\Controllers\Admin\Size\ManageSizeController;
use App\Http\Controllers\Admin\Size\UpdateSizeController;
use App\Http\Controllers\Admin\Slide\CreateSlideController;
use App\Http\Controllers\Admin\Slide\ManageSlideController;
use App\Http\Controllers\Admin\Slide\UpdateSlideController;
use App\Http\Controllers\Admin\User\ManageUserController;
use App\Http\Controllers\Admin\User\UpdateUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\User\AdsController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/filter-category', [ShopController::class, 'filterByCategory'])->name('shop-filter-category');
Route::get('/shop/filter-color', [ShopController::class, 'filterByColor'])->name('shop-filter-color');
Route::get('/shop-filter-size', [ShopController::class, 'filterBySize'])->name('shop-filter-size');
Route::get('/shop-filter-price',[ShopController::class, 'filterByPrice'])->name('shop-filter-price');
Route::get('/search-product',[HomeController::class, 'searchProduct'])->name('search-product');
Route::get('/product-detail/{id}',[ProductDetailController::class,'index'])->name('product-detail');
Route::get ('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login-post');
Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('register-post');
Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('forgot-password');
Route::post('/forgot-password',[ForgotPasswordController::class,'forgotPassword'])->name('forgot-password-post');
Route::get('/reset-password',[ResetPasswordController::class,'index'])->name('reset-password');
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword'])->name('reset-password-post');
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/send-contact-form',[ContactController::class,'sentForm'])->name('send-contact-form');
//feedback
Route::post('/send-feedback-form', [HomeController::class, 'sendFeedbackForm'])->name('sendFeedbackForm');
Route::post('/upload-image', [HomeController::class, 'uploadImage'])->name('upload-image');
//about
Route::get('/about',[AboutController::class,'index'])->name('about');
Route::get('/ads',[AdsController::class, 'index'])->name('ads');
//blog
Route::get('/blog',[BlogController::class,'index'])->name('blog');
Route::get('/blog-detail/{id}',[BlogController::class, 'detail'])->name('blog-detail');
Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('admin');
    Route::get('/chart-data', [AdminController::class, 'getChartData']);
    //user
    Route::get('/manage-user',[ManageUserController::class,'index'])->name('manage-user');
    Route::get('/delete-user/{id}', [ManageUserController::class, 'delete'])->name('delete-user');
    Route::get('/user-search', [ManageUserController::class, 'search'])->name('user-search');
    Route::get('/update-user/{id}',[UpdateUserController::class,'updateInfor'])->name('update-user');
    Route::post('/update-user/{id}',[UpdateUserController::class,'updateInforPost'])->name('update-user-post');
    Route::post('/update-password/{id}', [UpdateUserController::class, 'updatePassword'])->name('update-password');
    //Product
    Route::get('/manage-product',[ManageProductController::class,'index'])->name('manage-product');
    Route::get('/product-search',[ManageProductController::class,'search'])->name('product-search');
    Route::get('/delete-product/{id}', [ManageProductController::class, 'delete'])->name('delete-product');
    Route::get('/update-product/{id}',[UpdateProductController::class, 'update'])->name('update-product');
    Route::post('/update-product/{id}',[UpdateProductController::class, 'updateDetailPost'])->name('update-product-detail');
    Route::post('/products/{id}/update-images', [UpdateProductController::class, 'updateImages'])->name('update-product-images');
    Route::get('/create-product', [CreateProductController::class, 'index'])->name('create-product');
    Route::post('/create-product', [CreateProductController::class, 'createProduct'])->name('create-product-post');
    //category
    Route::get('/manage-category',[ManageCategoryController::class,'index'])->name('manage-category');
    Route::get('/category-search',[ManageCategoryController::class,'search'])->name('category-search');
    Route::get('/delete-category/{id}', [ManageCategoryController::class, 'delete'])->name('delete-category');
    Route::get('/update-category/{id}',[UpdateCategoryController::class, 'update'])->name('update-category');
    Route::post('/update-category/{id}',[UpdateCategoryController::class, 'updatePost'])->name('update-category-post');
    Route::get('/create-category', [CreateCategoryController::class, 'index'])->name('create-category');
    Route::post('/create-category', [CreateCategoryController::class, 'create'])->name('create-category');
    //order
    Route::get('/manage-order',[ManageOrderController::class,'index'])->name('manage-order');
    Route::get('/order-search',[ManageOrderController::class,'search'])->name('order-search');
    Route::get('/delete-order/{id}',[ManageOrderController::class,'delete'])->name('delete-order');
    Route::get('/update-order/{id}',[UpdateOrderController::class,'index'])->name('update-order');
    Route::post('/update-order/{id}',[UpdateOrderController::class,'update'])->name('update-order-post');
    //order detail
    Route::get('/manage-order-detail',[ManagerOrderDetailController::class,'index'])->name('manage-order-detail');
    Route::get('/order-detail-search',[ManagerOrderDetailController::class,'search'])->name('order-detail-search');
    Route::get('/delete-order-detail/{id}', [ManagerOrderDetailController::class, 'delete'])->name('delete-order-detail');
    Route::get('/update-order-detail/{code}',[UpdateOrderDetailController::class, 'update'])->name('update-order-detail');
    Route::post('/update-order-detail/{code}', [UpdateOrderDetailController::class, 'updateOrderDetail'])->name('update-order-detail');
    Route::get('/order-detail/{id}', [UpdateOrderDetailController::class, 'deleteItem'])->name('delete-item-detail');
    //Contact
    Route::get('/manage-contact', [ManageContactController::class,'index'])->name('manage-contact');
    Route::get('/contact-search',[ManageContactController::class,'search'])->name('contact-search');
    Route::get('/delete-contact/{id}', [ManageContactController::class, 'delete'])->name('delete-contact');
    Route::get('/contact-reply/{id}',[ReplyContactController::class, 'index'])->name('contact-reply');
    Route::post('/contact-reply/{id}',[ReplyContactController::class,'reply'])->name('contact-reply-post');
    Route::post('/admin-upload-image', [ReplyContactController::class, 'uploadImageAdmin'])->name('admin-upload-image');
    //Contact Reply
    Route::get('/manage-contact-reply', [ManageContactReplyController::class,'index'])->name('manage-contact-reply');
    Route::get('/contact-reply-search',[ManageContactReplyController::class,'search'])->name('contact-reply-search');
    Route::get('/delete-contact-reply/{id}', [ManageContactReplyController::class, 'delete'])->name('delete-contact-reply');
    Route::get('/update-contact-reply/{id}',[UpdateContactReplyController::class, 'index'])->name('update-contact-reply');
    Route::post('/update-contact-reply/{id}',[UpdateContactReplyController::class, 'updatePost'])->name('update-contact-reply-post');
    //slide
    Route::get('/manage-slide', [ManageSlideController::class,'index'])->name('manage-slide');
    Route::get('/search-slide',[ManageSlideController::class,'search'])->name('search-slide');
    Route::get('/create-slide',[CreateSlideController::class,'index'])->name('create-slide');
    Route::post('/create-slide',[CreateSlideController::class,'createSlide'])->name('create-slide-post');
    Route::get('/delete-slide/{id}', [ManageSlideController::class, 'delete'])->name('delete-slide');
    Route::get('/update-slide/{id}',[UpdateSlideController::class, 'index'])->name('update-slide');
    Route::post('/update-slide/{id}',[UpdateSlideController::class, 'update'])->name('update-slide-post');
    //color
    Route::get('/manage-color', [ManageColorController::class,'index'])->name('manage-color');
    Route::get('/color-search',[ManageColorController::class,'search'])->name('color-search');
    Route::get('/create-color',[CreateColorController::class,'index'])->name('create-color');
    Route::post('/create-color',[CreateColorController::class,'create'])->name('create-color-post');
    Route::get('/delete-color/{id}', [ManageColorController::class, 'delete'])->name('delete-color');
    Route::get('/update-color/{id}',[UpdateColorController::class, 'index'])->name('update-color');
    Route::post('/update-color/{id}',[UpdateColorController::class, 'update'])->name('update-color-post');
    //size
    Route::get('/manage-size', [ManageSizeController::class,'index'])->name('manage-size');
    Route::get('/size-search',[ManageSizeController::class,'search'])->name('size-search');
    Route::get('/create-size',[CreateSizeController::class,'index'])->name('create-size');
    Route::post('/create-size',[CreateSizeController::class,'create'])->name('create-size-post');
    Route::get('/delete-size/{id}', [ManageSizeController::class, 'delete'])->name('delete-size');
    Route::get('/update-size/{id}',[UpdateSizeController::class, 'index'])->name('update-size');
    Route::post('/update-size/{id}',[UpdateSizeController::class, 'update'])->name('update-size-post');
    //Ads
    Route::get('/manage-ads', [ManageAdsController::class,'index'])->name('manage-ads');
    Route::get('/ads-search',[ManageAdsController::class,'search'])->name('ads-search');
    Route::get('/create-ads',[CreateAdsController::class,'index'])->name('create-ads');
    Route::post('/create-ads',[CreateAdsController::class,'create'])->name('create-ads-post');
    Route::get('/delete-ads/{id}', [ManageAdsController::class, 'delete'])->name('delete-ads');
    Route::get('/update-ads/{id}',[UpdateAdsController::class, 'index'])->name('update-ads');
    Route::post('/update-ads/{id}',[UpdateAdsController::class, 'update'])->name('update-ads-post');
    //Label
    Route::get('/manage-label', [ManageLabelController::class,'index'])->name('manage-label');
    Route::get('/label-search',[ManageLabelController::class,'search'])->name('label-search');
    Route::get('/create-label',[CreateLabelController::class,'index'])->name('create-label');
    Route::post('/create-label',[CreateLabelController::class,'create'])->name('create-label-post');
    Route::get('/delete-label/{id}', [ManageLabelController::class, 'delete'])->name('delete-label');
    Route::get('/update-label/{id}',[UpdateLabelController::class, 'index'])->name('update-label');
    Route::post('/update-label/{id}',[UpdateLabelController::class, 'update'])->name('update-label-post');
    //blog
    Route::get('/manage-blog', [ManageBlogController::class,'index'])->name('manage-blog');
    Route::get('/blog-search',[ManageBlogController::class,'search'])->name('blog-search');
    Route::get('/create-blog',[CreateBlogController::class,'index'])->name('create-blog');
    Route::post('/create-blog',[CreateBlogController::class,'create'])->name('create-blog-post');
    Route::get('/delete-blog/{id}', [ManageBlogController::class, 'delete'])->name('delete-blog');
    Route::get('/update-blog/{id}',[UpdateBlogController::class, 'index'])->name('update-blog');
    Route::post('/update-blog/{id}',[UpdateBlogController::class, 'update'])->name('update-blog-post');
    //transaction
    Route::get('/manage-transaction', [ManageTransactionController::class,'index'])->name('manage-transaction');
    Route::get('/transaction-search',[ManageTransactionController::class,'search'])->name('transaction-search');
    Route::get('/confirm-transaction/{id}',[ManageTransactionController::class,'confirm'])->name('confirm-transaction');
    Route::get('/delete-transaction/{id}',[ManageTransactionController::class,'delete'])->name('delete-transaction');
});
Route::middleware(['auth','remember'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class,'create'])->name('checkout-post');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/user-profile/{id}',[UserController::class,'index'])->name('user-profile');
    Route::get('/user-profile-edit/{id}',[UserController::class,'edit'])->name('user-profile-edit');
    Route::post('/user-profile-edit-post/{id}',[UserController::class,'updateInforPost'])->name('user-profile-edit-post');
    Route::post('/user-edit-password-post/{id}',[UserController::class,'updatePasswordPost'])->name('user-edit-password-post');
    Route::get('/logout',[LogoutController::class,'logout'])->name('logout');
});
