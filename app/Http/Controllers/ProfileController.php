<?php

namespace App\Http\Controllers;

use App\Models\tr_company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        $breadcrumbTitle = 'List Property';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/property';
        $urlCategory = env('API_URL') . '/api/valueCategory';

        return view('dashboard.profile.index', [
            'title' => 'Profile',
        ]);
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        Log::debug('Data being sent to API:', [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'avatar' => $request->hasFile('avatar') ? 'avatar file present' : 'no avatar',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/profile';

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            '_method' => 'PUT',
        ];

        if ($request->hasFile('avatar')) {
            $response = Http::withToken($token)
                ->attach('avatar', fopen($request->file('avatar')->getRealPath(), 'r'), $request->file('avatar')->getClientOriginalName())
                ->post($url, $data);
        } else {
            $response = Http::withToken($token)->put($url, $data);
        }
        Log::debug('API Response:', ['response' => $response->json()]);

        if ($response->successful()) {
            session(['user' => $response->json()['data']]);

            return redirect('/profile')->with('success', 'Profile updated successfully.');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
            ]);
        }
    }

    public function company()
    {
        $breadcrumbTitle = 'List Property';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        $company = tr_company::first(); // Ambil data perusahaan pertama, Anda bisa menyesuaikan query sesuai kebutuhan.

        return view('dashboard.profile.company', [
            'title' => 'Company',
            'active' => 'company',
            'company' => $company
        ]);
    }

    public function updateCompany(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'logoo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        // Cari perusahaan yang akan diperbarui
        $company = tr_company::first();

        // Cek apakah perusahaan ditemukan
        if (!$company) {
            return redirect()->route('company')->with('error', 'Company not found.');
        }

        // Cek jika ada file logo yang diupload
        if ($request->hasFile('logoo')) {
            // Hapus logo lama jika ada
            if ($company->logoo && Storage::exists($company->logoo)) {
                Storage::delete($company->logoo);
            }
            // Simpan logo baru
            $path = $request->file('logoo')->store('public/logos');
            $company->logoo = $path;
        }

        // Update data perusahaan
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('company')->with('success', 'Company profile updated successfully.');
    }
}
