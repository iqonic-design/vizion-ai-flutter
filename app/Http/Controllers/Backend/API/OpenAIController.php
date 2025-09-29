<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OpenAIController extends Controller
{


    public function ChatCompletion(Request $request)
    {


        $openaiApiKey = "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";  // Replace with your 
        $openaiEndpoint = 'https://api.openai.com/v1/chat/completions';

        $client = new Client();

        $response = $client->post($openaiEndpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $openaiApiKey,
            ],
            'json' => $request->all(),
            'stream' => true,
        ]);

        return response()->stream(
            function () use ($response) {
                $body = $response->getBody();
                while (!$body->eof()) {

                    ob_flush();
                    flush();
                }
            },
            $response->getStatusCode(),
            $response->getHeaders()
        );


    }


}
