<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\JsonFileWriter;
use App\Protocol\ProtocolPositionData;
use App\ReadLog;

$logPath = 'doc/Rastreador_Pacotes_Recebidos.log';

try {
    $logReader = new ReadLog($logPath);
    $logData = $logReader->getLog();
    $protocoloPosition = new ProtocolPositionData($logData);
    $data = $protocoloPosition->makeJson();
    $json = json_encode($data, JSON_PRETTY_PRINT);
    $file = new JsonFileWriter();
    $file->writeJsonToFile($json);
    echo $json;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}