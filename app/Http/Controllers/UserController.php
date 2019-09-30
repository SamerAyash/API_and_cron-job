<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        return UserResource::collection(User::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required |unique:users|email',
            'password'=>'required|min:8'
        ])->validate();
        $user =User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]
        );
        return new UserResource($user);
    }

    public function show($id)
    {
        try{
            $user =User::findOrFail($id);
            return new UserResource($user);
        }
        catch (\Exception $exception){
            return [
                'massage'=>'No user found'
            ];
        }
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required |email',
            'password'=>'required|min:8'
        ])->validate();
        try{

            $user =User::findOrFail($id);
            $user->name =$request->name ;
            $user->email =$request->email ;
            $user->password =$request->password ;
            $user->update();
            return new UserResource($user);
        }
        catch (\Exception $exception){
            return [
                'massage'=>'No user found'
            ];
        }
    }
    public function destroy($id)
    {
        try{
            $user =User::findOrFail($id);
            $user->delete();
            return new UserResource($user);
        }
        catch (\Exception $exception){
            return [
                'massage'=>'No user found'
            ];
        }
    }

/**
* login api
*
* @return \Illuminate\Http\Response
*/
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }

}
