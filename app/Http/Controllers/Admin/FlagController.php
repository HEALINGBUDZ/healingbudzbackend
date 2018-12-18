<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//Models
use App\QuestionLike;
use App\FlagedAnswer;
use App\SubUserFlag;
use App\SubUser;
use App\BusinessReview;
use App\BusinessReviewReport;
use Illuminate\Support\Facades\DB;
use App\MySave;
class FlagController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function getFlaggedAnswers() {
        $data['title'] = 'Flagged Answers';
        FlagedAnswer::where('is_read', 0)->update(['is_read' => 1]);
        $data['answers'] = FlagedAnswer::with('getAnswer', 'getAnswer.getQuestion', 'flagByUserAnswer', 'flagToUserAnswer')->get();
        return view('admin.flagged_answers.flagged_answers_view', $data);
//        return Response::json(array('data' => $data));
    }

    public function deleteFlaggedAnswer($id) {
        $flag = FlagedAnswer::where('id', $id)->first();
        FlagedAnswer::where('id', $id)->delete();
        $anser = \App\Answer::find($flag->answer_id);
        $question = \App\Question::find($anser->question_id);
        $data['activityToBeOpened'] = "Questions";
        $data['question'] = $question;
        $data['type_id'] = (int) $question->id;
        $data['question_id'] = (int) $question->id;
        addAdminActivity($flag->user_id, 'Flag has been removed by admin', 'Flag has been removed by admin', 'Questions', 'Question', $question->id);
        sendNotification('Answer', 'Flag has been removed by admin', $data, $flag->user_id, asset('get-question-answers/' . $question->id));
        return redirect()->back()->with('success', 'Flag has been deleted from answer');
    }

    public function getFlaggedQuestions() {
        $data['title'] = 'Flagged Questions';
        QuestionLike::where('is_read', 0)->update(['is_read' => 1]);
        $data['questions'] = QuestionLike::with('flagByUserQuestion', 'question.user')->where('is_flag', 1)->get();
        return view('admin.flagged_answers.flagged_questions_view', $data);
    }

    public function deleteFlaggedQuestion($id) {
        $flag = QuestionLike::where('id', $id)->first();
        QuestionLike::where('id', $id)->delete();
        $data['activityToBeOpened'] = "Questions";
        $data['question'] = \App\Question::find($flag->question_id);
        $data['type_id'] = (int) $flag->question_id;
        $data['question_id'] = (int) $flag->question_id;
        sendNotification('Question', 'Flag has been removed by admin', $data, $flag->user_id, asset('get-question-answers/' . $flag->question_id));
        //Answer::where('id' , $flagged_answer->answer_id)->delete();
        return redirect()->back()->with('success', 'Flag has been deleted from question');
    }

    function deleteFlagMultipleQuestions(Request $request) {
        $ids = explode(',', $request['ids']);
        $questions = QuestionLike::whereIn('id', $ids)->get();
        QuestionLike::whereIn('id', $ids)->delete();
        foreach ($questions as $flag) {
            $data['activityToBeOpened'] = "Questions";
            $data['question'] = \App\Question::find($flag->question_id);
            $data['type_id'] = (int) $flag->question_id;
            $data['question_id'] = (int) $flag->question_id;
            sendNotification('Question', 'Flag has been removed by admin', $data, $flag->user_id, asset('get-question-answers/' . $flag->question_id));
        }
        return response()->json(['success' => "Questions flag deleted successfully"]);
    }

    function deleteFlagMultipleAnswers(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = FlagedAnswer::whereIn('id', $ids)->get();
        foreach ($flags as $flag) {
            $anser = \App\Answer::find($flag->answer_id);
            $question = \App\Question::find($anser->question_id);
            $data['activityToBeOpened'] = "Questions";
            $data['question'] = $question;
            $data['type_id'] = (int) $question->id;
            $data['question_id'] = (int) $question->id;
            sendNotification('Answer', 'Flag has been removed by admin', $data, $flag->user_id, asset('get-question-answers/' . $question->id));
        }
        FlagedAnswer::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Answers flag deleted successfully"]);
    }

    public function flaggedBusiness() {
        $data['title'] = 'Flagged Business';
        SubUserFlag::where('is_read', 0)->update(['is_read' => 1]);
        $data['flagged_business'] = SubUserFlag::with('SubUser', 'User')->orderBy('updated_at', 'desc')->get();
        return view('admin.users.flagged_business_view', $data);
    }

    public function flaggedBusinessReviews() {
        $data['title'] = 'Flagged Business Reviews';
        \App\BusinessReviewReport::where('is_read', 0)->update(['is_read' => 1]);
        $data['flagged_business'] = \App\BusinessReviewReport::orderBy('updated_at', 'desc')->get();
        return view('admin.users.flagged_business_reviews_view', $data);
    }

    public function deleteMultipleBusinessReviewFlags(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = BusinessReviewReport::whereIn('id', $ids)->get();
        BusinessReviewReport::whereIn('id', $ids)->delete();
        foreach ($flags as $flag) {
            $sub_user_flag = BusinessReview::find($flag->business_review_id);
            $sub_user = SubUser::find($sub_user_flag->sub_user_id);
            $budz_id = $sub_user->id;
            $data['activityToBeOpened'] = "Budz";
            $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
            $data['type_id'] = (int) $sub_user->id;
            $data['budz_id'] = (int) $sub_user->id;
            sendNotification('Budz Adz', 'Flag has been removed by admin', $data, $flag->reported_by, $url);
        }
        return response()->json(['success' => "Business review flags deleted successfully"]);
    }

    public function deleteBusinessReviewFlag($id) {
        $flag = BusinessReviewReport::where('id', $id)->first();
        BusinessReviewReport::where('id', $id)->delete();
        $sub_user_flag = BusinessReview::find($flag->business_review_id);
        $sub_user = SubUser::find($sub_user_flag->sub_user_id);
        $budz_id = $sub_user->id;
        $data['activityToBeOpened'] = "Budz";
        $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
        $data['type_id'] = (int) $sub_user->id;
        $data['budz_id'] = (int) $sub_user->id;
        sendNotification('Budz Adz', 'Flag has been removed by admin', $data, $flag->reported_by, $url);
        return redirect('flagged_business_reviews')->with('success', 'Business Review Flag has been deleted');
    }

    public function deleteBusinessReview(Request $request) {
        $id=$request->id;
        $message=$request->message;
        $review=BusinessReview::find($id);
        deleteNotificationFromAdmin($review->reviewed_by, $message, 'Admin delete your budz adz review '.$review->text);
        BusinessReview::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Business Review has been deleted');
    }

    public function deleteFlaggedProfile($id) {
        $sub_user_flag = SubUserFlag::where('id', $id)->first();
        SubUserFlag::where('id', $id)->delete();
        $sub_user = SubUser::find($sub_user_flag->budz_id);
        $budz_id = $sub_user->id;
        $data['activityToBeOpened'] = "Budz";
        $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
        $data['type_id'] = (int) $sub_user->id;
        $data['budz_id'] = (int) $sub_user->id;
        sendNotification('Budz Adz', 'Flag has been removed by admin', $data, $sub_user_flag->reported_by, $url);
        return redirect()->back()->with('success', 'Flag has been deleted from Profile');
    }

    public function deleteBussinessProfile(Request $request) {
        $id=$request->id;
        $message=$request->message;
        $subuser = SubUser::find($id);
        $user_name = '@' . $subuser->title;
        $user_name = addslashes($user_name);
        $sub_user_title = addslashes($subuser->title);
        deleteNotificationFromAdmin($subuser->user_id, $message, 'Admin delete Business Profile '.$subuser->title);
        \App\UserPost::where('description', 'like', "%$user_name%")->update(['description' => DB::raw("REPLACE(description,'$user_name', '$sub_user_title')")]);
        MySave::where('type_sub_id', $id)->where('model', 'SubUser')->delete();
        //Delete Entry from User Activity Log
        $type = 'Budz';
        $type_id = $id;
        removeUserActivity($userId = 0, $type, 'SubUser', $type_id);

        //Delete Entry from Saves List
        $model = 'SubUser';
        $menu_item_id = 8;
        $type_sub_id = $id;
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        $subuser->delete();
        return redirect()->back()->with('success', 'Profile has been deleted');
    }

    function deleteMultipleSubusers(Request $request) {
        $ids = explode(',', $request['ids']);
        $users = SubUser::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            MySave::where('type_sub_id', $user->id)->where('model', 'SubUser')->delete();
            $user_name = '@' . $user->title;
            $user_name = addslashes($user_name);
            $first_name = addslashes($user->first_name);
            deleteNotificationFromAdmin($user->user_id, 'Admin delete Business Profile '.$user->title, 'Admin delete Business Profile '.$user->title);
            \App\UserPost::where('description', 'like', "%$user_name%")->update(['description' => DB::raw("REPLACE(description,'$user_name', '$first_name')")]);
            $user->delete();
        }

        return response()->json(['success' => "Bussiness Profiles deleted successfully."]);
    }

    public function deleteFlagMultipleSubusers(Request $request) {
        $ids = explode(',', $request['ids']);
        $flags = SubUserFlag::whereIn('id', $ids)->get();
        SubUserFlag::whereIn('id', $ids)->delete();
        foreach ($flags as $sub_user_flag) {
            $sub_user = SubUser::find($sub_user_flag->budz_id);
            $budz_id = $sub_user->id;
            $data['activityToBeOpened'] = "Budz";
            $url = asset("get-budz?business_id=$budz_id&business_type_id=" . $sub_user->business_type_id);
            $data['type_id'] = (int) $sub_user->id;
            $data['budz_id'] = (int) $sub_user->id;
            sendNotification('Budz Adz', 'Flag has been removed by admin', $data, $sub_user_flag->reported_by, $url);
        }
        return response()->json(['success' => "Bussiness Profiles flag deleted successfully."]);
    }

    function deleteFlagMultipleStrains(Request $request) {
        $ids = explode(',', $request['ids']);
        \App\StrainLike::whereIn('id', $ids)->update(['is_flaged' => 0]);
        return response()->json(['success' => "Strain flag deleted successfully."]);
    }

}
