<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Log;
use App\Jobs\Contacts\SendContactToEmailJob;

class TaskObserver
{
    public function updated(Task $task)
    {
        $task->logs()->create([
            'message' => 'task updated',
        ]);
    }
}
