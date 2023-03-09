<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\User;
use \Modules\Setups\Entities\Role;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->passes()) {
            if(!empty($request->phone)){
                $validator = \Validator::make($request->all(), [
                    'phone' => 'required|min:11|max:15|unique:users',
                ]);
                if (!$validator->passes()) {
                    return response()->json([
                        'errors' => $validator->errors()->all()
                    ], 422);
                }
            }

            DB::beginTransaction();
            try{
                $user = new User();
                $user->fill($request->all());
                $user->username = $request->email;
                $user->password = bcrypt($request->password);
                $user->admin = 0;
                $user->role_id = ($request->role_id < 3 ? 3 : $request->role_id);
                $user->save();

                DB::commit();
                return response()->json([
                    'message' => "Your registraton has been Successfully done. Please Login now."
                ], 200);
                
            }catch (Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }
    
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            try{
                $user = User::where('email', $request->email)->first();
                if(isset($user->id)){
                    if(\Hash::check($request->password, $user->password)){
                        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
                        return response()->json([
                            'token' => $user->createToken('crm')->plainTextToken,
                            'message' => "Logged in Successfully!"
                        ], 200);
                    }

                    return response()->json([
                        'message' => "Password is incorrect!"
                    ], 200);
                }

                return response()->json([
                    'message' => "User Not Found!"
                ], 200);
            }catch (Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json([
            "user_id" => $user->id,
            "name" => $user->name,
            "phone" => $user->phone,
            "email" => $user->email,
            "username" => $user->username,
            "role_id" => $user->role_id,
            "role_name" => $user->role->name,
            "image" => documentUrl(!empty($user->image) ? 'user-images/'.$user->image : ''),
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'role_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->passes()) {
            if($request->role_id < 3){
                return response()->json([
                    'message' => "Sorry Something went wrong!"
                ], 500);
            }

            DB::beginTransaction();
            try{
                $user = User::findOrFail(auth()->user()->id);
                $user->fill($request->all());
                $user->save();

                DB::commit();
                return response()->json([
                    'message' => "Profile has been updated."
                ], 200);
                
            }catch (Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function changePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->passes()) {
            $user = auth()->user();
            if(!\Hash::check($request->current_password, $user->password)){
                return response()->json([
                    'message' => 'Password doesnot matched!'
                ], 500);
            }

            DB::beginTransaction();
            try{
                $user->password = bcrypt($request->password);
                $user->save();

                DB::commit();
                return response()->json([
                    'message' => "Password has been updated Successfully"
                ], 200);
                
            }catch (Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'errors' => $validator->errors()->all()
        ], 422);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out.'
        ], 200);
    }

    public function roles(){
        return Role::where('id', '>', 2)->get(['id', 'name']);
    }
}
