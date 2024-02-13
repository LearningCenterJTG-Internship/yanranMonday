<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MondayBasicController extends Controller
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

    public function getAccountID(Request $request)
    {
        $query = 'query { account { id } }';
        $response = $this->dealWithQuery($query);
        $accountID = $response['account_id'];
        return $accountID;
    }

    public function getUsers(Request $request)
    {
        $query = 'query { users { id name } }';
        $response = $this->dealWithQuery($query);
        return $response;
    }

    public function sendNotifications(Request $request)
    {
        $user_id = $request->input('user_id');
        $item_id = $request->input('item_id');

        $mutation = "
          mutation {
            create_notification(
              text: \"I've got a notification for you!\",
              user_id: {$user_id},
              target_id: {$item_id},
              target_type: Project,
              internal: true
            ) { 
              id 
            }
          }
        ";

        $response = $this->dealWithQuery($mutation);
        return $response;
    }

    public function setSettings(Request $request)
    {
        $mutation = 'mutation { set_settings(data: {"text": "the new updated value"}) { id } }';
        $response = $this->dealWithQuery($mutation);
    }

    public function setLocation(Request $request)
    {
        $param = [
            'foo' => 'bar'
        ];
        
        $mutation = 'mutation { set_location(data: { query: ' . json_encode($queryParams) . ' }) { id } }';
        $response = $this->dealWithQuery($mutation);
    }
}
