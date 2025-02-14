<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for due tasks';

    /**
     * Execute the console command.
     */
   
     public function handle()
     {
         $tasks = Task::where('due_date', '<=', now()->addDay())->where('status', 'pending')->get();
 
         foreach ($tasks as $task) {
             Mail::raw("Reminder: Task '{$task->title}' is due soon!", function ($message) use ($task) {
                 $message->to($task->assignedUser->email)->subject('Task Reminder');
             });
         }
     }
}
