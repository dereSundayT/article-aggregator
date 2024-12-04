<?php


use Illuminate\Support\Facades\Log;

function storeErrorLog(Throwable $th, $title): void
{
    Log::error($title, [
        'message' => $th->getMessage(),
        'stack'=>$th
    ]);
}
{

}
