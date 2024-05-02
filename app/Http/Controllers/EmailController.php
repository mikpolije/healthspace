<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validasi data formulir
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Kirim email
        Mail::to('golongand21@gmail.com')->send(new SendEmail($request));

        // Kembalikan respons (Anda dapat menyesuaikan ini sesuai kebutuhan)
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
