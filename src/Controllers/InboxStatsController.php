<?php

namespace StackbotNotifier\Controllers;

class InboxStatsController{
    public function getUnreadNotifications($fromDate){
        $fromDate = strtotime($fromDate);
        return APIController::makeAPICall('INBOX.UNREAD', [
            'page' => 1,
            'pagesize' => 10,
            'since' => $fromDate,
            
        ]);
    }
}