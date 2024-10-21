<?php

namespace App\Models\Report;

class OlapReport {
    public function getReport($token, $dateFrom, $dateTo) {
        $url = "https://dimmy-yammi-barnaul.iiko.it:443/resto/api/v2/reports/olap?key={$token}";
        $data = [
            "reportType" => "SALES",
            "groupByRowFields" => [
                "Delivery.Number",
                "DishServicePrintTime",
                "OpenDate.Typed",
                "Delivery.ActualTime"
            ],
            "groupByColFields" => [],
            "aggregateFields" => [],
            "filters" => [
                "OpenDate.Typed" => [
                    "filterType" => "DateRange",
                    "periodType" => "CUSTOM",
                    "from" => $dateFrom,
                    "to" => $dateTo,
                    "includeLow" => "true",
                    "includeHigh" => "true"
                ]
            ]
        ];
        
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
