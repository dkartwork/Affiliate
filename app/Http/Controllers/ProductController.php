<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function AllProducts(){
        $products = Product::all();
        return view('products', ['products' => $products]);
    }

    public function BuyProduct(Request $request){
        $Code = $request->query('code');
        $product = Product::where('code','=',$Code)->first();
        $buy = Sale::create([
           'iduser' => Session::get('loginId'),
           'idproduct' => $product->id,
           'price' => $product->price
        ]);

        $result = $buy->save();
        if($result){
            return back()->with('success','สั่งซื้อ สำเร็จ!');
        } else {
            return back()->with('fail','มีปัญหาบางอย่างโปรดตรวจสอบ!');
        }
    }

    public function TierBonus(){
        $data = User::where('id','=',Session::get('loginId'))->first();
        $tier = User::where('tier_code','=',$data->user_code)->get();
        $TierList = [];
    
        if($tier->isNotEmpty()){
            foreach ($tier as $value) {
                $buy = Sale::where('iduser','=',$value->id)->first();               
                if($buy){
                    $TierList[] = $buy;
                    $user[] = $buy->user;
                    $bonus[] = ($buy->price*10)/100;
                }              
            }          
        } else {
            $TierList[] = "";
            $user[] = "";
            $bonus[] = 0;
        }
        
        $tierBobus = [
            'buy' => $TierList,
            'bonus' => $bonus,
            'user' => $user,
        ];
        return  $tierBobus;
    }

    public function subTierBonus(){
        $data = User::where('id','=',Session::get('loginId'))->first();
        $tier = User::where('tier_code','=',$data->user_code)->get();

        if($tier->isNotEmpty()){
            foreach ($tier as $value) {
                $subtier = User::where('tier_code','=',$value->user_code)->get();
                
                if($subtier->isNotEmpty()){
                    foreach ($subtier as $subvalue) {
                        $buy = Sale::where('iduser','=',$subvalue->id)->get();
                        
                        if ($buy->isNotEmpty()) {
                            foreach ($buy as $sale) {
                                $TierList[] = $sale;
                                $user[] = $sale->user;
                                $bonus[] = ($sale->price * 5) / 100;
                            }
                        }
                    }
                }
                else{
                    $TierList[] = "";
                    $user[] = "";
                    $bonus[] = 0;
                    
                }  

            }
            
        }else{
            $TierList[] = "";
            $user[] = "";
            $bonus[] = 0;
        }  

      

        $tierBobus = [
            'buy' => $TierList,
            'bonus' => $bonus,
            'user' => $user,
        ];
    
         return  $tierBobus;
        
        
    }
}
