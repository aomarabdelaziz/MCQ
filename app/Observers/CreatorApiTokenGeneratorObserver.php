<?php

namespace App\Observers;

use App\Helpers\GetTriviaApiToken;
use App\Models\Creator;

class CreatorApiTokenGeneratorObserver
{
    public function creating(Creator $query)
    {

        $query->trivia_token = GetTriviaApiToken::generate();

    }
}
