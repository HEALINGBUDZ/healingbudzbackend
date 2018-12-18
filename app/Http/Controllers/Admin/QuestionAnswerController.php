<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
//Model
use App\Answer;
use App\MySave;
use App\Question;
use App\UserActivity;

class QuestionAnswerController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function questions() {
        $data['title'] = 'User Questions';
        $data['questions'] = Question::with('getUser', 'getAnswers')->orderBy('updated_at', 'Desc')->get();
        $data['answered_questions'] = Question::whereHas('getAnswers')->count();
        return view('admin.user_questions.user_questions', $data);
    }

    public function deleteQuestion(Request $request) {
        $id=$request->id;
        $message=$request->message;
        $question = Question::find($id);
        deleteNotificationFromAdmin($question->user_id, $message, 'Admin delete your question '.$question->question);
        Question::where('id', $id)->delete();
        MySave::where('type_sub_id', $id)->where('model', 'Question')->delete();
        UserActivity::where('type_id', $id)->where('model', 'Question')->delete();
        return redirect()->back()->with('success', 'Question has been deleted');
    }

    public function deleteMultipleQuestions(Request $request) {
        $ids = explode(',', $request['ids']);
        MySave::whereIn('type_sub_id', $ids)->where('model', 'Question')->delete();
        UserActivity::whereIn('type_id', $ids)->where('model', 'Question')->delete();
        $questions =Question::whereIn('id', $ids)->get();
        foreach ($questions as $question){
         deleteNotificationFromAdmin($question->user_id, 'Admin delete your question '.$question->question, 'Admin delete question '.$question->question);   
        }
        Question::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Questions deleted successfully"]);
    }

    public function deleteMultipleAnswers(Request $request) {
        $ids = explode(',', $request['ids']);
        $answewrs = Answer::whereIn('id', $ids)->get();
        foreach ($answewrs as $answewr) {
            deleteNotificationFromAdmin($answewr->user_id, 'Admin delete your answer '.$answewr->answer, 'Admin delete your answer '.$answewr->answer);
            removeAnswerActivity($answewr->id);
            $answewr->delete();
        }
        return response()->json(['success' => "Answers deleted successfully"]);
    }

    public function updateQuestion(Request $request) {
//        $this->validate($request , [
//            'question' => 'required',
//        ]);
        Validator::make($request->all(), [
            'question' => 'required',
        ])->validate();
        Question::where('id', $request->input('question_id'))->update(['question' => $request->input('question')]);
        return redirect()->back()->with('success', 'Question has been updated');
    }

    public function userAnswers($id) {
        $answers = Answer::where('question_id', $id)->get();
        return view('admin.user_questions.user_answers', ['title' => 'questions', 'answers' => $answers]);
    }

    public function deleteAnswer(Request $request) {
        $answer_id=$request->id;
        $message=$request->message;
        $answer=Answer::find($answer_id);
        deleteNotificationFromAdmin($answer->user_id, $message, 'Admin delete your answer '.$answer->answer);
        Answer::where('id', $answer_id)->delete();
        removeAnswerActivity($answer_id);
        return redirect()->back()->with('success', 'Answer has been deleted');
    }

    public function updateAnswer(Request $request) {
//        $this->validate($request , [
//            'answer' => 'required',
//        ]);
        Validator::make($request->all(), [
            'answer' => 'required',
        ])->validate();
        Answer::where('id', $request['answer_id'])->update(['answer' => $request->input('answer')]);
        return redirect()->back()->with('success', 'Answer has been updated');
    }

    function getQuestionDetail($question_id) {
        $data['title'] = 'User Questions';
        $data['question'] = Question::where('id', $question_id)->with('getUser', 'getAnswers', 'getAnswers.getUser', 'getAnswers.getAttachments')->first();
        return view('admin.user_questions.question_detail', $data);
        return Response::json(array('data' => $data));
    }

    function userAnswerDetail($answer_id) {
        $data['title'] = 'User Questions';
        $data['answer'] = Answer::where('id', $answer_id)->with('getUser', 'getAttachments', 'getQuestion', 'getQuestion.getUser')->first();
        return view('admin.user_questions.answer_detail', $data);
        return Response::json(array('data' => $data));
    }

}
