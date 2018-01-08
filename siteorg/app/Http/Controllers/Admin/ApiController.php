<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rospotrebnadzor;
use App\Types\Error;
use App\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class ApiController extends Controller
{


    /**
     * ApiController constructor.
     */
    public function __construct()
    {
    }

    /**
     * Добавление пользоватя
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAddOrCreate(Request $request)
    {
        $data = $request->data;
        $parentUser = isset($request->user) ? $request->user : null;
        $site = null;
        $response = [];

        Log::info("API Admin get user");


        $messages = [
            'email.required' => Error::email_required,
            'email.email' => Error::email_not_valid,
            'name.required' => Error::name_required,

        ];

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'name' => 'required',
        ], $messages);


        if ($validator->fails()) {
            $response['error'] = $validator->errors()->all();
            return response()->json($response);
        }

        $user = User::where('email', $data['email'])->first();
        if (!isset($user)) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->api_key = Uuid::uuid();
            $user->password = bcrypt(str_random());
            $user->parent_id = isset($parentUser) ? $parentUser->id : null;
            $user->save();
        }

        $response['response'] = $user->api_key;
        return response()->json($response);
    }

    /**
     * Список подписчиков
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildUsers(Request $request)
    {
        $data = $request->data;

        $site = null;
        $response = [];

        Log::info("API Admin get child users");


        $q = User::select('name', 'email', 'api_key')->orderBy('id', 'desc');
        if (isset($request->user)) {
            $q->where('parent_id', $request->user->id);
        }
        $users = $q->get();

        $response['response'] = $users;
        return response()->json($response);
    }
}
