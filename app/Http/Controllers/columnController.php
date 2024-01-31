<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class columnController extends Controller
{
    public function retrieveColumns()
    {
        $token = config("services.monday.token");
        $apiUrl = "https://api.monday.com/v2";
        $headers = ["Content-Type: application/json", "Authorization: " . $token];

        $query = "{ columns { id name } }";

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

    public function createColumn()
    {
        $token = config("services.monday.token");
        $apiUrl = "https://api.monday.com/v2";
        $headers = ["Content-Type: application/json", "Authorization: " . $token];

        $query = "mutation {
            create_column(
              board_id: 1234567890
              title: 'Keywords'
              column_type: dropdown
              description: 'This column indicates which keywords to include in each project.'
              defaults: '{\"settings\":{\"labels\":[{\"id\":1,\"name\":\"Technology\"}, {\"id\":2,\"name\":\"Marketing\"}, {\"id\":3,\"name\":\"Sales\"}]}}'
            ) {
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

    public function updateColumn(Request $request)
    {
        $apiUrl = "https://api.monday.com/v2";
        $token = config("services.monday.token");
        $board_id = $request->board_id;
        $item_id = $request->item_id;

        $query = "mutation {
            change_simple_column_value (board_id: $board_id, item_id: $item_id, column_id: 'status', value: 'Working on it') {
              id
            }
        }";
        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token
        ];

        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => $headers,
                'content' => json_encode(['query' => $query]),
            ]
        ]));

        $responseContent = json_decode($data, true);
        echo json_encode($responseContent);
    }

    // change_column_title
    // change_column_metadata - same as above

    public function delete_column(Request $request)
    {
        $apiUrl = "https://api.monday.com/v2";
        $token = config("services.monday.token");
        $board_id = $request->board_id;

        $query = "mutation { delete_board (board_id: $board_id) { id }}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token
        ];

        $data = @file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => $headers,
                'content' => json_encode(['query' => $query]),
            ]
        ]));

        $responseContent = json_decode($data, true);

        echo json_encode($responseContent);
    }
}
