<?php

namespace App\Http\Controllers\Auth;

use App\Http\API\ApiConnector;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

class PublicLoginController extends Controller
{

    private $key = "ee95a16d763ab0d26ee62c53056df928";

    private function check_sing($params, $sing)
    {
        krsort($params);
        $sings_str = implode("", $params) . $this->key;
        return (md5($sings_str) === $sing);
    }

    private function create_response($data = null, $errors = null)
    {
        $response = [];
        if (isset($errors)) {
            $response['error'] = $errors;
            $response['result'] = false;
        } else {
            $response['error'] = 0;
            $response['result'] = true;
            if (isset($data)) {
                if (is_array($data) && count($data) > 0) {
                    $response['data'] = $data;
                } else {
                    $response['result'] = false;
                }
            }
        }
        $response['req_id'] = time() . rand(1000, 9999);
        return $response;
    }

    /**
     * Создает токен для авторизации
     *
     * @param  Request $data
     * прнимает
     *          email - эмаил пользователя в базе
     *          amhost_id - id пользователя в амхосте
     *          amhost_login - login пользователя в амхосте
     *
     * @return array
     *          error - массив с ошибками  если их нету то элемент содержит 0
     *          result - true - если нет ошибок и не пустой результат. в остальных случаях false.
     *          data - есть если есть какие то данные. может быть массивом.
     *
     * @todo
     *      проверять айпи запроса
     * @todo
     *       corsa
     *
     */
    public function generate_token(Request $request)
    {
        Log::debug($request->all());
        $v = Validator::make($request->all(), [
            'email' => 'required',
            'amhost_id' => 'required',
            'amhost_login' => 'required',
            'sing' => 'required'
        ]);
        $v->after(function ($v) use ($request) {
            if (!$this->check_sing($request->except('sing'), $request->sing)) {
                $v->errors()->add('sing', trans('incorrect sing'));
            }
        });

        //$request_ip = $request->ip();

        if ($v->fails()) {
            return response()->json($this->create_response(null, $v->errors()->all()));
        }

        $user = User::where('amhost_id', $request->amhost_id)->first();

        if (!isset($user)) {

            $apiconnector = ApiConnector::getInstance();
            $apiconnector->setApiUrl(env('API_URL_ADMIN'));
            $apiconnector->setAuthKey(env('API_KEY_ADMIN'));
            $api_key = $apiconnector->add_user($request->amhost_login, $request->email);

            if (isset($api_key->error)) {
                return response()->json($this->create_response(null, $api_key->error));
            }

            $user = new User();
            $user->email = $request->email;
            $user->amhost_id = $request->amhost_id;
            $user->amhost_login = $request->amhost_login;
            $user->password = bcrypt(str_random(10));
            $user->login_token = '';
            $user->login_token_expires = Carbon::now()->subDay();
            $user->api_key = $api_key->response;
            $user->save();
        }
        $user->login_token = str_random(50);
        $user->login_token_expires = Carbon::now();
        $user->save();

        return response()->json($this->create_response(['login_token' => $user->login_token]));
    }

    /**
     * авторизации по токену
     * время жизни токена 5 минут, если больше возращает на приведующую страницу
     * если токена нету то возвращает на предыдущую страницу
     *
     * @param Request $request
     *          token - ключ дла авторизации
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function token_login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'token' => 'required|exists:users,login_token'
        ]);

        if ($v->fails()) {
            return redirect()->back();
        }

        $user = User::where('login_token', $request->token)->first();
        $diff = Carbon::now()->diffInMinutes(Carbon::parse($user->login_token_expires));
        if ($diff < 5) {
            Auth::login($user);
            $user->login_token = '';
            $user->save();
            return redirect()->to('/');
        } else {
            return redirect()->back();
        }
    }
}
