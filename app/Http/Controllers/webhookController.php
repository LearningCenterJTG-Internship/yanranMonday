<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class webhookController extends Controller
{
    public function handleWebhookChallenge(Request $request)
    {
        $eventType = $request->input('event')['type'];
        \Log::info($eventType);
        switch ($eventType) {
            case 'create_pulse':
                $this->handleItemCreate($request);
                break;
            case 'create_column':
                $this->handleColumnCreate($request);

            default:
                break;
        }

        return response()->json(['success' => true]);
    }

    private function handleItemCreate(Request $request)
    {
        \Log::info($request);
    }

    private function handleColumnCreate(Request $request)
    {
        \Log::info($request);
    }

}
