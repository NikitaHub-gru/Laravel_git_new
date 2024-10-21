<?php

namespace App\Models\Report;

class AuthToken
{
    public function getToken()
    {
        $url = "https://dimmy-yammi-barnaul.iiko.it:443/resto/api/auth?login=rlabs&pass=a4f7d1b395053edf689325d6f5056ceba1ccf792";
        $response = file_get_contents($url);
        return trim($response, '"');
    }
}
