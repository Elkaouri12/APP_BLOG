<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{



    public function index(){
        $users=User::all();
        return response()->json([
            'users'=>$users
        ]);
    }
    public function register(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $userexist=User::whereEmail($request->email)->first();
        if($userexist){
            return response()->json([
                'error'=>' Ops ! this user is alrady exist'
            ]);
        }

        $user = User::create([
            'fullname' => $request->input('fullname'),
            'email' =>$request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("user_token")->plainTextToken
        ], 200);
    }

    //------------------------------------------------------------------------------------------
    public function login(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        
    $user=User::whereEmail($request->email)->first();
    if(isset($user->id)){
                if(hash::check($request->password,$user->password)){
                    $token=$user->createToken('Auth_token')->plainTextToken;
                            return response()->json([
                                'message' => 'connected seccefuly',
                                'user'=>$user,
                                'token'=>$token,
                                'login'=>true
                            ]);
                }else{
                            return response()->json([
                                'message' => 'password not correct',
                                'login'=>false
                            ]);
                };
    }else{
                return response()->json([
                    'message' => 'no user exist with this email',
                    'login'=>false
                ]);
    };
    
    }


    public function Profile(){
        return response()->json([
        'user'=>auth()->user()
    ]);
        // return new UserResource(auth()->user());
    }


    public function destroy($id) { 
        $user=user::find($id); 
        $user->delete();
        return response()->json([
        ]);
     }


     public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout seccessfully',
        ]);
    }

    //--------------------------------------------------------------------------
public function forget(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'message' => 'No user exists with this email. Please try again.',
        ]);
    }

    $numberToken = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    PasswordReset::updateOrCreate(
        ['email' => $user->email],
        ['token' => $numberToken]
    );

    $user->notify(new ResetPasswordNotification($numberToken));

    return response()->json([
        'message' => 'Check your email address.',
    ]);
}

//--------------------------------------------------------------------------
public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'token' => 'required',
    ]);
    
    $resetRequest = PasswordReset::where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$resetRequest) {
        return response()->json(['error' => 'Invalid token']);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Cannot find any user with this email']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    $user->tokens()->delete();
    $resetRequest->delete();
    
    $token = $user->createToken('Auth_token')->plainTextToken;
    
    return response()->json([
        'message' => 'Your password has been changed successfully',
        'user' => $user,
        'token' => $token
    ]);
}



public function update(Request $request,$id){
    $user=User::find($id);
    $this->validate($request,[
        'fullname'=>'required',
        'Tel'=>'required',
        'email'=>'required',
        'role'=>'string',
    ]);

        $user->update([
            'fullname'=>$request->input('fullname'),
            'Tel'=>$request->input('Tel'),
            'email'=>$request->input('email'),
            'role'=>$request->input('role')?'admin': 'user',
        ]);

        return response()->json([
            'message'=>' Account updated successfully',
            'user'=>$user
        ]);
}



}