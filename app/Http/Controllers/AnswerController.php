<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
//Models
use App\Answer;
use App\AnswerAttachment;
use App\AnswerLike;
use App\FlagedAnswer;
use App\Question;
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

    function getAnswers($id) {
        $user_id = $this->userId;
        $answers = Answer::where('question_id', $id)->with('getUser', 'getAttachments', 'Attachments')
                        ->withCount('AnswerLike', 'AnswerUserLike', 'FlagByUser','getEdit')
                        ->withCount(['is_following' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                            ->whereDoesntHave('FlagByUser', function ($answer) {
                            })
                        ->orderBy('created_at', 'desc')->get();
        return sendSuccess('answers', $answers);
    }

    function getAnswer($id) {
        $user_id = $this->userId;
        $answers = Answer::where('id', $id)->with('getUser', 'getAttachments', 'Attachments')
                        ->withCount('AnswerLike', 'AnswerUserLike', 'FlagByUser','getEdit')->withCount(['is_following' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->orderBy('created_at', 'desc')->get();
        return sendSuccess('answers', $answers);
    }

    function addAnswer(Request $request) {
        $validation = $this->validate($request, [
            'answer' => 'required',
            'question_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_answer = new Answer;
        $answer_desc = makeUrls(getTaged($request['answer'], '0081ca'));
        if ($request['answer_id']) {
            $add_answer = Answer::find($request['answer_id']);
            if ($add_answer->answer != $answer_desc) {
                $add_edit = new AnswerEdit;
                $add_edit->answer_id = $request['answer_id'];
                $add_edit->answer = $answer_desc;
                $add_edit->save();
            }
            AnswerAttachment::where('answer_id', $request['answer_id'])->delete();
        }
        $add_answer->question_id = $request['question_id'];

        $add_answer->answer = $answer_desc;
        $add_answer->user_id = $this->userId;
        $add_answer->save();
        $question = Question::find($add_answer->question_id);
        if ($request['file']) {
            foreach ($request['file'] as $file) {
                if ($file) {
                    $add_answer_attachment = new AnswerAttachment;
                    $add_answer_attachment->user_id = $this->userId;
                    $add_answer_attachment->answer_id = $add_answer->id;
                    $add_answer_attachment->upload_path = $file['path'];
                    $add_answer_attachment->poster = $file['poster'];
                    $add_answer_attachment->media_type = $file['media_type'];
                    $add_answer_attachment->save();
                    if (!$request['answer_id']) {
                        if ($add_answer_attachment->media_type == 'image') {
                            addHbMedia($add_answer_attachment->upload_path);
                        } else if ($add_answer_attachment->media_type == 'video') {
                            addHbMedia($add_answer_attachment->upload_path, 'video', $add_answer_attachment->poster);
                        }
                    }
                }
            }
        }

        //Notification Code
        $message = 'Your question was answered by ' . $this->userName;
//            if ($question->user_id != $this->userId) {
        $my_save = \App\MySave::select('user_id')->where('model', 'Question')->where('type_id', 4)->where('type_sub_id', $question->id)->get()->toArray();
        $current_user_id[]['user_id'] = $question->user_id;
        $userFollowing = array_merge($my_save, $current_user_id);
        $user_count = \App\User::select('id as user_id')->whereIn('id', $userFollowing)->get()->toArray();
        if ($question->user_id != $this->userId) {
            $user_count = \App\User::select('id as user_id')->where('id', '!=', $this->userId)->whereIn('id', $userFollowing)->get()->toArray();
        }
        $heading = 'Question Answered';
        $notification_message = 'New Answer For Question ';
        if ($request['answer_id']) {
            $heading = 'Question Answered';
            $notification_message = 'Answer Edited For Question ';
        }
        $data['activityToBeOpened'] = "Questions";
        $data['question_id'] = (int) $request['question_id'];
        $data['type_id'] = (int) $request['question_id'];
        //            $data['answer'] = $request['answer'];
        $url = asset('get-question-answers/' . $request['question_id']);
        if (count($user_count) > 0) {
            SendNotification::dispatch($heading, $notification_message, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
//                sendNotification($heading, $message, $data, $question->user_id, $url);
        }
        if (!$request['answer_id']) {
            $question->question = $question->question;
            $unique_description = $question->question . ' <span style="display:none">' . $question->id . '_' . $add_answer->id . '</span>';
            addActivity($question->user_id, 'You answered a question', $message, $question->question, 'Answers', 'Question', $request['question_id'], $add_answer->id, $unique_description);
        }
        return sendSuccess('Answer Added Successfully', $add_answer);
    }

    function addLike(Request $request) {
        $validation = $this->validate($request, [
            'answer_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        $answer = Answer::find($request['answer_id']);
        if ($request['is_like'] == 1) {
            $check_like = AnswerLike::where(array('user_id' => $user_id, 'answer_id' => $request['answer_id']))->first();
            if ($check_like) {
                return sendError('Like Already Added', 412);
            }


            $add_answer = new AnswerLike;
            $add_answer->user_id = $user_id;
            $add_answer->answer_id = $request['answer_id'];
            $add_answer->save();
//            Save Point
            $count = AnswerLike::where(array('answer_id' => $request['answer_id']))->count();
            addCheckUserPoint($count, 'answer', $request['answer_id'], "Answer Like", $answer->user_id);
            //Notification Code
            $message = $this->userName . ' liked your answer.';
            if ($answer->user_id != $this->userId) {
                $heading = 'Answer Liked';
//                $message = $this->userName . ' liked your answer.';
                $data['activityToBeOpened'] = "Questions";
                $data['question_id'] = (int) $answer->question_id;
                $data['type_id'] = (int) $answer->question_id;
                $data['answer'] = $answer->answer;
                $url = asset('get-question-answers/' . $answer->question_id);
                sendNotification($heading, $message, $data, $answer->user_id, $url);
            }
            //Add Activity
            $add_answer->answer = $add_answer->answer;
            $unique_description = $add_answer->answer . ' <span style="display:none">' . $add_answer->answer_id . '_' . $add_answer->id . '</span>';
            addActivity($answer->user_id, 'You Liked Answer', $message, $answer->answer, 'Likes', 'Question', $answer->question_id, $add_answer->answer_id, $unique_description);
            return sendSuccess('Like Added SuccessFully', $add_answer);
        } else {
            AnswerLike::where(array('user_id' => $user_id, 'answer_id' => $request['answer_id']))->delete();
            removeUserActivity($user_id, 'Likes', 'Question', $answer->question_id);
            return sendSuccess('Like Deleted SuccessFully', '');
        }
    }

    function addFlag(Request $request) {
        $validation = $this->validate($request, [
            'answer_id' => 'required',
            'reason' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $check_flag = FlagedAnswer::where(array('user_id' => $user_id, 'answer_id' => $request['answer_id']))->first();
        if ($check_flag) {
            return sendError('Flag Already Added', 413);
        }
        $answer = Answer::find($request['answer_id']);
        $add_flag = new FlagedAnswer;
        $add_flag->user_id = $user_id;
        $add_flag->answer_id = $request['answer_id'];
        $add_flag->reason = $request['reason'];
        $add_flag->flaged_user_id = $answer->user_id;
        $add_flag->save();
        return sendSuccess('Flag Successfully added', $add_flag);
    }

    function addVideo(Request $request) {
        set_time_limit(0);
        $video_file = $request['video'];
        if ($video_file) {
            $video_extension = Input::file('video')->getClientOriginalExtension(); // getting image extension
            $video_extension = strtolower($video_extension);
            if ($video_file->isValid()) {
                $allowedextentions = ["mov", "ogv", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
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
                        return sendError('Sorry Some Thing wnet wrong', 419);
                    }
                    $data['path'] = '/answer_videos/' . $video_fileName;
                    $data['poster'] = '/answers/posters/' . $poster_name;
                    return sendSuccess('Video Uploaded', $data);
                }
            }
            return sendError('Please Provide Valid File', 414);
        } else {
            return sendError('Please Provide A File', 415);
        }
    }

    function addImage(Request $request) {
        $file = $request['image'];
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                    $destination_path = 'public/images/answers'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $fileName = 'answer_' . Str::random(15) . '.' . $extension; // renameing image
                    $file->move($destination_path, $fileName);
                    $data['path'] = '/answers/' . $fileName;
                    $data['poster'] = '';
                    return sendSuccess('Image Uploaded', $data);
                } else {
                    return sendError('Please Provide Valid File', 414);
                }
            } else {
                return sendError('Please Provide Valid File', 414);
            }
        } else {
            return sendError('Please Provide A File', 415);
        }
    }

    function deleteUserAnswer($answer_id) {
//        $question = Answer::select('question_id')->where(['id' => $answer_id])->first();
//        $type_id = $question->question_id;
        Answer::where(['id' => $answer_id])->delete();
        //Delete Entry from User Activity Log
        removeAnswerActivity($answer_id);
        return sendSuccess('Answer deleted successfully', '');
    }

    function getAnswerQuestion($id) {
        $answer = Answer::find($id);
        $user_id = $this->userId;
        $question = Question::with('getUser')
                        ->where('id', $answer->question_id)
                        ->withCount(['getUserLikes' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                        ->withCount(['getUserFlag' => function($query)use ($user_id) {
                                $query->where('user_id', $user_id);
                                $query->where('is_flag', 1);
                            }])
                        ->withCount('getAnswers')->orderBy('created_at', 'desc')->get();

        return sendSuccess('', $question);
    }

    function getAnswerEdits($ansewr_id) {
        return sendSuccess('', AnswerEdit::where('answer_id', $ansewr_id)->orderBy('id', 'desc')->get());
    }

}
