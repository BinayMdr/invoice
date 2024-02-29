<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-contacts')) return back();
        $contact = Contact::first();
        return view('pages.contact.edit-create',compact('contact'));
    }

    public function update(Request $request)
    {
        if(\Auth::user()->hasRole('edit-contacts') || \Auth::user()->hasRole('add-contacts'))
        { 
            $data = $request->validate([
                'country' => 'required',
                'email' => 'required|email',
                'number' => 'required'
            ]);

            if(is_null(Contact::first()))
            {
                if(!is_null($request['address'])) $data['address'] = $request['address'];
                Contact::create($data);
            }        
            else
            {
                $contact = Contact::first();
                $data['address'] = $request['address'];
                $contact->update($data);
            }

            return redirect()->back()->with('success','Contact updated');
        }
        return back();
    }
}
