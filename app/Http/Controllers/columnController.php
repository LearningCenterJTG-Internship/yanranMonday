<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class columnController extends Controller
{
    protected $token;
    protected $apiUrl;

    public function __construct()
    {
        $this->token = config("services.monday.token");
        $this->apiUrl = "https://api.monday.com/v2";
    }

    public function retrieveColumns()
    {
        $headers = ["Content-Type: application/json", "Authorization: " . $this->token];

        $query = "{ columns { id name } }";

        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
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
        $headers = ["Content-Type: application/json", "Authorization: " . $this->token];

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
          
        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
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
        $board_id = $request->board_id;
        $item_id = $request->item_id;

        $query = "mutation {
            change_simple_column_value (board_id: $board_id, item_id: $item_id, column_id: 'status', value: 'Working on it') {
              id
            }
        }";
        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $this->token
        ];

        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
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
        $board_id = $request->board_id;

        $query = "mutation { delete_board (board_id: $board_id) { id }}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $this->token
        ];

        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => $headers,
                'content' => json_encode(['query' => $query]),
            ]
        ]));

        $responseContent = json_decode($data, true);

        echo json_encode($responseContent);
    }

    public function column_value(Request $request)
    {

        $query = "query { boards (ids: 1234567890) { items (ids: 9876543210) { column_values { value text }}}}";

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $this->token
        ];

        $data = @file_get_contents($this->apiUrl, false, stream_context_create([
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
