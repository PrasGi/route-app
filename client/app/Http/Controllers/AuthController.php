<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $client = new Client();
        $response = $client->post(env('API_URL') . '/auth/login', [
            'form_params' => $validated
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            return redirect()->back()->withErrors('failed', $body['message']);
        }

        $data = $body['data'];
        Cache::put('auth_token', $data['token']);
        Cache::put('user', $data['user']);

        return redirect()->route('dashboard');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $client = new Client();
        $response = $client->post(env('API_URL') . '/auth/register', [
            'form_params' => $validated
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            return redirect()->back()->withErrors('failed', $body['message']);
        }

        $data = $body['data'];
        Cache::put('auth_token', $data['token']);
        Cache::put('user', $data['user']);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Cache::forget('auth_token');
        Cache::forget('user');

        return redirect()->route('login.form');
    }
}
