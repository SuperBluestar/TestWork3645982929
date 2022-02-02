<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Http\Resources\User as UserResource;
   
class AuthController extends BaseController
{

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            // $success['token'] =  $authUser->createToken($request->device_name)->plainTextToken; 
            $authUser['token'] =  $authUser->createToken($request->device_name)->plainTextToken; 
   
            return $this->sendResponse(new UserResource($authUser), 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        } 
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'device_name' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user['token'] =  $user->createToken($request->device_name)->plainTextToken;
   
        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }
   
}