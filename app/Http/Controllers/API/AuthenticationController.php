<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
class AuthenticationController extends BaseController
{
    protected $authenticationService;
    function  __construct(AuthenticationService $authenticationService){

        $this->authenticationService= $authenticationService;
    }


    public function authenticate(Request $request)
    {

        
        $validator = Validator::make($request->all(), $this->authenticationService->validateUser());

        if ($validator->fails()) {
            return  $this->jsonResponseError( $validator->errors(),422,"");

        }
        $user = User::where('member_id', $request->member_id)
                    ->where('club_id', $request->club_id)
                    ->first();

        if (!$user) {

            return  $this->jsonResponseError( "something went wrong ",404,"");

        }
        if (!Hash::check($request->password, $user->password)) {
            return  $this->jsonResponseError( "Invalid ids and password ",404,"");
        }

        $token = $user->createToken('API Access Token')->accessToken;

        $returnData=[
            'user'=>UserResource::collection( $user),
            'token'=>  $token
        ];

        return $this->jsonResponse(      $returnData,"Authenticated successfully",200);


    }
}
