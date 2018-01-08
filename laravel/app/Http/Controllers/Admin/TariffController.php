<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tariff;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::all();

        return view('admin.tariff.index', ['tariffs' => $tariffs]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha_dash',
            'value' => 'required|numeric|min:1'
        ]);

        $res = Tariff::create([
            'name' => $request->name,
            'value' => $request->value
        ]);

        if($res) return redirect()->back()
            ->with('successfully', 'The tariff was successfully created');

        return redirect()->back()
            ->with('error', 'The tariff is not compulsory');
    }

    public function edit($id)
    {
        $tariff = Tariff::findOrFail($id);

        return view('admin.tariff.edit', ['tariff' => $tariff]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|alpha_dash',
            'value' => 'required|numeric|min:1'
        ]);

        $res = Tariff::findOrFail($id)->update([
            'name' => $request->name,
            'value' => $request->value
        ]);

        if($res) return redirect('admin/tariff')
            ->with('successfully', 'The tariff was successfully update');

        return redirect()->back()
            ->with('error', 'The tariff is not update');
    }

    public function destroy($id)
    {
        $tariff = Tariff::findOrFail($id);

        if(count($tariff->domains)) return $this->useRedirect('error', 'This tariff is used');

        $res = Tariff::destroy($id);

        if($res)
            return $this->useRedirect('successfully', 'The tariff is deleted', 'admin/tariff');

        return $this->useRedirect('error', 'The tariff is not deleted');

    }

    private function useRedirect($value, $message, $url = null){

        if($url === null) return redirect($url)->back()->with($value, $message);

        return redirect($url)->with($value, $message);
    }

}
