<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class webhookController extends Controller
{
    public function handleWebhookChallenge(Request $request)
    {
        $token = config("services.monday.token");
        $challenge = $request->json('challenge');

        return response()->json(['challenge' => $challenge]);
    }
}
