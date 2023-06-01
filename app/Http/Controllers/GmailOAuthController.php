<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;

class GmailOAuthController extends Controller
{
    public function login(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(config('services.gmail.client_id'));
        $client->setClientSecret(config('services.gmail.client_secret'));
        $client->setRedirectUri(config('services.gmail.redirect'));
        $client->addScope('https://www.googleapis.com/auth/gmail.readonly');

        if ($request->has('code')) {
            $client->fetchAccessTokenWithAuthCode($request->get('code'));
            $request->session()->put('gmail_token', $client->getAccessToken());

            return redirect()->route('employees.gmail');
        } else {
            $authUrl = $client->createAuthUrl();

            return redirect()->away($authUrl);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('gmail_token');

        return redirect()->route('inbox');
    }
}
