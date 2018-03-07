<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\User;
use DB;
use Auth;

Class userController extends BaseController
{
    /**
     * @param Request  $request
     */
    public function userLogin(request $request) 
    {
        $email = $request->input('email');
        $pass = $request->input('password');
        
        // Validate input data from request
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required' 
        ]);
                     
        // search user in database
        $user = User:: where("email", "=", $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            // update or create a token
            $apikey = base64_encode(str_random(40));  
            User::where('email', "=", $request->input('email'))->update(['token' => "$apikey"]);  
        }

        // if user login is true then return data of user in json response
        if ($user) {
                return response()->json([
                    'name' => $user->email, 
                    'id' => $user->id, 
                    'token' =>$user->token
                ]);
            } else {    
                return response()->json([$user, 'error' => 'Connection is not successfull']);           
            }
        }
    
    /**
     * Log the user out of the application.
     *
     * @return json Response
     */
    public function userLogout()
    {
        $this->auth->logout();

        return response()->json(['msg' => 'Logout sucess']);
    }

    
    /**
     * @param Request $request
     * @param $id -> id of user is connected
     * Update data of user 
     */
    public function userUpdate(Request $request,$id)
    {
        if ($request->isMethod('post')){
            $user = User::find($id);
            
            $user = User::update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'profil' => '2'
            ]);
            
        }
        return response()->json($user);
    }
    
    /**
     * @param Request $request
     * Register a new user in DB
     */
    public function userRegister(Request $request){
        
        // Validate input data from request
        $this->validate($request, [
            'email' => 'required|email|unique',
            'password' => 'required|min:7',
            'name' => 'required' 
        ]);
            
        // if method = post add user in DB
        if ($request->isMethod('post')){
            $apikey = base64_encode(str_random(40));
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'profil' => '2',
                'token' => $apikey
            ]);
        }

        return response()->json($user);
    }
} //end class
