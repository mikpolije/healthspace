<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        Mail::to('destination@example.com')->send(new ContactMail($validated));

        return back()->with('success', 'Thank you for your message!');
    }
}