<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function __construct()
    {
        $this->token = config("services.monday.token");
        $this->apiUrl = "https://api.monday.com/v2";
        $this->headers = ["Content-Type: application/json", "Authorization: " . $this->token];
    }

    protected function dealWithQuery($query)
    {
        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => $this->headers,
                "content" => json_encode(["query" => $query]),
            ]
        ]));
        $response = json_decode($data, true);
        return $response;
    }

    public function sendNotification($user_id, $target_id, $text)
    {
        $mutation = "mutation { create_notification (user_id: \"$user_id\", target_id: \"$target_id\", text: \"$text\", target_type: Project) { text } }";

        $response = $this->dealWithQuery($mutation);
    }
}
