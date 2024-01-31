<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class boardController extends Controller
{

    public function retreiveBoards()
    {
        $token = config("services.monday.token");
        $apiUrl = "https://api.monday.com/v2";
        $headers = ["Content-Type: application/json", "Authorization: " . $token];

        $query = "{ boards { id name } }";

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

    public function createBoard()
    {
        $token = config("services.monday.token");
        $apiUrl = "https://api.monday.com/v2";
        $headers = ["Content-Type: application/json", "Authorization: " . $token];

        $query = "mutation {
            create_board (board_name: \"My Board\", board_kind: public) {
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

    public function duplicateBoard(Request $request)
    {
        $apiUrl = "https://api.monday.com/v2";
        $token = config("services.monday.token");
        $board_id = $request->board_id;

        $query = "mutation { duplicate_board(board_id: $board_id, duplicate_type: duplicate_board_with_structure) { board { id }}}";

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

    public function updateBoard(Request $request)
    {
        $apiUrl = "https://api.monday.com/v2";
        $token = config("services.monday.token");
        $board_id = $request->board_id;

        $query = "mutation { update_board(board_id: $board_id, board_attribute: description, new_value: \"This is my new description\")}";

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

    public function deleteBoard(Request $request)
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
