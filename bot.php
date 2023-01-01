<?php

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use StackbotNotifier\Controllers\GetReputationChangeLog;

$repChangeLog = new GetReputationChangeLog();
$response = json_decode($repChangeLog->getChangeLog(date("Y-m-d", strtotime("-1 days")), date("Y-m-d")), true);

$reputation_change = 0;

foreach($response['items'] as $item){
    $reputation_change += $item['reputation_change'];
}

$headers = 'From: ceo@businessvibes.fun' . "\r\n" .
    'Reply-To: ceo@businessvibes.fun' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail("vivekpisces23@gmail.com","StackBot Notification!","You have a reputation change of ". $reputation_change . ".", $headers)){
    echo "Notified via email!";
}else{
    echo "Failed to send email.";
}

