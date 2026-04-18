<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_tagline'     => 'nullable|string|max:255',
            'contact_email'    => 'nullable|email',
            'contact_phone'    => 'nullable|string',
            'contact_address'  => 'nullable|string',
        ]);

        foreach ($request->except('_token', '_method') as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Settings updated successfully!');
    }
}