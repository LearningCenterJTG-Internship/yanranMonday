<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class webhookController extends Controller
{
    public function handleWebhookChallenge(Request $request)
    {
        if ($request->has('event')) {
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
        }
        return response()->json(['success' => true]);
        //return $request;
    }

    private function handleItemCreate(Request $request)
    {
        $user_id = 54942708;
        $target_id = 1840770844;
        $text = "New item has been added to the board";
        $notificationController = new notificationController();
        $notificationController->sendNotification($user_id, $target_id, $text);
    }

    private function handleColumnCreate(Request $request)
    {
        $user_id = 54942708;
        $target_id = 1840770844;
        $text = "New column has been added to the board";
        $notificationController = new notificationController();
        $notificationController->sendNotification($user_id, $target_id, $text);
    }

}
