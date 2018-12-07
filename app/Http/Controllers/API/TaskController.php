<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Task; 
use Validator;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller 
    {
        public $successStatus = 200;

        public function index($id) 
        { 
            $tasks = DB::table('tasks')
                     ->select('*')
                     ->where('project_id', '=', $id)
                     ->where('isParent', 0) 
                     ->get();
            $results = [];
            foreach($tasks as $task){
                $code = DB::table('codes')
                ->select('*')
                ->where('task_id', '=', $task->id)
                ->get();
            $mytask = (object) array('task' => $task ,'code' => $code);
            $results[] = $mytask;
            }
            return response()->json(['success'=>$results], $this-> successStatus); 
        }

        /** 
         * save api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function save(Request $request) 
        { 
            $validator = Validator::make($request->all(), [ 
                'title' => 'required', 
                'discription' => 'required',
                'isParent' => 'required',
                'user_id' => 'required',
                'status' => 'required',
                'project_id' => 'required',
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $task = Task::create($input); 
            return response()->json(['success'=>$task], $this-> successStatus); 
        }

        public function update(Request $request,$id) 
        { 
            $validator = Validator::make($request->all(), [ 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all();
            $task = Task::find($id);
            $taskUpdated = $task->update($input); 
            return response()->json(['success'=>$task], $this-> successStatus); 
        }
}