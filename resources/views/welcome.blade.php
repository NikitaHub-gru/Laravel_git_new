<?php

use App\Models\Report\AuthToken;
use App\Models\Report\OlapReport;
use App\Models\Report\SessionManager;
use App\Models\Report\DataProcessor;

$authToken = new AuthToken();
$olapReport = new OlapReport();
$sessionManager = new SessionManager();
$dataProcessor = new DataProcessor();

try {
    $token = $authToken->getToken();
    $dateFrom = $_GET['dateFrom'] ?? date('Y-m-d');
    $dateTo = $_GET['dateTo'] ?? date('Y-m-d');
    $report = $olapReport->getReport($token, $dateFrom, $dateTo);
    $sessionManager->closeSession($token);
    $processedData = $dataProcessor->processData($report);
    $error = null;
} catch (Exception $e) {
    $error = $e->getMessage();
    $processedData = [];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DimmiYammi - Информация о заказах</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>DimmiYammi - Информация о заказах</h1>
        
        <div class="info">
            <h2>Информация о системе</h2>
            <p>Версия PHP: <?php echo phpversion(); ?></p>
            <p>Сервер: DimmiYammi (<?php echo $_SERVER['SERVER_SOFTWARE']; ?>)</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error">
                <p>Произошла ошибка: <?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php else: ?>
            <h2>Заказы</h2>
            <div class="date-inputs">
                <input type="date" id="dateFrom" name="dateFrom" value="<?php echo $dateFrom; ?>">
                <input type="date" id="dateTo" name="dateTo" value="<?php echo $dateTo; ?>">
                <button id="todayButton">Сегодня</button>
                <button id="yesterdayButton">Вчера</button>
                <button id="refreshButton">Получить данные</button>
            </div>
            
            <div id="loading" style="display: none;">
                <div class="spinner"></div>
                <p>Загрузка данных...</p>
            </div>
            
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>Номер доставки</th>
                        <th>Время печати</th>
                        <th>Сервисная печать</th>
                        <th>Фактическое время</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($processedData as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['number']); ?></td>
                        <td><?php echo htmlspecialchars($order['time']); ?></td>
                        <td><?php echo htmlspecialchars($order['date']); ?></td>
                        <td><?php echo htmlspecialchars($order['actualTime']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="/js/script.js"></script>
</body>
</html>
