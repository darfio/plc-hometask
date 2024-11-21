<?php

namespace App\Traits;

trait StatusProcesses
{    
    protected static $statuses = [
        'paused', 'in progress', 'testing', 'released',
    ];

    static public function getStatuses(){
        return self::$statuses;
    }

    public function changeStatus($status){
        if(!in_array($status, self::getStatuses())){
            throw new \Exception('status is wrong');
        }
        $this->status = $status;
        $this->update();
    }
}