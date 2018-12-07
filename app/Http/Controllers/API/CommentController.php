<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Comment; 
use Validator;

class CommentController extends Controller 
    {
        public $successStatus = 200;
        /** 
         * save api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
        public function save(Request $request) 
        { 
            $validator = Validator::make($request->all(), [ 
                'task_id' => 'required', 
                'comment' => 'required', 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $comment = Comment::create($input); 
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }

        public function update(Request $request,$id) 
        { 
            $validator = Validator::make($request->all(), [ 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all();
            $comment = Comment::find($id);
            $commentUpdated = $comment->update($input); 
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }
}