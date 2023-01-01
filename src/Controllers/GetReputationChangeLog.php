<?php

namespace StackbotNotifier\Controllers;

class GetReputationChangeLog{
    public function getChangeLog($fromDate, $toDate){
        $fromDate = strtotime($fromDate);
        $toDate = strtotime($toDate);
        return APIController::makeAPICall('REPUTATION.CHANGE', [
            'page' => 1,
            'pagesize' => 10,
            'fromdate' => $fromDate,
            'todate' => $toDate,
            'site' => 'stackoverflow'
        ]);
    }
}