<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain;
use App\Tariff;
use App\Status;
use Mail;
use App\Http\Payment\Biling;

class DomainController extends Controller
{
    const ACTIVE = 2;
    public function index()
    {
        $domains = Domain::with('tariff', 'status', 'user')->orderBy('created_at' ,'desc')->paginate(20);

        return view('admin.domain.index', ['domains' => $domains]);
    }

    public function show($id)
    {
        $tariffs = Tariff::all();
        $statuses = Status::all();
        $domain = Domain::findOrFail($id);

        return view('admin.domain.show', [
            'domain' => $domain,
            'statuses' => $statuses,
            'tariffs' => $tariffs
        ]);
    }

    public function update(Request $request, $id)
    {
        $domain = Domain::findOrFail($id);
        $res = null;

        if($request->status  == Biling::ACTIVE && $domain->status_id != Biling::ACTIVE){
            $user = $domain->user;
            $tariff = Tariff::find($request->tariff)->value;

            if($user->balance > $tariff){
                $user->balance -= $tariff;
                $user->save();
                $domain->begin_at = time();
                $domain->status_id = $request->status;
                $domain->tariff_id = $request->tariff;

                Mail::queue(
                    'emails.payed',
                    array(
                        'name' => $domain->name,
                        'tariff' => $tariff,
                        'date' => $domain->begin_at
                        ),
                    function ($message) use ($user){
                    $message->to($user->email)->subject('Payed');
                });
                $res = $domain->save();
            }

        } else {
            $domain->tariff_id = $request->tariff;
            $domain->status_id = $request->status;
            $res = $domain->save();
        }

        if($res) {
            return redirect()->back()
                ->with('successfully', 'Domain was success updated ');
        }

        return redirect()->back()
            ->with('error', 'Domain was not success updated ');
    }

    public function destroy($id)
    {
        $domain = Domain::findOrFail($id);
        $res = false;

        if($domain->status_id == Biling::REMOVED) $res = $domain->delete();

        if($res) {
            return redirect()->back()
                ->with('successfully', 'Domain deleted successfully');
        }

        return redirect()->back()
            ->with('error', 'Domain not deleted ');
    }
}
