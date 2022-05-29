<?php

namespace App\Helpers;

use App\Models\Creator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class GetTriviaApiToken
{
    private CONST URL = 'https://opentdb.com/api_token.php';
    public static function generate(bool $reset = false , Creator $creator = null) : string
    {
        $verify = App::environment('local') ? false : true;
        $token =  $creator->trivia_token ?? '';
        if($reset) {
             Http::withOptions(['verify' => $verify])->get( self::URL , [
                'command' => 'reset',
                'token' => $token
            ]);


        }


        $token = Http::withOptions(['verify' => $verify])->get(self::URL , [
            'command' => 'request'
        ]);
        return json_decode($token)->token;

    }
}
