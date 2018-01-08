<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Class DomainController
 * @package App\Http\Controllers
 */
class DomainController extends Controller
{
    /**
     * DomainController constructor.
     */
    public function __construct()
    {
        $this->add_domain_rule();
    }


    /**
     *Add domain rule
     */
    protected function add_domain_rule()
    {
        Validator::extend('domain', function ($attribute, $value) {
            if (!(preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value) //valid chars check
                && preg_match("/^.{1,253}$/", $value) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $value))
            ) {
                return false;
            } else {
                return true;
            }

        }, 'Bad domain format');
    }

    /**
     * Show user domains
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_domains()
    {
        $user = Auth::user();
        $domains = Domain::where('user_id', $user->id)->get();
        return view('service.domains', ['domains' => $domains]);
    }


    /**
     * Confirm user domain
     * @param $id
     * @return string
     */
    public function domain_confirm($id)
    {
        $user = Auth::user();
        $v = Validator::make(
            ['id' => $id],
            ['id' => 'exists:domains,id,user_id,' . $user->id]
        );
        if ($v->fails()) {
            return 'not confirmed';
        }

        $domain = Domain::find($id);
        if ($this->domain_confirm_file($domain)) {
            $domain->status = 'confirmed';
            $domain->save();
            return 'confirmed';
        }
        return 'not confirmed';

    }

    /**
     * Confirm domain by file
     * @param $domain
     * @return bool
     */
    protected function domain_confirm_file($domain)
    {
        $file_url = 'http://' . $domain->domain . '/' . $domain->token . '.txt';
        $headers = @get_headers($file_url);
        if (strpos($headers[0], '200')) {
            return true;
        }
        return false;
    }

    /**
     * Confirm domain by meta
     * @param $domain
     * @return bool
     */
    public function domain_confirm_meta($domain)
    {
        $file_url = 'http://' . $domain->domain . '/';
        $content = @file_get_contents($file_url);

        if (strpos($content, "<meta name='loadservice-verification' content='" . $domain->tocken . "'>") !== false) {
            return true;
        }
        return false;
    }

    /**
     * File with token
     * @param $id
     * @return $this
     */
    public function domain_token_file($id)
    {
        $user = Auth::user();
        $v = Validator::make(
            ['id' => $id],
            ['id' => 'exists:domains,id,user_id,' . $user->id]
        );
        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $domain = Domain::find($id);

        return response('')
            ->header('content-type', 'text/plain')
            ->header('Content-Disposition', ' attachment; filename="' . $domain->token . '.txt"');
    }


    /**
     * delete domain
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function domain_delete($id)
    {
        $user = Auth::user();
        Domain::where('id', $id)->where('user_id', $user->id)->delete();
        return redirect()->to('/domains');
    }

    /**
     * Add domain token
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function domain_update_token($id)
    {
        $user = Auth::user();
        $domain = Domain::where('id', $id)->where('user_id', $user->id)->first();
        if (!is_null($domain)) {
            $domain->token = str_random(32);
            $domain->status = 'not confirmed';
            $domain->expired = date('Y-m-d H:i:s', strtotime('+3 days'));
            $domain->save();
        }

        return redirect()->to('/domains');

    }

    /**
     * Add new domain
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function domain_add(Request $request)
    {
        $request->merge(array_map('trim', $request->all()));
        $rules = [
            'domain' => 'domain|required|unique:domains,domain',
        ];


        $v = Validator::make($request->all(), $rules);


        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $user = Auth::user();
        $domain = new Domain();

        $domain->user_id = $user->id;
        $domain->domain = $request->domain;
        $domain->token = str_random(32);
        $domain->expired = date('Y-m-d H:i:s', strtotime('+3 days'));
        if ($user->role == 'admin') {
            $domain->status = 'confirmed';
        }

        $domain->save();
        return redirect()->to('/domains');
    }
}
