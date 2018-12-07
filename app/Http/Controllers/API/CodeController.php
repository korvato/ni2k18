<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Code; 
use Validator;

class CodeController extends Controller 
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
                'code' => 'required',
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $code = Code::create($input); 
            return response()->json(['success'=>$code], $this-> successStatus); 
        }

        public function update(Request $request,$id) 
        { 
            $validator = Validator::make($request->all(), [ 
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all();
            $code = Code::find($id);
            $codeUpdated = $code->update($input); 
            return response()->json(['success'=>$code], $this-> successStatus); 
        }
}