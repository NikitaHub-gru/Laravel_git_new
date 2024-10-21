<?php

namespace App\Models\Report;

class SessionManager {
    public function closeSession($token) {
        $url = "https://dimmy-yammi-barnaul.iiko.it:443/resto/api/logout?key={$token}";
        file_get_contents($url);
    }
}
