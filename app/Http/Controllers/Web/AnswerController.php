<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
//Models
use App\Answer;
use App\AnswerAttachment;
use App\Question;
use App\Http\Controllers\Controller;
use \App\AnswerLike;
use App\FlagedAnswer;
use App\Jobs\SendNotification;
use Carbon\Carbon;
use App\AnswerEdit;
class AnswerController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function showAnswer($id) {
        $data['id'] = $id;
        $data['title'] = 'Give Answer';
        $data['question'] = Question::with('getUser', 'getAnswers')
                        ->withCount(['getUserLikes' => function($query) {
                                $query->where('user_id', $this->userId);
                            }])
                        ->withCount(['isFlaged' => function($query) {
                                $query->where('user_id', $this->userId);
                                $query->where('is_flag', 1);
                            }])->with(['getAnswers' => function($query) {
                         $query->whereDoesntHave('FlagByUser', function ($answer) {
                            });
                    }])
                        ->withCount('getAnswers')->where('id', $id)->first();
        return view('user.give-answer', $data);
    }

    function editAnswer($id) {
        $data['id'] = $id;
        $data['title'] = 'Edit Answer';
        $answer = Answer::where('id', $id)->with('getImageAttachments', 'getVideoAttachments')->first();
        $data['answer'] = $answer;
        $data['question'] = Question::where(['id' => $answer->question_id])->with('getUser')
                ->withCount(['getUserLikes' => function($query) {
                        $query->where('user_id', $this->userId);
                    }])
                ->withCount(['isFlaged' => function($query) {
                        $query->where('user_id', $this->userId);
                        $query->where('is_flag', 1);
                    }])
                ->first();
        return view('user.edit-answer', $data);
        return Response::json(array('status' => 'success', 'successData' => $data));
    }

    function addAnswer(Request $request) {
        set_time_limit(0);
        Validator::make($request->all(), [
            'description' => 'required',
        ])->validate();
        $add_answer = new Answer;
        $answer_desc = makeUrls(getTaged(nl2br($request['description']), '0081ca'));
        if (isset($request['answer_id'])) {
            $add_answer = Answer::find($request['answer_id']);
            if($add_answer->answer != $answer_desc){
                $add_edit= new AnswerEdit;
                $add_edit->answer_id=$request['answer_id'];
                $add_edit->answer=$answer_desc;
                $add_edit->save();
            }
        }
        $add_answer->question_id = $request['question_id'];
        
        $add_answer->answer = $answer_desc;
        $add_answer->user_id = $this->userId;
        $add_answer->save();
        $question = Question::find($add_answer->question_id);

        $attachments = json_decode($request['attachments']);
        if ($attachments) {
            if (count($attachments) > 0) {
                AnswerAttachment::where(['answer_id' => $add_answer->id])->delete();
                foreach ($attachments as $attachment) {
                    $add_answer_attachment = new AnswerAttachment;
                    $add_answer_attachment->user_id = $this->userId;
                    $add_answer_attachment->answer_id = $add_answer->id;
                    $add_answer_attachment->upload_path = $attachment->path;
                    $add_answer_attachment->poster = $attachment->poster;
                    $add_answer_attachment->media_type = $attachment->type;
                    $add_answer_attachment->save();
                    if (!$request['answer_id']) {
                        if($attachment->type == 'image'){
                            addHbMedia($add_answer_attachment->upload_path);                            
                        } else if($attachment->type == 'video'){
                            addHbMedia($add_answer_attachment->upload_path, 'video', $add_answer_attachment->poster);
                        }
                    }
                }
            }
        }
        if (($request['answer_id'])) {
            
            $message = 'Answer updated sucsessfully';
            $notification_message='Answer Edited For Question ';
        } else {
            $message = 'Answer added sucsessfully';
            $notification_message='New Answer For Question ';
        }

            //Notification Code
            $message = 'Your question was answered by ' . $this->userName;
//            if ($question->user_id != $this->userId) {
            $heading = 'Question Answered';
            $my_save = \App\MySave::select('user_id')->where('model', 'Question')->where('type_sub_id',$question->id)->where('type_id', 4)->get()->toArray();
            $current_user_id[]['user_id'] = $question->user_id;
            $userFollowing = array_merge($my_save, $current_user_id);
            $user_count = \App\User::select('id as user_id')->whereIn('id', $userFollowing)->get()->toArray();
            if ($question->user_id != $this->userId) {
             $user_count = \App\User::select('id as user_id')->where('id','!=', $this->userId)->whereIn('id', $userFollowing)->get()->toArray();  
            }
            
            
            $data['activityToBeOpened'] = "Questions";
            $data['question_id'] = (int) $request['question_id'];
            $data['answer'] = substr($request['description'], 0, 100);
            $data['type_id'] = (int) $request['question_id'];
            $url = asset('get-question-answers/' . $request['question_id']);
        if(count($user_count) > 0){
            SendNotification::dispatch($heading, $notification_message, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
//                sendNotification($heading, $message, $data, $question->user_id, $url);
            }
            if (!$request['answer_id']) {
            $description = $question->question;
            $unique_description = $question->question . '<span style="display:none">' . $question->id . '_' . $add_answer->id . '</span>';
            addActivity($question->user_id, 'You answered a question', $message, $description, 'Answers', 'Question', $request['question_id'], $add_answer->id, $unique_description);
            
        }

        Session::flash('success', $message);
        if (isset($request['answer_id'])) {
            return Redirect::to('get-question-answers/' . $request['question_id']);
        }
        return Redirect::to('get-question-answers/' . $request['question_id']);
    }

    function addVideo($video_file) {
        if ($video_file) {
            $video_extension = $video_file->getClientOriginalExtension(); // getting image extension
            $video_extension = strtolower($video_extension);
            if ($video_file->isValid()) {
                $allowedextentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
                    "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
                    "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
                    "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
                    "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
                    "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
                    "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
                    "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
                    "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
                    "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
                    "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
                    "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
                    "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
                    "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
                    "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
                    "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
                    "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"];
                if (in_array($video_extension, $allowedextentions)) {
                    $video_destinationPath = base_path('public/videos/answer_videos'); // upload path
                    $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                    $fileDestination = $video_destinationPath . '/' . $video_fileName;
                    $filePath = $video_file->getRealPath();
                    exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);
                    if ($status === 0) {
                        $info = getVideoInformation($result);
                        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
                        $poster = 'public/images/answers/posters/' . $poster_name;
                        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
                    } else {
                        $poster_name = '';
                    }
                    $data['duration'] = $info[0];
                    $data['file_path'] = asset('public/videos/answer_videos/' . $video_fileName);
                    $data['poster'] = asset('public/images/answers/posters/' . $poster_name);
                    $data['type'] = 'video';
                    $data['path'] = '/answer_videos/' . $video_fileName;
                    $data['delete_path'] = 'public/videos/answer_videos/' . $video_fileName;
                    $data['poster_path'] = '/answers/posters/' . $poster_name;

                    return $data;
                }
            }
        }
    }

    function addImage($file) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/answers'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'answer_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['file_path'] = asset(image_fix_orientation('public/images/answers/' . $fileName));
                    $data['poster'] = '';
                    $data['type'] = 'image';
                    $data['path'] = '/answers/' . $fileName;
                    $data['delete_path'] = 'public/images/answers/' . $fileName;
                    $data['poster_path'] = '';
                    return $data;
                }
            }
        }
    }

    function likeAnswer() {
        $check_answer = AnswerLike::where(array('answer_id' => $_GET['answer_id'], 'user_id' => $this->userId))->first();
        if (!$check_answer) {
            $answer = Answer::find($_GET['answer_id']);
            $add_anser_like = new AnswerLike;
            $add_anser_like->user_id = $this->userId;
            $add_anser_like->answer_id = $_GET['answer_id'];
            $add_anser_like->save();
//            Points
            $count = AnswerLike::where(array('answer_id' => $_GET['answer_id']))->count();
            addCheckUserPoint($count, 'answer', $_GET['answer_id'], "Answer Like", $answer->user_id);
            //Notification Code]
            $message = $this->userName . ' liked your answer.';
            if ($answer->user_id != $this->userId) {
                $heading = 'Answer Liked';

                $data['activityToBeOpened'] = "Questions";
                $data['question_id'] = (int) $answer->question_id;
                $data['answer'] = $answer->answer;
                $data['type_id'] = (int) $answer->question_id;
                $url = asset('get-question-answers/' . $answer->question_id);
                sendNotification($heading, $message, $data, $answer->user_id, $url);
            }
            //Add Activity
            $description = $answer->answer;
            $unique_description = $answer->answer . '<span style="display:none">' . $answer->question_id . '_' . $answer->id . '</span>';
            addActivity($answer->user_id, 'You Liked Answer', $message, $description, 'Likes', 'Question', $answer->question_id, $add_anser_like->answer_id, $unique_description);
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    function removeLikeAnswer() {
        $answer = Answer::find($_GET['answer_id']);
        $user_id = $this->userId;
        AnswerLike::where(array('answer_id' => $_GET['answer_id'], 'user_id' => $user_id))->delete();
        removeUserActivity($user_id, 'Likes', 'Question', $answer->question_id);
        echo True;
    }

    function addAnswerFlag(Request $request) {
        $check_flag = FlagedAnswer::where(array('user_id' => $this->userId, 'answer_id' => $request['id']))->first();
        if (!$check_flag) {
            $get_answer = Answer::find($request['id']);
            $add_flag = new FlagedAnswer;
            $add_flag->user_id = $this->userId;
            $add_flag->answer_id = $request['id'];
            $add_flag->flaged_user_id = $get_answer->user_id;
            $add_flag->reason = $request['group1'];
            $add_flag->save();
        }
        Session::flash('success', 'Flag Added Successfully');
        return Redirect::to(URL::previous());
    }

    function deleteUserAnswer($user_answer_id) {
//        $question = Answer::select('question_id')->where(['id' => $user_answer_id])->first();
//        $type_id = $question->question_id;
        Answer::where(['id' => $user_answer_id])->delete();

        //Delete Entry from User Activity Log
        removeAnswerActivity($user_answer_id);
         Session::flash('success', 'Answer deleted successfully');
        return Redirect::to(URL::previous());
    }

    function addAnswerAttachment(Request $request) {
        $file = $request['file'];
        $check = $this->addImage($file);
        if (!$check) {
            $check = $this->addVideo($file);
        }if ($check) {
            return json_encode($check);
        }
    }

    function removeAttachment(Request $request) {
        $attachment = explode('/', $request['file_path']);
        AnswerAttachment::where('upload_path', 'like', '%' . $attachment[2] . '/' . $attachment[3] . '%')->delete();

        $file = $request['file_path'];
        if (!unlink(base_path($file))) {
            return Response::json(array('status' => 'success', 'file' => base_path($file)));
        } else {
            return Response::json(array('status' => 'error', 'file' => base_path($file)));
        }
    }

}
