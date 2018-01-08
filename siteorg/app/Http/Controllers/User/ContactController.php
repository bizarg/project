<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Contact;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::user()->id)->get();

        return view('user.contact.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required',
            'contact'   => 'required'
        ]);

        $result = Contact::create([
            'user_id'   => Auth::user()->id,
            'type'      => $request->type,
            'contact'   => $request->contact
        ]);

        if($result) return redirect()->route('contact.index')->with('success', 'Contact was created');

        return redirect()->back()->with('fail', 'Contact was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('user.contact.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $this->validate($request, [
            'type'      => 'required',
            'contact'   => 'required'
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update($request->all());

        return redirect()->route('contact.index')->with('success', 'Contact update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Contact::findOrFail($id);

        if($article->delete())
            return redirect()->route('contact.index')->with('success', 'Contact destroy successful');

        return redirect()->route('contact.index')->with('fail', 'Contact not destroy');
    }
}
