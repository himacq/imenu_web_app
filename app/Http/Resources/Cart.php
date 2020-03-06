<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CartRestaurantsCollection;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = new CartRestaurantsCollection($this->cartRestaurants);
        if(count($items)==0)
            $items = null;

        // count cart items
        $cart_items = 0;
        if($this->cartRestaurants){
            $restaurants = $this->cartRestaurants;
            foreach ($restaurants as $restaurant){
                $products = $restaurant->products;
                
                $cart_items+=$products->sum('qty');
            }
            
        }
        
        //calcaulate grand_total
       /* $grand_total = 0;
        if($this->cartRestaurants){
            $restaurants = $this->cartRestaurants;
            foreach ($restaurants as $restaurant){
                $products = $restaurant->products;
                foreach ($products as $product){
                    
                    $grand_total+=($product->qty*$product->price);
                    $options = $product->options;
                    foreach($options as $option){
                        $grand_total+=($option->qty*$option->price);
                    }
                }
            }
        }
        */
        
        
        return [
            'id' =>$this->id,
            'grand_total' =>$this->grand_total,
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'cart_items'=>$cart_items,
            'items'=> $items
            
            ];
    }
}
