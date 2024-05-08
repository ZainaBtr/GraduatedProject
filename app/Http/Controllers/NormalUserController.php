<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\NormalUser\NormalUser1;
use App\Http\Requests\NormalUser\NormalUser2;
use App\Http\Requests\NormalUser\NormalUser3;
use App\Http\Requests\NormalUser\NormalUser4;
use App\Http\Requests\NormalUser\NormalUser5;
use App\Models\NormalUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class NormalUserController extends Controller
{

    public function showProfile()
    {
        $user = Auth::user();
        if(!$user){
            return response()->json(['message'=>'user not found']);
        }
        if(request()->is('api/*')){
            return response()->json($user);
        }
        return view('');
    }

    public function showAll()
    {
        $normalUsers=NormalUser::query()->get()->all();
        $result[]=array();
        foreach ($normalUsers as $normalUser){
            $result[] = User::query()->where('id',$normalUser['userID'])->first();
        }

        if(request()->is('api/*')){
            return response()->json($result);
        }
        return view('');

    }

    public function completeAccount1(NormalUser1 $request)
    {
        $user = User::where('password',$request['password'])->first();

        if(!$user){
            return response()->json(['message' => 'Account Not Found']);
        }

        $request['password']=Hash::make($request['password']);
        $tokenResult = $user->createToken('Personal Access Token');
        $data["user"]= $user;
        $data["token_type"]='Bearer';
        $data["access_token"]=$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }

   public function completeAccount2(NormalUser2 $request)
    {
        $user = Auth::user();
        $user->normalUser()->update($request->validated());
        return response()->json($user,Response::HTTP_OK);
    }

   public function completeAccount3(NormalUser3 $request)
    {
        $user = Auth::user();
        $user->update(['email'=> $request['email']]);

        $this->sendEmail($request['email']);
    }

   public function completeAccount4(NormalUser4 $request)
    {
        $user = Auth::user();
        $user->normalUser()->update(['skills'=> $request['skills']]);
        return response()->json($user,Response::HTTP_OK);
    }

    public function updateEmail(NormalUser3 $request)
    {
        $user = Auth::user();
        $user->update(['email' => $request['email']]);
        $this->sendEmail($user['email']);
    }

    public function deleteAllAccounts( )
    {
        $normalUsers = NormalUser::query()->get()->all();

        foreach ($normalUsers as $normalUser){
            User::where('id', $normalUser['userID'])->delete();
        }

        NormalUser::query()->delete();

        if(request()->is('api/*')){
            return response()->json(['message' => ' Normal Users Deleted Successfully']);
        }
        return view('');
    }

}
