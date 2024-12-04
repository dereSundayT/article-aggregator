<?php


use Illuminate\Support\Facades\Log;

function storeErrorLog(Throwable $th, $title): void
{
    Log::warning($title, [
        'message' => $th->getMessage(),
        'stack'=>$th
    ]);
}
{

}
