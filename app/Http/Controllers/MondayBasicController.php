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
        \Log::info("This is user response: ", $response);
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
