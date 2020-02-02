<?php

    /** @var \Illuminate\Database\Eloquent\Factory $factory */
    use App\Models\Restaurant;
    use App\Models\Category;
    use App\Models\Product;
    use Faker\Generator as Faker;
    use Illuminate\Support\Str;

    /**
     * Fake Restaurants
     */
    $factory->define(Restaurant::class, function (Faker $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'mobile1' => $faker->phoneNumber,
            'mobile2' => $faker->phoneNumber,
            'phone3' => $faker->phoneNumber,
            'phone2' => $faker->phoneNumber,
            'phone1' => $faker->phoneNumber,
            'extra_info' => $faker->text,
            'working_details' => $faker->text,
            'longitude' => $faker->longitude,
            'latitude' => $faker->latitude,
            'logo'=>$faker->colorName.".jpg",
            'banner'=>$faker->colorName.".jpg",
            'verification_code' => str_random(4),
            'manager_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
            'status' => random_int(2, 4),
        ];
    });


    /**
     * Fake Categories
     */
    $factory->define(Category::class, function (Faker $faker) {
        return [
            'name' => $faker->name,
            'image' => $faker->colorName.".jpg",
            'isActive' => $faker->boolean,
            'restaurant_id' => random_int(\DB::table('restaurants')->min('id'), \DB::table('restaurants')->max('id')),
        ];
    });
    
    /**
     * Fake Products
     */
    
    $factory->define(Product::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>1,
            'image'=>$faker->colorName.".jpg",
            'price'=>$faker->numberBetween(10, 50),
            'minutes_required'=>$faker->numberBetween(10, 50),
            'category_id'=>random_int(\DB::table('categories')->min('id'), \DB::table('categories')->max('id'))
        ];
        
    });
    
    /**
     * Fake Product's ingredients
     */
    
    $factory->define(App\Models\ProductOptions::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>1,
            'price'=>$faker->numberBetween(1, 10),
            'minutes_required'=>$faker->numberBetween(10, 50),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id'))
        ];
        
    });
    
    /**
     * Fake Product's options
     */
    
    $factory->define(App\Models\ProductIngredients::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>$faker->boolean,
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id'))
        ];
        
    });
    
    
    /**
     * Fake Favourites
     */
    
    $factory->define(App\Models\Favourite::class,function (Faker $faker){
        return [
            'user_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id'))
        ];
        
    });
    
    /**
     * Fake Cart
     */
    
    $factory->define(App\Models\Cart::class,function (Faker $faker){
        return [
            'user_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
        ];
        
    });
    
    /**
     * Fake Cart Details
     */
    
    $factory->define(App\Models\CartDetail::class,function (Faker $faker){
        return [
            'cart_id' => random_int(\DB::table('carts')->min('id'), \DB::table('users')->max('id')),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id')),
            'qty'=>$faker->numberBetween(1, 10),
            'price'=>$faker->numberBetween(1, 10)
        ];
        
    });
    
    /**
     * Fake Payment Methods
     */
    
    $factory->define(App\Models\PaymentMethod::class,function (Faker $faker){
        return [
            'name' => $faker->company,
            'isActive'=>1,
            'api_url'=>$faker->url,
        ];
        
    });
    
    /**
     * Fake User address
     */
    
    $factory->define(App\Models\UserAddress::class,function (Faker $faker){
        return [
            'user_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
            'street'=>$faker->streetName,
            'city'=>$faker->city,
            'house_no'=>$faker->numberBetween(1, 10),
            'isDefault'=>$faker->boolean
        ];
        
    });
    
    /**
     * Fake Orders
     */
    
    $factory->define(App\Models\Order::class,function (Faker $faker){
        return [
            'user_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
            'order_status'=>6,
            'address_id'=>random_int(\DB::table('user_addresses')->min('id'), \DB::table('user_addresses')->max('id')),
            'payment_id'=>random_int(\DB::table('payment_methods')->min('id'), \DB::table('payment_methods')->max('id'))
        ];
        
    });
    
    
    
    /**
     * Fake Order Details
     */
    
    $factory->define(App\Models\OrderDetail::class,function (Faker $faker){
        return [
            'order_id' => random_int(\DB::table('orders')->min('id'), \DB::table('orders')->max('id')),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id')),
            'qty'=>$faker->numberBetween(1, 10),
            'price'=>$faker->numberBetween(1, 10)
        ];
        
    });
    
    /**
     * Fake Order product options
     */
    
    $factory->define(App\Models\OrderDetailOption::class,function (Faker $faker){
        return [
            'order_details_id' => random_int(\DB::table('order_details')->min('id'), \DB::table('order_details')->max('id')),
            'product_option_id'=>random_int(\DB::table('product_options')->min('id'), \DB::table('product_options')->max('id')),
            'qty'=>$faker->numberBetween(1, 10),
            'price'=>$faker->numberBetween(1, 10)
        ];
        
    });
