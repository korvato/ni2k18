<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Project; 
use Validator;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller 
    {
        public $successStatus = 200;

        public function index() 
        { 
            $progects = DB::table('projects')
            ->select('*')
            ->get();
            $resultat = [];
            foreach($progects as $progect){
                $tasks = DB::table('tasks')
                        ->select('*')
                        ->where('project_id', '=', $progect->id)
                        ->where('isParent', 0) 
                        ->get();
                $mytasks = [];
                foreach($tasks as $task){
                    $code = DB::table('codes')
                    ->select('*')
                    ->where('task_id', '=', $task->id)
                    ->get();
                $mytask = (object) array('task' => $task ,'code' => $code);
                $mytasks[] = $mytask;
                $myproject = (object) array('project' => $progect ,'tasks' => $mytasks);
                }
                $resultat[] = $myproject;
            }
            return response()->json(['success'=>$resultat], $this-> successStatus); 
        }

        public function projectsTasks($id) 
        { 
            $tasks = DB::table('tasks')
                     ->select('*')
                     ->where('project_id', '=', $id)
                     ->where('isParent', 1) 
                     ->get();
            return response()->json(['success'=>$tasks], $this-> successStatus); 
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
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $project = Project::create($input); 
            return response()->json(['success'=>$project], $this-> successStatus); 
        }

        public function update(Request $request,$id) 
        { 
            $validator = Validator::make($request->all(), [ 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all();
            $project = Project::find($id);
            $projectUpdated = $project->update($input); 
            return response()->json(['success'=>$project], $this-> successStatus); 
        }
}