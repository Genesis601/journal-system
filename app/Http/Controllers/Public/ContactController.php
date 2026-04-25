<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            Mail::to(env('ADMIN_EMAIL', config('mail.from.address')))
                ->send(new ContactFormMail(
                    $request->name,
                    $request->email,
                    $request->subject,
                    $request->message
                ));

            return redirect()->route('contact')
                             ->with('success', 'Your message has been sent! We will get back to you within 24-48 hours.');

        } catch (\Exception $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());

            return redirect()->route('contact')
                             ->with('error', 'Sorry, your message could not be sent. Please try again later.');
        }
    }
}