<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Auth;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::where('created_by', Auth::user()->id)->get();

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $contact = $request->only(['name', 'company', 'phone', 'email']);
        $contact['created_by'] = Auth::user()->id;
        
        if ($contact['name'] && Contact::create($contact)) {
            // @TODO: Add flash message
            
            return redirect()->route('contacts.index');
        }

        // @TODO: Add flash message

        return redirect()->route('contacts.create');
    }

    public function edit(Contact $contact)
    {
        if ($contact && $contact->created_by != Auth::user()->id) {
            return redirect()->route('contacts.index');
        }

        return view('contacts.edit', compact('contact'));
    }

    public function update(Contact $contact, Request $request)
    {
        $update = $request->only(['name', 'company', 'phone', 'email']);
        $update['created_by'] = Auth::user()->id;
        
        if ($update['name'] && $contact->update($update)) {
            // @TODO: Add flash message
            
            return redirect()->route('contacts.index');
        }

        // @TODO: Add flash message

        return redirect()->route('contacts.edit', [$contact->id]);
    }

    public function delete(Contact $contact)
    {
        if ($contact->created_by == Auth::user()->id) {
            $contact->delete();
            // @TODO: Add flash message
        }

        return redirect()->route('contacts.index');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $contacts = Contact::where('created_by', Auth::user()->id)
            ->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('company', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            })
        ->paginate(2);

        return response()->json($contacts);
    }
}
