<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Contact;


class ContactController extends Controller
{
    public function create($id)
    {
        return view('admin.users.contacts.create', ['user_id' => $id]);
    }

    public function store(Request $request, $user_id)
    {
        $this->validate($request, [
            'type'      => 'required',
            'contact'   => 'required'
        ]);

        $result = Contact::create([
            'user_id'   => $request->user_id,
            'type'      => $request->type,
            'contact'   => $request->contact
        ]);

        if($result) return redirect()->route('users.show', [$user_id])->with('success', 'Contact was created');

        return redirect()->back()->with('fail', 'Contact was created');
    }

    public function edit($id, $user_id)
    {
        $contact = Contact::findOrFail($id);

        return view('admin.users.contacts.edit', ['contact' => $contact, 'user_id' => $user_id]);
    }

    public function update(Request $request,  $id, $user_id)
    {
        $this->validate($request, [
            'type'      => 'required',
            'contact'   => 'required'
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update($request->all());

        return redirect()->route('users.show', [$user_id])->with('success', 'Contact update successful');
    }

    public function delete($contact_id, $user_id)
    {
        $contact = Contact::findOrFail($contact_id);

        if($contact->delete()) return redirect()->route('users.show', [$user_id])->with('success', 'Contact was deleted');

        return redirect()->back()->with('fail', 'Contact was deleted');
    }
}
