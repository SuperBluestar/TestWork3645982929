<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Str;

class AuthController extends BaseController
{

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user();
            if ($authUser->email_verified_at != null) {
                // $success['token'] =  $authUser->createToken($request->device_name)->plainTextToken; 
                $authUser['token'] =  $authUser->createToken($request->device_name)->plainTextToken; 
    
                return $this->sendResponse(new UserResource($authUser), 'User signed in');
            } else {
                return $this->sendError("Unverified", ['error'=>'Unverified'], 401);
            }
        } 
        else{ 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorised'], 401);
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
   
        if($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['email_verify_token'] = Str::random(24);
        $user = User::create($input);
        $to_name = $user->name;
        $to_email = $user->email;
        $remember_token = $user->email_verify_token;
        $data = array(
            "name" => $to_name, 
            "email" => $to_email,
            "token" => $remember_token
        );
        Mail::send("emails.signup", $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject("Laravel Test Mail");
            $message->from(env("MAIL_FROM_ADDRESS"),"Test Mail");
        });
        // $user['token'] =  $user->createToken($request->device_name)->plainTextToken;

        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }
    
    public function emailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
        ]);

        if($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors(), 404);
        }

        $user = User::where("email", $request->email)
            ->where("email_verify_token", $request->token)
            ->first();
        if (!is_null($user)) {
            $user->email_verified_at = now();
            $user->email_verify_token = null;
            $user->save();
            return $this->sendResponse(new UserResource($user), 'User verified successfully.');
        } else {
            if($validator->fails()) {
                return $this->sendError('Invalid token', [], 401);
            }
        }
    }
}