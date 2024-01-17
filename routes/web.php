<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SitemapXmlController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\WebController;
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

Route::get('/clear', function () {
	Artisan::call('cache:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');
	Artisan::call('route:clear');
	return "Cleared!";
});

// MAIN MENU ROUTES
Route::get('/', 'frontend\HomeController@index')->name('site.home');
Route::get('/about-us', 'frontend\HomeController@about_us')->name('about');
Route::get('/contact', 'frontend\HomeController@contact')->name('contact');
Route::get('/privacy-policy', 'frontend\HomeController@privacy_policy')->name('privacy');
Route::get('/terms-and-conditions', 'frontend\HomeController@terms_and_conditions')->name('terms');
Route::get('/disclaimer', 'frontend\HomeController@disclaimer')->name('disclaimer');
Route::get('/advertise', 'frontend\HomeController@advertise')->name('advertise');
Route::get('/chart', 'frontend\HomeController@chart')->name('chart');
Route::get('/chart-seven', 'frontend\HomeController@chart_seven')->name('chart7');
Route::get('/chart-fourteen', 'frontend\HomeController@chart_fourteen')->name('chart14');
Route::get('/mont-belvieu', 'frontend\HomeController@mont_belvieu')->name('montBelvieu');
Route::get('/chatroom', 'frontend\HomeController@chat_room')->name('chat');
Route::get('/market-place', 'MarketplaceController@show_marketplace')->name('market');
Route::get('/products', 'MarketplaceController@index')->name('products.index');
Route::get('/products/show/{slug}', 'MarketplaceController@show')->name('products.show');

// show lpgtanks products (link from ad)
Route::get('/lpgtanks', 'TankController@index')->name('lpgtanks.index');
Route::get('/lpgtanks/products', 'TankController@products')->name('lpgtanks.products');
Route::get('/lpgtanks/get-quote', 'TankController@get_quote')->name('lpgtanks.getquote');
Route::post('/lpgtanks/submit-quote', 'TankController@submit_quote')->name('lpgtanks.submitQuote');

// show ads.txt file
Route::get('/ads.txt', function () {
	return view("ads");
});

// Author Verification
Route::get('verify-author-request/{token}', [WebController::class, 'verify_author_request'])->name('verifyAuthorRequest');


// DEPOT PRICE ROUTE
Route::get('/dashboard/depot-prices', [App\Http\Controllers\DepotPriceController::class, 'index']);
Route::get(
	'/stat-depot-price',
	[App\Http\Controllers\DepotPriceController::class, 'get_DepotPrices_home']
);
Route::get(
	'/stat-depot-price-seven',
	[App\Http\Controllers\DepotPriceController::class, 'get_DepotPrices_seven']
);
Route::get(
	'/stat-depot-price-fourteen',
	[App\Http\Controllers\DepotPriceController::class, 'get_DepotPrices_fourteen']
);

Route::get(
	'/stat-chart-depot-price',
	[App\Http\Controllers\DepotPriceController::class, 'get_DepotPrices_chart']
);

Route::get(
	'/all-depot-price',
	[App\Http\Controllers\DepotPriceController::class, 'get_all_DepotPrices']
);

Route::post(
	'/add-price',
	[App\Http\Controllers\DepotPriceController::class, 'create_DepotPrice']
);
Route::post(
	'/all-depot-price/update',
	[App\Http\Controllers\DepotPriceController::class, 'update_DepotPrice']
);

Route::post(
	'/all-depot-price/delete',
	[App\Http\Controllers\DepotPriceController::class, 'delete_DepotPrice']
);

// AVERAGE DEPOT PRICE ROUTE
Route::get('/dashboard/average-depot-prices', [App\Http\Controllers\AverageDepotPriceController::class, 'index']);
Route::get(
	'/stat-average-depot-prices',
	[App\Http\Controllers\AverageDepotPriceController::class, 'get_AverageDepotPrices_home']
);

Route::get(
	'/all-average-depot-prices',
	[App\Http\Controllers\AverageDepotPriceController::class, 'get_all_AverageDepotPrices']
);

Route::post(
	'/add-average-price',
	[App\Http\Controllers\AverageDepotPriceController::class, 'create_AverageDepotPrice']
);


Route::post(
	'/all-average-depot-price/update',
	[App\Http\Controllers\AverageDepotPriceController::class, 'update_AverageDepotPrice']
);

Route::post(
	'/all-average-depot-price/delete',
	[App\Http\Controllers\AverageDepotPriceController::class, 'delete_AverageDepotPrice']
);

// MONT BELVIEU PRICE ROUTE
Route::get('/dashboard/mont-belvieu-prices', [App\Http\Controllers\MontBelvieuPriceController::class, 'index']);
Route::get(
	'/stat-mont-belvieu-prices',
	[App\Http\Controllers\MontBelvieuPriceController::class, 'get_MontBelvieuPrices_home']
);

Route::get(
	'/all-mont-belvieu-prices',
	[App\Http\Controllers\MontBelvieuPriceController::class, 'get_all_MontBelvieuPrices']
);

Route::post(
	'/add-mont-belvieu-price',
	[App\Http\Controllers\MontBelvieuPriceController::class, 'create_MontBelvieuPrice']
);


Route::post(
	'/all-mont-belvieu-price/update',
	[App\Http\Controllers\MontBelvieuPriceController::class, 'update_MontBelvieuPrice']
);

Route::post(
	'/all-mont-belvieu-price/delete',
	[App\Http\Controllers\MontBelvieuPriceController::class, 'delete_MontBelvieuPrice']
);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {

	Route::get('/dashboard', ['as' => 'dashboardRoute', 'uses' => 'DashboardController@index']);

	/*** For Category ***/
	Route::resource('categories', 'CategoryController');
	Route::get('/get-categories', ['as' => 'getCategoriesRoute', 'uses' => 'CategoryController@get']);
	Route::get('/categories/published/{id}', ['as' => 'publishedCategoriesRoute', 'uses' => 'CategoryController@published']);
	Route::get('/categories/unpublished/{id}', ['as' => 'unpublishedCategoriesRoute', 'uses' => 'CategoryController@unpublished']);

	/*** For Tag ***/
	Route::resource('tags', 'TagController');
	Route::get('/get-tags', ['as' => 'getTagsRoute', 'uses' => 'TagController@get']);
	Route::get('/tags/published/{id}', ['as' => 'publishedTagsRoute', 'uses' => 'TagController@published']);
	Route::get('/tags/unpublished/{id}', ['as' => 'unpublishedTagsRoute', 'uses' => 'TagController@unpublished']);

	/*** For Post ***/
	Route::resource('posts', 'PostController');
	Route::get('/get-posts', ['as' => 'getPostsRoute', 'uses' => 'PostController@get']);
	Route::get('/posts/published/{id}', ['as' => 'publishedPostsRoute', 'uses' => 'PostController@published']);
	Route::get('/posts/unpublished/{id}', ['as' => 'unpublishedPostsRoute', 'uses' => 'PostController@unpublished']);

	/*** For Subscriber ***/
	Route::resource('subscribers', 'SubscriberController');
	Route::get('/get-subscribers', ['as' => 'getSubscribersRoute', 'uses' => 'SubscriberController@get']);

	/*** For Setting ***/
	Route::resource('setting', 'SettingController');
	Route::post('/setting/logo/{id}', ['as' => 'settingLogoRoute', 'uses' => 'SettingController@logo']);
	Route::post('/setting/favicon/{id}', ['as' => 'settingFaviconRoute', 'uses' => 'SettingController@favicon']);
	Route::post('/setting/general/{id}', ['as' => 'settingGeneralRoute', 'uses' => 'SettingController@general']);
	Route::post('/setting/contact/{id}', ['as' => 'settingContactRoute', 'uses' => 'SettingController@contact']);
	Route::post('/setting/address/{id}', ['as' => 'settingAddressRoute', 'uses' => 'SettingController@address']);
	Route::post('/setting/social/{id}', ['as' => 'settingSocialRoute', 'uses' => 'SettingController@social']);
	Route::post('/setting/meta/{id}', ['as' => 'settingMetaRoute', 'uses' => 'SettingController@meta']);
	Route::post('/setting/gallery-meta/{id}', ['as' => 'settingGalleryMetaRoute', 'uses' => 'SettingController@gallery_meta']);

	/*** For Profile ***/
	Route::resource('profile', 'ProfileController');
	Route::post('/profile/avatar/{id}', ['as' => 'profileAvatarRoute', 'uses' => 'ProfileController@avatar']);
	Route::post('/profile/update-password', ['as' => 'profileUpdatePasswordRoute', 'uses' => 'ProfileController@update_password']);

	/*** For User ***/
	Route::resource('users', 'UserController');

	/*** For Comment ***/
	Route::resource('comments', 'CommentController');
	Route::get('/get-comments', ['as' => 'getCommentsRoute', 'uses' => 'CommentController@get']);
	Route::get('/comments/published/{id}', ['as' => 'publishedCommentsRoute', 'uses' => 'CommentController@published']);
	Route::get('/comments/unpublished/{id}', ['as' => 'unpublishedCommentsRoute', 'uses' => 'CommentController@unpublished']);
	Route::get('/comments/mark/{id}', ['as' => 'markCommentsRoute', 'uses' => 'CommentController@mark']);

	/*** For Page ***/
	Route::resource('pages', 'PageController');
	Route::get('/get-pages', ['as' => 'getPagesRoute', 'uses' => 'PageController@get']);
	Route::get('/pages/published/{id}', ['as' => 'publishedPagesRoute', 'uses' => 'PageController@published']);
	Route::get('/pages/unpublished/{id}', ['as' => 'unpublishedPagesRoute', 'uses' => 'PageController@unpublished']);

	/*** For Gallery ***/
	Route::resource('galleries', 'GalleryController');
	Route::get('/get-galleries', ['as' => 'getGalleriesRoute', 'uses' => 'GalleryController@get']);
	Route::get('/galleries/published/{id}', ['as' => 'publishedGalleriesRoute', 'uses' => 'GalleryController@published']);
	Route::get('/galleries/unpublished/{id}', ['as' => 'unpublishedGalleriesRoute', 'uses' => 'GalleryController@unpublished']);

	/*** For Messages ***/
	Route::resource('messages', 'MessageController');
	Route::get('get-messages', ['as' => 'getMessagesRoute', 'uses' => 'MessageController@get']);
	Route::get('/messages/read/{id}', ['as' => 'readMessagesRoute', 'uses' => 'MessageController@read']);
	Route::get('/messages/unread/{id}', ['as' => 'unreadMessagesRoute', 'uses' => 'MessageController@unread']);

	/** For Marketplace Backend **/
	Route::get('/market/products', 'ProductController@admin_products_index')->name('market.products.index');
	Route::get('/market/products/create', 'ProductController@admin_products_create')->name('market.products.create');
	Route::get('/market/products/show/{id}', 'ProductController@admin_products_show')->name('market.products.show');
	Route::get('/market/products/edit/{id}', 'ProductController@admin_products_edit')->name('market.products.edit');
	Route::put('/market/products/store', 'ProductController@admin_products_store')->name('market.products.store');
	Route::patch('/market/products/update/{id}', 'ProductController@admin_products_update')->name('market.products.update');
	Route::delete('/market/products/destroy/{id}', 'ProductController@admin_products_destroy')->name('market.products.destroy');
	Route::get('/market/products/publish/{id}', 'ProductController@admin_products_publish')->name('market.products.publish');
	Route::get('/market/products/unpublish/{id}', 'ProductController@admin_products_unpublish')->name('market.products.unpublish');

	// Backend for Product Categories
	Route::resource('productcategories', 'ProductCategoryController');

	/** For Tank Products Backend **/
	Route::get('/lpgtanks/products', 'TankController@admin_products_index')->name('lpgtanks.products.index');
	Route::get('/lpgtanks/products/create', 'TankController@admin_products_create')->name('lpgtanks.products.create');
	Route::get('/lpgtanks/products/show/{id}', 'TankController@admin_products_show')->name('lpgtanks.products.show');
	Route::get('/lpgtanks/products/edit/{id}', 'TankController@admin_products_edit')->name('lpgtanks.products.edit');
	Route::put('/lpgtanks/products/store', 'TankController@admin_products_store')->name('lpgtanks.products.store');
	Route::patch('/lpgtanks/products/update/{id}', 'TankController@admin_products_update')->name('lpgtanks.products.update');
	Route::delete('/lpgtanks/products/destroy/{id}', 'TankController@admin_products_destroy')->name('lpgtanks.products.destroy');
	Route::get('/lpgtanks/products/publish/{id}', 'TankController@admin_products_publish')->name('lpgtanks.products.publish');
	Route::get('/lpgtanks/products/unpublish/{id}', 'TankController@admin_products_unpublish')->name('lpgtanks.products.unpublish');

	// Backend for Tank Categories
	Route::resource('tankcategories', 'TankCategoryController');

	// Ajax for lpgtanks sub category
	Route::post('/lpgtanks/category/{id}/child', 'TankCategoryController@getChildren');

	/** For Shop Backend */
	Route::get('/shop', 'ShopController@admin_shop_index')->name('shops.index');
	Route::get('/shop/all', 'ShopController@admin_shop_index_all')->name('shops.index.all');
	Route::get('/shop/create', 'ShopController@admin_shop_create')->name('shops.create');
	Route::get('/shop/edit/{id}', 'ShopController@admin_shop_edit')->name('shops.edit');
	Route::put('/shop/store', 'ShopController@admin_shop_store')->name('shops.store');
	Route::patch('/shop/update/{id}', 'ShopController@admin_shop_update')->name('shops.update');
	Route::delete('/shop/destroy/{id}', 'ShopController@admin_shop_destroy')->name('shops.destroy');

	Route::get('/market/products/need-shop', 'ProductController@admin_need_shop')->name('market.need.shop');

	// Ajax for sub category
	Route::post('/category/{id}/child', 'ProductCategoryController@getChildByParent');

	// Ajax for States
	Route::post('/country/{id}/state', 'LocationController@getStates');

	//Route::get('products', 'ProductController');

	/*** For Forum ***/
	Route::group(
		['prefix' => 'forum', 'as' => 'forum.'],
		function () {
			// Forum Category
			Route::get('category', 'AdminForumController@category')->name('category');
			Route::post('add/category', 'AdminForumController@addCategory')->name('category.add');
			Route::post('update/category', 'AdminForumController@updateCategory')->name('category.update');

			// Forum Subcategory
			Route::get('sub/category', 'AdminForumController@subCategory')->name('sub.category');
			Route::post('add/sub/category', 'AdminForumController@addSubCategory')->name('add.sub.category');
			Route::post('update/sub/category', 'AdminForumController@updateSubCategory')->name('update.sub.category');

			// Forums
			Route::get('forums', 'AdminForumController@index')->name('forum');
			Route::post('add/forum', 'AdminForumController@add')->name('forum.add');
			Route::post('update/forum', 'AdminForumController@update')->name('forum.update');

			// Forum Posts or Topics
			Route::get('posts/pending', 'AdminForumController@pending')->name('post.pending');
			Route::get('posts/approved', 'AdminForumController@approved')->name('post.approved');
			Route::get('posts/deleted', 'AdminForumController@deleted')->name('post.deleted');
			Route::get('posts', 'AdminForumController@posts')->name('post.all');
			Route::post('post/approve', 'AdminForumController@approve')->name('post.approve');
			Route::post('post/disapprove', 'AdminForumController@disapprove')->name('post.disapprove');
			Route::get('post/details/{id}', 'AdminForumController@details')->name('post.details');
			Route::get('add/post/form', 'AdminForumController@addPostForm')->name('post.addform');
			Route::post('add/post', 'AdminForumController@addPost')->name('post.add');
			Route::get('edit/post/{id}', 'AdminForumController@editPost')->name('post.edit');
			Route::post('update/post', 'AdminForumController@updatePost')->name('post.update');
			Route::get('posts/my/{id}', 'AdminForumController@myPosts')->name('post.my');
		}
	);

	// Users Manager (NEW)
	Route::get('users', 'UserController@allUsers')->name('users.all');
	Route::get('users/active', 'UserController@activeUsers')->name('users.active');
	Route::get('users/banned', 'UserController@bannedUsers')->name('users.banned');
	Route::get('users/email-verified', 'UserController@emailVerifiedUsers')->name('users.email.verified');
	Route::get('users/email-unverified', 'UserController@emailUnverifiedUsers')->name('users.email.unverified');
	Route::get('users/premium', 'UserController@premiumUsers')->name('users.premium');

	Route::get('users/{scope}/search', 'UserController@search')->name('users.search');
	Route::get('user/detail/{id}', 'UserController@detail')->name('users.detail');
	Route::post('user/update/{id}', 'UserController@update')->name('users.update');
	Route::get('user/send-email/{id}', 'UserController@showEmailSingleForm')->name('users.email.single');
	Route::post('user/send-email/{id}', 'UserController@sendEmailSingle')->name('users.email.single');
	Route::get('user/login/{id}', 'UserController@login')->name('users.login');
	Route::get('user/transactions/{id}', 'UserController@transactions')->name('users.transactions');
	Route::get('user/deposits/{id}', 'UserController@deposits')->name('users.deposits');
	Route::get('user/deposits/via/{method}/{type?}/{userId}', 'UserController@depositViaMethod')->name('users.deposits.method');
	Route::get('user/withdrawals/{id}', 'UserController@withdrawals')->name('users.withdrawals');
	Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'UserController@withdrawalsViaMethod')->name('users.withdrawals.method');
	// Login History
	Route::get('users/login/history/{id}', 'UserController@userLoginHistory')->name('users.login.history.single');

	Route::get('users/send-email', 'UserController@showEmailAllForm')->name('users.email.all');
	Route::post('users/send-email', 'UserController@sendEmailAll')->name('users.email.send');
	Route::get('users/email-log/{id}', 'UserController@emailLog')->name('users.email.log');
	Route::get('users/email-details/{id}', 'UserController@emailDetails')->name('users.email.details');


	Route::get('users/posts/{id}', 'UserController@posts')->name('users.post.all');
	Route::get('users/tickets/{id}', 'UserController@tickets')->name('users.tickets');

	/** End Admin Backend Routes **/
});


/** 
 * 
 * ROUTES FROM BLOGGING SYSTEM 
 * 
 */

Route::group(['prefix' => '/'], function () {
	Route::get('/posts', ['as' => 'postsPage', 'uses' => 'WebController@index']);
	Route::get('/most-popular', ['as' => 'mostPopularPage', 'uses' => 'WebController@most_popular']);
	Route::get('/tags', ['as' => 'tagsPage', 'uses' => 'WebController@tags']);
	Route::get('/categories', ['as' => 'categoriesPage', 'uses' => 'WebController@categories']);
	Route::get('/gallery', ['as' => 'galleryPage', 'uses' => 'WebController@gallery']);
	Route::get('/get-gallery-image/{id}', ['as' => 'getGalleryRoute', 'uses' => 'WebController@get_gallery_image']);

	Route::get('/page/{slug}', ['as' => 'pagePage', 'uses' => 'WebController@page'])->where('slug', '[\w\d\-\_]+');

	Route::get('/category/{id}', ['as' => 'categoryPage', 'uses' => 'WebController@category']);
	Route::get('/tag/{id}', ['as' => 'tagPage', 'uses' => 'WebController@tag']);
	Route::get('/details/{slug}', ['as' => 'detailsPage', 'uses' => 'WebController@details'])->where('slug', '[\w\d\-\_]+');

	Route::post('/comment/{id}', ['as' => 'commentRoute', 'uses' => 'WebController@comment']);
	Route::post('/replay-comment/{id}', ['as' => 'replayCommentRoute', 'uses' => 'WebController@replay_comment']);

	Route::post('/search', ['as' => 'searchRoute', 'uses' => 'WebController@search']);
	Route::post('/subscribe', ['as' => 'subscribeRoute', 'uses' => 'WebController@subscribe']);


	Route::get('/author-profile/{username}', ['as' => 'authorProfilePage', 'uses' => 'WebController@author_profile']);

	Route::post('/contact-submit', ['as' => 'contactSubmit', 'uses' => 'MessageController@store']);



	// ..............................................
	// ROUTES FOR LOGGED IN BLOG USERS AT THE FRONT-END
	// ...............................................

	Route::group(['prefix' => 'dashboard', 'middleware' => ['user', 'verified'], 'as' => 'dashboard.'], function () {
		Route::get('/', ['as' => 'dashboardPage', 'uses' => 'WebController@dashboard'])->middleware('verified');    //verify_email');
		Route::get('/change-password', ['as' => 'editPasswordPage', 'uses' => 'WebController@edit_password']);
		Route::post('/update-password', ['as' => 'updatePasswordPage', 'uses' => 'WebController@update_password']);
		Route::get('/edit-profile', ['as' => 'editProfilePage', 'uses' => 'WebController@edit_profile']);
		Route::post('/update-profile/{id}', ['as' => 'updateProfilePage', 'uses' => 'WebController@update_profile']);
		Route::post('/become/author', ['as' => 'becomeAuthorRoute', 'uses' => 'WebController@become_author']);

		Route::get('/user/posts', ['as' => 'userPosts', 'uses' => 'WebController@my_posts']);
		Route::get('/add-post', ['as' => 'addPostPage', 'middleware' => ['author'], 'uses' => 'WebController@add_post']);
		Route::post('/store-post', ['as' => 'storePostRoute', 'middleware' => ['author'], 'uses' => 'WebController@store_post']);
		Route::get('/edit-post/{id}', ['as' => 'editPostPage', 'middleware' => ['author'], 'uses' => 'WebController@edit_post']);
		Route::get('/delete-post/{id}', ['as' => 'deletePostPage', 'middleware' => ['author'], 'uses' => 'WebController@delete_post']);
		Route::get('/view-post/{slug}', ['as' => 'viewPostPage', 'middleware' => ['author'], 'uses' => 'WebController@view_post']);
		Route::post('/update-post/{id}', ['as' => 'updatePostRoute', 'middleware' => ['author'], 'uses' => 'WebController@update_post']);
		Route::get('/user/comments', ['as' => 'userComments', 'uses' => 'WebController@my_comments']);

		// MarketPlace Routes (Fronte End)
		Route::resource('marketplace', 'MarketplaceController');
		Route::get('product/message/user/{product_id}', 'MarketplaceController@message_user')->name('message.user');

		// user interacting with marketplace
		Route::get('user/product/index', 'MarketplaceController@my_index')->name('user.product.index');
		Route::get('/user/product/show/{id}', 'MarketplaceController@show_product')->name('user.product.show');
		Route::get('user/product/create', 'MarketplaceController@create_product')->name('user.product.create');
		Route::put('user/product/store', 'MarketplaceController@store_product')->name('user.product.store');
		Route::get('user/product/edit/{id}', 'MarketplaceController@edit_product')->name('user.product.edit');
		Route::patch('user/product/update/{id}', 'MarketplaceController@update_product')->name('user.product.update');
		Route::delete('user/product/destroy/{id}', 'MarketplaceController@destroy_product')->name('user.product.destroy');
		Route::get('/user/product/publish/{id}', 'MarketplaceController@product_publish')->name('user.product.publish');
		Route::get('/user/product/unpublish/{id}', 'MarketplaceController@product_unpublish')->name('user.product.unpublish');

		// Ajax for sub category
		Route::post('/category/{id}/child', 'ProductCategoryController@getChildren');

		// Frontend Shop Routes
		Route::get('/user/product/need-shop', 'ShopController@need_shop')->name('user.need.shop');
		Route::get('user/shop/', 'ShopController@index')->name('user.shop.index');
		Route::get('/user/shop/create', 'ShopController@create')->name('user.shop.create');
		Route::get('/user/shop/edit/{id}', 'ShopController@edit')->name('user.shop.edit');
		Route::put('/user/shop/store', 'ShopController@store')->name('user.shop.store');
		Route::patch('/user/shop/update/{id}', 'ShopController@update')->name('user.shop.update');
		Route::delete('/user/shop/destroy/{id}', 'ShopController@destroy')->name('user.shop.destroy');
		Route::get('/user/shop/publish/{id}', 'ShopController@publish')->name('user.shop.publish');
		Route::get('/user/shop/unpublish/{id}', 'ShopController@unpublish')->name('user.shop.unpublish');
		//Route::get('/get-tags', ['as' => 'fetchTags', 'uses' => 'TagController@fetch']); // fetch tags used by AJAX


		// User Chatting / Messaging Routes
		Route::group(['prefix' => 'messages'], function () {
			Route::get('/', ['as' => 'messages', 'uses' => 'ChatController@index']);
			Route::get('/search/{searchTerm}', ['as' => 'search', 'uses' => 'ChatController@search']);
			Route::get('/users', ['as' => 'users', 'uses' => 'ChatController@users']);
			Route::put('/savechat/{id}', ['as' => 'savechat', 'uses' => 'ChatController@save_chat']);
			Route::get('/getchat/{userid}', ['as' => 'getchat', 'uses' => 'ChatController@get_chat']);
		});


		// Users interacting with Forum on his dashboard
		Route::get('create/topic', 'ForumController@postForm')->name('topic.form');
		Route::post('create/topic', 'ForumController@postCreate')->name('topic.create');

		Route::get('topics', 'ForumController@posts')->name('topic.all');

		Route::get('update/topic/{id}', 'ForumController@updatePostForm')->name('topic.update.form');
		Route::post('update/topic/', 'ForumController@updatePost')->name('topic.update');
		Route::post('delete/topic/', 'ForumController@deletePost')->name('topic.delete');


		Route::post('topic/reaction', 'ForumController@reaction')->name('topic.reaction');
		Route::post('topic/comment', 'ForumController@comment')->name('topic.comment');

		// User Subscription and Payment Management System
		Route::get('manage/subscription', 'PaymentController@manage_subscription')->name('manage.subscription');
		Route::get('cancel/subscription', 'PaymentController@cancel_subscription')->name('cancel.subscription');
	});
});

// Ajax for States
Route::post('/country/{id}/state', 'LocationController@findStates');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	/**
	 * Verification Routes
	 */
	Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
	Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});

// link that verifies account
//Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');  

// Send email notification
Route::get('/send/email', [EmailController::class, 'NewUserNotification'])->name('email.newUser');

/**
 * END OF ROUTES FROM BLOGGING SYSTEM
 */


/** 
 * BEGINNING OF ROUTES FOR MARKETPLACE FRONTEND
 */

Route::get('/products/search', 'MarketplaceController@search')->name('products.search');

Route::post('/product/rate/{id}', 'MarketplaceController@rate_product')->name('product.rate');

Route::post('/product/comment/{id}', 'MarketplaceController@comment_product')->name('product.comment');

Route::get('/add-to-cart/{product}', 'CartController@add')->name('cart.add')->middleware('auth');
Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');
Route::get('/cart/destroy/{itemId}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');
Route::get('/cart/update/{itemId}', 'CartController@update')->name('cart.update')->middleware('auth');
Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::get('/cart/apply-coupon', 'CartController@applyCoupon')->name('cart.coupon')->middleware('auth');

Route::resource('orders', 'OrderController')->only('store')->middleware('auth');

Route::resource('shops', 'ShopController')->middleware('auth');

Route::get('paypal/checkout/{order}', 'PayPalController@getExpressCheckout')->name('paypal.checkout');
Route::get('paypal/checkout-success/{order}', 'PayPalController@getExpressCheckoutSuccess')->name('paypal.success');
Route::get('paypal/checkout-cancel', 'PayPalController@cancelPage')->name('paypal.cancel');

Route::group(['prefix' => 'seller', 'middleware' => 'auth', 'as' => 'seller.', 'namespace' => 'Seller'], function () {

	Route::redirect('/', 'seller/orders');

	Route::resource('/orders',  'OrderController');

	Route::get('/orders/delivered/{suborder}',  'OrderController@markDelivered')->name('order.delivered');
});

/**
 * END OF ROUTES FOR MARKETPLACE FRONTEND
 */



/**
 * BEGINNING OF FORUM FRONTEND
 */

Route::group(
	['prefix' => 'forum', 'as' => 'forum.'],
	function () {
		Route::get('/home', 'ForumController@index')->name('home');

		Route::get('/search', 'ForumController@search')->name('search');
		Route::get('/all/topics', 'ForumController@allPost')->name('post.all');
		Route::get('/ad-count-ajax', 'ForumController@adCountAjax')->name('ad.count.ajax');
		Route::get('/{slug}/{id}', 'ForumController@forum')->name('forum');
		Route::get('/category/{slug}/{id}', 'ForumController@categoryPosts')->name('category.post');
		Route::get('/sub/category/{slug}/{id}', 'ForumController@subCategoryPosts')->name('sub.category.post');
		Route::get('/topic/details/{slug}/{id}', 'ForumController@postDetails')->name('post.details');
		Route::post('/load/more/comments', 'ForumController@moreComment')->name('more.comment');
		Route::get('/placeholder-image/{size}', 'ForumController@placeholderImage')->name('placeholder.image');

		Route::get('/user/{username}/{id}', 'ForumController@user')->name('user');
		Route::get('/user/topics/{username}/{id}', 'ForumController@userTopics')->name('user.topics');
		Route::get('/user/answered/{username}/{id}', 'ForumController@userAnswer')->name('user.answer');
		Route::get('/user/up-vote/{username}/{id}', 'ForumController@userUpVote')->name('user.up.vote');
		Route::get('/user/down-vote/{username}/{id}', 'ForumController@userDownVote')->name('user.down.vote');


		/**Route::group(
			['prefix' => 'user', 'middleware' => ['user', 'verified'], 'as' => 'user.'],
			function () {
			}
		); **/
	}
);

/**
 * END OF FORUM FRONTEND
 */


/**
 * PAYMENT GATEWAY - PAYSTACK ROUTES
 */
Route::get('/payment/subscription', [App\Http\Controllers\PaymentController::class, 'subscription'])->name('payment.subscription');
Route::get('/payment/depotprice', [App\Http\Controllers\PaymentController::class, 'depotprice'])->name('payment.depotprice');
Route::get('/payment/advert', [App\Http\Controllers\PaymentController::class, 'advert'])->name('payment.advert');

Route::group(['middleware' => 'auth'], function () {
	Route::post('/payment/pay', [App\Http\Controllers\PaymentController::class, 'redirectToGateway'])->name('payment.pay');
	Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'handleGatewayCallback'])->name('payment.callback'); //webhook
	Route::get('/payment/depotprice/pay', [App\Http\Controllers\PaymentController::class, 'depotpricepay'])->name('payment.depotprice.pay');
});

Route::get('/payment/complete', [App\Http\Controllers\PaymentController::class, 'complete'])->name('payment.complete');

/** 
 * END OF PAYMENT GATEWAY -PAYSTACK ROUTES
 */


// SITEMAP 
Route::get('sitemap.xml', [SitemapXmlController::class, 'index']);

// TEST
//Route::get('test', function () {

//$mail = Illuminate\Support\Facades\Mail::send([], [], function ($message) {
//		$message->to('wetindeyit@gmail.com')
//			->subject('Another Testing')
			// here comes what you want
//			->setBody('Hi, welcome user!'); // assuming text/plain
//	});
//});
