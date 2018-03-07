<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Auth;
use DB;

// SQL TABLES RELATIONS
use App\User;
use App\Task;
use App\Priority;
use App\Frequency;

Class taskController extends BaseController {

    /**
     * 
     */
    public function getTask() 
    {
        
    }

    /**
     * Create task
     * @param Request $request
     */
    public function createTask(Request $request) 
    {
        // Validate input data from request
        var_dump(auth()->user());
        $this->validate($request, [
            'name, author, description' => 'required'
        ]);

        if ($request->isMethod('post'))
        {
            $task = Task::create([
                'name' => $request->input('name'),
                'author' => $request->input('author'),
                'order' => $request->input('order'),
                //'start_date' => $request->input('start_date'),
                //'end_date' => $request->input('end_date'),
                'description' => $request->input('description')
            ]);
        }
    }

    /**
     * 
     */
    public function updateTask(Request $request)
    {

    }

    /**
     * Find a task by name of this
     */
    public function findOneTask(Request $request) 
    {
        $task = Task::where("name", "=", $request->input("name"))->first();
        if ($task) 
        {
            if ($task->parent_id != '') 
            {
                $parent = $this->findParentTask($task->parent_id);
            }
            
            if ($task->priority_id != '') 
            {
                $priority = $this->findPriority($task->priority_id);
            }

            if ($task->frequency_id != '') 
            {
                $frequency = $this->findFrequency($task->frequency_id);
            }
            
            return response()->json([
                'name' => $task->name,
                'author' => $task->author,
                'order' => $task->order,
                'description' => $task->description,
                // contains parent name of this current task
                'parent' => $parent,
                // contains an array with name of category and this associate color
                'frequency_id' => $frequency,
                'priority_id' => $priority,
            ]);
        }
    }

    /**
     * 
     */
    public function removeTask($id)
    {

    }


    /**
     * Find parent of the current task
     * @param $parentId
     */
    protected function findParentTask($parentId)
    {
        $parent = Tasks::where("id", "=", $parentId)->first();
        return $parent->name;
    }

    /**
     * Find priority name and color in table Priorities
     * @param $priorityId
     * @return array $priority
     */
    protected function findPriority($priorityId)
    {
        $priority = Priorities::where("id_priority", "=", $priorityId)->first();
        return $priority;    
    }

    /**
     * find frequency name in table Frequency
     * @param $frequencyId
     */
    protected function findFrequency($frequencyId)
    {
        $fequency = Frequency::where("id_frequency", "=", $frequencyId)->first();
        return $frequency;    
    }

} //end class