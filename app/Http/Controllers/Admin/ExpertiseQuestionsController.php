<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Models
use App\ExpertiseQuestion;
use App\Experty;
use App\UserExperty;

class ExpertiseQuestionsController extends Controller
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
    public function getExpertiseQuestions(){
        $questions = ExpertiseQuestion::orderBy('updated_at','desc')->get();
        return view('admin.expertise_questions.expertise_questions_view',['title' => 'Questions' , 'questions' => $questions]);
    }
    public function deleteExpertiseQuestion($id){
        ExpertiseQuestion::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Question has been deleted');
    }
    public function updateExpertiseQuestion(Request $request , $id){
        $this->validate($request , [
            'expertise_question' => 'required',
        ]);
        ExpertiseQuestion::where('id',$id)->update(['question' => $request->input('expertise_question')]);
        return redirect()->back()->with('success' , 'Question has been updated');
    }
    public function getExpertiseAnswers($id){
        $data['title'] = 'answers';
        $data['answers'] = Experty::where('exp_question_id' , $id)->orderBy('updated_at', 'Desc')->get();
        $data['exp_question_id'] = $id;
        return view('admin.expertise_questions.expertise_answers_view',$data);
    }

    public function updateExpertiseAnswer(Request $request , $id){
        $this->validate($request , [
            'expertise_answer' => 'required',
        ]);
        Experty::where('id',$id)->update(['title' => $request->input('expertise_answer')]);
        return redirect()->back()->with('success' , 'Answer has been updated');
    }
    public function addExpertiseAnswer(Request $request){
        $this->validate($request , [
            'expertise_answer' => 'required'
        ]);
        $expertise_answer = new Experty();
        $expertise_answer->title = $request->input('expertise_answer');
        $expertise_answer->exp_question_id = $request->input('exp_question_id');
        $expertise_answer->is_approved	= 1 ;
        $expertise_answer->save();
        return redirect()->back()->with('success' , 'Answer has been added');

    }
    public function deleteExpertiseAnswer($id){
        Experty::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Answer has been deleted');
    }


    public function expAnswerApproveStatus($status  ,$id){
        if($status == 1){
            Experty::where('id',$id)->update(['is_approved' => 1]);
            UserExperty::where('exp_id',$id)->update(['is_approved' => 1]);
            return redirect()->back()->with('success' , 'Experty has been approved');
        }else {
            Experty::where('id', $id)->update(['is_approved' => 0]);
             UserExperty::where('exp_id',$id)->update(['is_approved' => 0]);
            return redirect()->back()->with('success' , 'Experty has been rejected');
        }
    }
    
}