<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class docController extends Controller
{
    public function createDoc()
    {
        $token = config("services.monday.token");
        $apiUrl = "https://api.monday.com/v2";
        $headers = ["Content-Type: application/json", "Authorization: " . $token];

        $query = "mutation {
            create_doc (location: {workspace: { workspace_id: 12345678, name:'New doc', kind: private}}) {
              id
            }
          }";
          
        $data = @file_get_contents($apiUrl, false, stream_context_create([
            "http" => [
            "method" => "POST",
            "header" => $headers,
            "content" => json_encode(["query" => $query]),
            ]
        ]));
        $responseContent = json_decode($data, true);

        echo json_encode($responseContent);
    }
}
