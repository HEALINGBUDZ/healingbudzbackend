<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
//Model
use App\DefaultQuestion;

class BasicQaController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function getQa(){
        $basic_qa = DefaultQuestion::orderBy('updated_at', 'Desc')->get();
        return view('admin.basic_qa.basic_qa',['title' => 'Basic Q&A' , 'basic_qa' => $basic_qa]);
    }
    public function addQa(Request $request){
//        $this->validate($request , [
//            'question' => 'required',
//            'answer' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
//        ]);
        Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ])->validate();
        $basic_qa = new DefaultQuestion();
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/basic_qa/images';
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $basic_qa->image_path = $image;
        }
        $basic_qa->question = $request->input('question');
        $basic_qa->answer = $request->input('answer');

        $basic_qa->save();
        return redirect()->back()->with('success' , 'QA has been added');

    }
    public function deleteQa($id){
        DefaultQuestion::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'QA has been deleted');
    }
    public function updateQa(Request $request , $id){
//        $this->validate($request , [
//            'question' => 'required',
//            'answer' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
//        ]);
        Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ])->validate();
        $basic_qa = DefaultQuestion::where('id',$id)->first();
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/basic_qa/images';
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $basic_qa->image_path = $image;
        }
        $basic_qa->question = $request->input('question');
        $basic_qa->answer = $request->input('answer');
        $basic_qa->update();
        return redirect()->back()->with('success' , 'QA has been updated');

    }
    public function deleteImage(Request $request){
        $id = $request->input('id');
        $table = $request->input('table');
        $col = $request->input('col_name');
        DB::table($table)->where('id' , $id)->update([$col => '']);
        return Response::json(array('success' => 1));
    }

}