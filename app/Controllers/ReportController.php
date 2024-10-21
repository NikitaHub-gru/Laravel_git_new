<?php

namespace App\Controllers;

use App\Models\Report\AuthToken;
use App\Models\Report\OlapReport;
use App\Models\Report\SessionManager;
use App\Models\Report\DataProcessor;
use Exception;

class ReportController {
    public function index() {
        $authToken = new AuthToken();
        $olapReport = new OlapReport();
        $sessionManager = new SessionManager();
        $dataProcessor = new DataProcessor();

        $dateFrom = $_GET['dateFrom'] ?? date('Y-m-d');
        $dateTo = $_GET['dateTo'] ?? date('Y-m-d');

        return view('welcome', [
            'authToken' => $authToken,
            'olapReport' => $olapReport,
            'sessionManager' => $sessionManager,
            'dataProcessor' => $dataProcessor,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }

    public function refresh() {
        $authToken = new AuthToken();
        $olapReport = new OlapReport();
        $sessionManager = new SessionManager();
        $dataProcessor = new DataProcessor();

        $dateFrom = $_POST['dateFrom'] ?? date('Y-m-d');
        $dateTo = $_POST['dateTo'] ?? date('Y-m-d');
        
        try {
            $token = $authToken->getToken();
            $report = $olapReport->getReport($token, $dateFrom, $dateTo);
            $sessionManager->closeSession($token);
            
            $processedData = $dataProcessor->processData($report);
            
            $result = [
                'success' => true,
                'data' => $processedData,
                'messages' => [
                    'Токен успешно получен',
                    'Данные успешно получены',
                    'Сессия успешно закрыта'
                ]
            ];
        } catch (Exception $e) {
            $result = ['success' => false, 'error' => $e->getMessage()];
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
