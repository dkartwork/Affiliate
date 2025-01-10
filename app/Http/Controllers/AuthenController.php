<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthenController extends Controller
{
    protected $ProductClass;
    public function __construct(ProductController $ProductClass) // ใช้ Dependency Injection
    {
        $this->ProductClass = $ProductClass;
    }
    public function registration(Request $request)
    {
        $affiliateCode = "";
        $Code = $request->query('code');
        if($Code){
            $affiliateCode = $Code; 
        }
       
        return view('auth.registration',compact('affiliateCode'));
    }
    
    public function registrationUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:users',
            'password' => 'required|min:8',
        ]); 
        $code = strtoupper(Str::random(8));
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->tier_code = $request->code;
        $user->user_code = $code;

        $result = $user->save();
        if($result){
            return back()->with('success','สมัครสมาชิก สำเร็จ!');
        } else {
            return back()->with('fail','มีปัญหาบางอย่างโปรดตรวจสอบ!');
        }

    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                return redirect('dashboard');
            } else {
                return back()->with('fail','รหัสผ่านไม่ถูกต้อง!');
            }
        } else {
            return back()->with('fail','ยังไม่ได้ลงทะเบียน!');
        }
    }

    public function dashboard()
    {
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id','=',Session::get('loginId'))->first();
        }
        $sale = $this->ProductClass->TierBonus();
       
        $subsale = $this->ProductClass->subTierBonus();

        return view('dashboard',compact('data','sale','subsale'));
    }

    public function logout()
    {
        $data = array();
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
