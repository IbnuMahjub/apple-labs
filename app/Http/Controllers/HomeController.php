<?php

namespace App\Http\Controllers;

use App\Models\tm_category;
use App\Models\tr_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'blue');
        session(['theme' => $theme]);
        return response()->json(['success' => true]);
    }

    public function index()
    {
        return view('home', [
            'title' => 'Home',
            'data' => tr_post::with('category')->get()
        ]);
    }

    public function show($slug)
    {
        return view('detail', [
            'title' => 'Detail Post',
            'data' => tr_post::with('category')->where('slug', $slug)->first(),
            'categories' => tm_category::all()
        ]);
    }


    public function showProperties($slug)
    {
        $url = env('API_URL') . '/api/data_property/' . $slug;
        $response = Http::get($url);
        // dd($response->json()['data']);
        if ($response->successful()) {
            return view('detail', [
                'title' => 'Home',
                'data' => $response->json()['data']
            ]);
        }
    }


    public function tentang_kami()
    {
        return view('tentang_kami', [
            'title' => 'Tentang Kami',
        ]);
    }
}
