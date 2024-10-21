<?php

namespace App\Models\Report;

class DataProcessor
{
    public function processData($report)
    {
        $processedData = [];
        if (isset($report['data']) && is_array($report['data'])) {
            foreach ($report['data'] as $row) {
                $key = $row['Delivery.Number'] ?? 'Неизвестно';
                if (!isset($processedData[$key]) || ($row['DishServicePrintTime'] ?? '') < ($processedData[$key]['time'] ?? '')) {
                    $processedData[$key] = [
                        'number' => $row['Delivery.Number'] ?? 'Неизвестно',
                        'time' => $row['DishServicePrintTime'] ?? 'Нет информации',
                        'date' => $row['OpenDate.Typed'] ?? 'Нет информации',
                        'actualTime' => $row['Delivery.ActualTime'] ?? 'Нет информации'
                    ];
                }
            }
        }
        return array_values($processedData);
    }
}
