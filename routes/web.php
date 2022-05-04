<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップページ
Route::get('/', function () {
    return view('welcome');
});
// ログイン分岐画面
Route::get('/login', function () {
    return view('login');
});
// 登録分岐画面
Route::get('/register', function () {
    return view('register');
});
// 商品一覧
Route::get('/products-list', function () {
    return view('products_list');
});
// 商品詳細画面
Route::get('/product-detail/{id}', 'ProductController@index')->where('id', '[0-9]+');
Route::get('api/getproducts', 'ProductController@getProducts');

// 商品一覧画面用のフィルターされた商品情報取得API
Route::get('api/getselectedproducts', 'ProductController@getSelectedProducts');

// 商品詳細商画面用の商品情報取得API（一品）
Route::get('api/getproduct/{id}', 'ProductController@getOneProduct');
// 閲覧しているユーザーのロールをチェックするAPI
Route::get('api/getrole', 'HomeController@getRole');
// 閲覧してるユーザーが商品を購入した人かどうかを判定するAPI
Route::get('api/checkpurchaser', 'ProductController@checkPurchaser');
// APIのレスポンスが500だった時に表示する画面
Route::get('/500', function () {
    return view('errors.error_page');
});

// 商品を購入するボタンを押下した時の処理API
Route::post('api/purchaseproduct', 'ProductController@purchaseProduct');

// カテゴリーを取得するAPI
Route::get('api/getcategorylist', 'HomeController@getCategoryList');

// 都道府県情報を取得するAPI
Route::get('api/getprefdata', 'HomeController@getPrefData');

// 一般ユーザー用ルート
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'login' => true,
        'register' => true,
        'reset'    => true,
        'verify'   => false
    ]);

    // ログイン認証後
    Route::middleware('auth:user')->group(function () {

        // マイページ
        Route::get('home', 'HomeController@index');
        // 購入済みの商品情報の取得
        Route::get('api/getallpurchasedproducts', 'HomeController@getAllPurchasedProducts');
        // ユーザー情報編集ページ
        Route::get('edit-user', 'EditUserInfoController@index');
        // ユーザー情報と都道府県情報を取得するAPI
        Route::get('api/getuserandprefdata', 'EditUserInfoController@getUserAndPrefData');
        // ユーザー情報を編集するAPI
        Route::post('api/edituserinfo', 'EditUserInfoController@updateUserInfo');
        // 購入した商品をキャンセルするAPI
        Route::post('api/cancelpurchase', 'CancelPurchaseController@cancelPurchase');
        // パスワード変更ページ
        Route::get('change-password', function () {
            return view('user.change_user_password');
        });
        // パスワード変更API
        Route::post('api/changepassword', 'Auth\ChangePasswordController@changePassword');
        // ユーザーのIDとロールの取得(後で違うコントローラーに移すのがいいかも)
        Route::get('api/getidandrole', 'Auth\ChangePasswordController@getIdAndRole');
        // ログアウト
        Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
        // 退会
        Route::get('delete', 'Auth\DeleteController@showDeletePage')->name('user.delete');
        // 退会処理API
        Route::post('api/delete', 'Auth\DeleteController@softdelete')->name('user.delete');
    });
});

// 店舗用ルート
Route::namespace('Seller')->prefix('seller')->name('seller.')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'login' => true,
        'register' => true,
        'reset'    => true,
        'verify'   => false
    ]);

    // ログイン認証後
    Route::middleware('auth:seller')->group(function () {
        // マイページ
        Route::get('home', 'HomeController@index');
        // 登録した商品の情報最新5件(購入されてない商品)を取得するAPI
        Route::get('api/getsellingproducts', 'HomeController@getSellingProducts');
        // 登録した商品の情報最新5件(購入された商品)を取得するAPI
        Route::get('api/getsoldproducts', 'HomeController@getSoldProducts');
        // 店舗が出品した商品の情報全てを取得するAPI
        Route::get('api/getallsellerproducts', 'HomeController@getAllSellerProducts');
        // 店舗が出品した商品（購入された商品）の情報全てを取得するAPI
        Route::get('api/getallsoldproducts', 'HomeController@getAllSoldProducts');
        Route::get('getUserInfo', 'Auth\LoginController@getUserInfo');
        // 商品登録ページ
        Route::get('create', 'CreateProductController@index');
        // カテゴリーを取得するAPI
        Route::post('api/getcategorylist', 'ProductController@getCategoryList');
        // 商品登録API
        Route::post('api/addproduct', 'CreateProductController@store');
        // 商品削除API
        Route::post('api/deleteproduct/', 'EditProductController@delete');
        // 商品編集ページ
        Route::get('edit-product/{id}', 'EditProductController@index');
        Route::get('api/getproduct/{id}', 'EditProductController@getProductInfo');
        // 店舗情報編集ページ
        Route::get('edit-seller', 'EditSellerInfoController@index');
        // 店舗情報と都道府県情報を取得するAPI
        Route::get('api/getsellerandprefdata', 'EditSellerInfoController@getSellerAndPrefData');
        // 店舗情報を編集するAPI
        Route::post('api/editsellerinfo', 'EditSellerInfoController@updateSellerInfo');
        // 商品を取得するAPI(単品)
        Route::post('api/updateproduct', 'EditProductController@update');
        // 店舗が出品した商品一覧画面
        Route::get('products-list', function () {
            return view('seller.products_list');
        });
        // 店舗が出品した商品(購入された商品)一覧画面
        Route::get('sold-products-list', function () {
            return view('seller.sold_products_list');
        });

        // パスワード変更ページ
        Route::get('change-password', function () {
            return view('seller.change_seller_password');
        });
        // ユーザーのIDとロールの取得
        Route::get('api/getidandrole', 'Auth\ChangePasswordController@getIdAndRole');
        // パスワード変更API
        Route::post('api/changepassword', 'Auth\ChangePasswordController@changePassword');
        // ログアウト
        Route::get('logout', 'Auth\LoginController@logout')->name('seller.logout');
        // 退会
        Route::get('delete', 'Auth\DeleteController@showDeletePage')->name('seller.delete');
        // 退会処理
        Route::post('api/delete', 'Auth\DeleteController@softdelete')->name('seller.delete');
    });
});
