<?php


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function storeErrorLog(Throwable $th, $title): void
{
    Log::warning($title, [
        'message' => $th->getMessage(),
        'stack' => $th
    ]);
}


/**
 * @param string $url
 * @param string $token
 * @return array
 */
function getRequest(string $url, string $token): array
{
    try {
        $response = Http::withHeaders(
            [
                'Authorization' => "Bearer $token"
            ]
        )
            ->get($url);

        Log::warning("Req Fetching articles...", [
            'response' => $response,
            "token" => $token,
            "url" => $url,
        ]);
        if ($response->successful()) {
            return [
                'status' => "success",
                'data' => $response->json(),
            ];
        }

        return [
            'status' => "error",
            'data' => null
        ];

    } catch (Throwable $th) {
        storeErrorLog($th, 'HTTP Request Exception:');
        return [
            'status' => "error 1",
            'message' => $th->getMessage()
        ];
    }
}


function returnDate($date_)
{
   return !empty($date_) ? date('Y-m-d', strtotime($date_)) : Carbon::now()->format('Y-m-d');
}
