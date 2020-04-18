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
            'longitude' => $faker->longitude,
            'latitude' => $faker->latitude,
            'logo'=>$faker->colorName.".jpg",
            'banner'=>$faker->colorName.".jpg",
            'verification_code' => str_random(4),
            'owner_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
            'isActive' => 1,
            'commision' => random_int(1, 3),
            'discount' => random_int(1, 3),
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
     * Fake Product's options groups
     */

    $factory->define(App\Models\ProductOptionGroup::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>1,
            'minimum'=>$faker->numberBetween(1, 5),
            'maximum'=>$faker->numberBetween(1, 5),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id'))
        ];

    });

    /**
     * Fake Product's options
     */

    $factory->define(App\Models\ProductOption::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>1,
            'price'=>$faker->numberBetween(1, 10),
            'minutes_required'=>$faker->numberBetween(10, 50),
            'group_id'=>random_int(\DB::table('product_option_groups')->min('id'), \DB::table('product_option_groups')->max('id'))
        ];

    });

    /**
     * Fake Product's ingredients
     */

    $factory->define(App\Models\ProductIngredient::class,function (Faker $faker){
        return [
            'name' => $faker->name,
            'isActive'=>1,
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

$factory->define(App\Models\FavouriteRestaurant::class,function (Faker $faker){
    return [
        'user_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
        'restaurant_id'=>random_int(\DB::table('restaurants')->min('id'), \DB::table('restaurants')->max('id'))
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

    $factory->define(App\Models\CartRestaurant::class,function (Faker $faker){
        return [
            'cart_id' => random_int(\DB::table('carts')->min('id'), \DB::table('users')->max('id')),
            'restaurant_id'=>random_int(\DB::table('restaurants')->min('id'), \DB::table('restaurants')->max('id')),
            'sub_total'=>$faker->numberBetween(1, 10),
        ];

    });

    /**
     * Fake Cart Details
     */

    $factory->define(App\Models\CartDetail::class,function (Faker $faker){
        return [
            'cart_restaurant_id' => random_int(\DB::table('cart_restaurants')->min('id'), \DB::table('cart_restaurants')->max('id')),
            'product_id'=>random_int(\DB::table('products')->min('id'), \DB::table('products')->max('id')),
            'qty'=>$faker->numberBetween(1, 10),
            'price'=>$faker->numberBetween(1, 10)
        ];

    });

    /**
     * Fake Cart Details
     */

        $factory->define(App\Models\CartDetailOption::class,function (Faker $faker){
            return [
                'cart_details_id' => random_int(\DB::table('cart_details')->min('id'), \DB::table('cart_details')->max('id')),
                'product_option_id'=>random_int(\DB::table('product_options')->min('id'), \DB::table('product_options')->max('id')),
                'qty'=>$faker->numberBetween(1, 10),
                'price'=>$faker->numberBetween(1, 10)
            ];

        });

        $factory->define(App\Models\CartDetailIngredient::class,function (Faker $faker){
            return [
                'cart_details_id' => random_int(\DB::table('cart_details')->min('id'), \DB::table('cart_details')->max('id')),
                'product_ingredient_id'=>random_int(\DB::table('product_ingredients')->min('id'), \DB::table('product_ingredients')->max('id')),
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


$factory->define(App\Models\RestaurantPaymentMethod::class,function (Faker $faker){
    return [
        'payment_id'=>random_int(\DB::table('payment_methods')->min('id'), \DB::table('payment_methods')->max('id')),
        'restaurant_id'=>random_int(\DB::table('restaurants')->min('id'), \DB::table('restaurants')->max('id'))
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
            'grand_total'=>random_int(10,100),
        ];

    });

    /**
     * Fake order Details
     */

$factory->define(App\Models\OrderRestaurant::class,function (Faker $faker){
    return [
        'order_id' => random_int(\DB::table('orders')->min('id'), \DB::table('orders')->max('id')),
        'restaurant_id'=>random_int(\DB::table('restaurants')->min('id'), \DB::table('restaurants')->max('id')),
        'sub_total'=>$faker->numberBetween(1, 10),
        'address_id'=>random_int(\DB::table('user_addresses')->min('id'), \DB::table('user_addresses')->max('id')),
        'payment_id'=>random_int(\DB::table('payment_methods')->min('id'), \DB::table('payment_methods')->max('id'))
    ];

});



    /**
     * Fake order Details
     */

    $factory->define(App\Models\OrderRestaurantStatus::class,function (Faker $faker){
        return [
            'order_restaurant_id'=>random_int(\DB::table('order_restaurants')->min('id'), \DB::table('order_restaurants')->max('id')),
            'status'=>6,
        ];

    });

    /**
     * Fake Order Details
     */

    $factory->define(App\Models\OrderDetail::class,function (Faker $faker){
        return [
            'order_restaurant_id' => random_int(\DB::table('order_restaurants')->min('id'), \DB::table('order_restaurants')->max('id')),
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

    $factory->define(App\Models\OrderDetailIngredient::class,function (Faker $faker){
        return [
            'order_details_id' => random_int(\DB::table('order_details')->min('id'), \DB::table('order_details')->max('id')),
            'product_ingredient_id'=>random_int(\DB::table('product_ingredients')->min('id'), \DB::table('product_ingredients')->max('id')),
        ];

    });
