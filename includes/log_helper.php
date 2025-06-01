<?php
function write_log($message, $type = 'INFO') {
    $logFile = __DIR__ . '/../logs/app.log'; // folder logs di luar 'includes'
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp][$type]: $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
