<?php

namespace App\Models;

require_once __DIR__ . '/Report/AuthToken.php';
require_once __DIR__ . '/Report/OlapReport.php';
require_once __DIR__ . '/Report/SessionManager.php';
require_once __DIR__ . '/Report/DataProcessor.php';

use App\Models\Report\AuthToken;
use App\Models\Report\OlapReport;
use App\Models\Report\SessionManager;
use App\Models\Report\DataProcessor;

class Report {
    private $authToken;
    private $olapReport;
    private $sessionManager;
    private $dataProcessor;

    public function __construct() {
        $this->authToken = new AuthToken();
        $this->olapReport = new OlapReport();
        $this->sessionManager = new SessionManager();
        $this->dataProcessor = new DataProcessor();
    }

    public function getReportData($dateFrom, $dateTo) {
        try {
            $token = $this->authToken->getToken();
            $report = $this->olapReport->getReport($token, $dateFrom, $dateTo);
            $this->sessionManager->closeSession($token);
            
            $processedData = $this->dataProcessor->processData($report);
            
            return [
                'success' => true, 
                'data' => $processedData,
                'messages' => [
                    'Токен успешно получен',
                    'Данные успешно получены',
                    'Сессия успешно закрыта'
                ]
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
