<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//Models
use App\Tag;
use App\UserActivity;
use App\MySave;
use App\ShoutOutNotification;
use App\VGetMySave;
use App\LoginUsers;
use App\UsedTag;
use App\Journal;
use App\JournalEvent;
use App\JournalEventTag;
use App\GroupFollower;
use App\VTopSurveyAnswer;
use App\UserFollow;
use App\SubUser;
use App\ChatMessage;
use App\NotificationSetting;
use App\UserGroupSetting;
use App\UserPoint;
use App\User;
use App\MySaveSetting;
use App\Strain;
use App\ChatUser;
use App\UserTag;
use App\UserRewardStatus;
use App\UserShare;
use App\UserPointRecord;
use App\TagStatePrice;
use App\Icons;
use App\SubUserFlag;
use App\UserPostFlag;
use App\FlagedAnswer;
use App\QuestionLike;
use App\HbGalleryMedia;

include 'link_check.php';

function getFollowingTag($string) {
    $tags = Tag::where('is_approved', 1)->pluck('title')->toArray();
    $new_string_ = str_replace('<br />', ' __ ', $string);
    $string_array = explode(' ', $new_string_);
    $users = [];
    foreach ($string_array as $string) {
        $key = in_array(strtolower(trim($string)), array_map('strtolower', $tags));
        if ($key) {
            $tag = Tag::where('title', $string)->first();
            $user_tags = UserTag::select('user_id')->where('user_id', '!=', Auth::user()->id)->where('tag_id', $tag->id)->get()->toArray();
            if ($users) {
                $users = array_merge($users, $user_tags);
            } else {
                $users = $user_tags;
            }
        }
    }
    return $users;
}

function getTaged($string, $color) {

    $tags = Tag::where('is_approved', 1)->pluck('title')->toArray();
    $new_string_ = str_replace('<br />', ' __ ', $string);
    $new_string_ = str_replace('.', '. ', $string);
    $string_array = explode(' ', $new_string_);
    $new_string = '';
    foreach ($string_array as $string) {


        $key = in_array(strtolower(trim($string)), array_map('strtolower', $tags));
        if ($key) {
            $new_string = $new_string . " <b ><font class='keyword_class' color=#6d96ad>$string</font></b>";
        } else {
            $first_string = substr(trim($string), 0, 1);
            $last_charter = substr(trim($string), -1);
            if (substr(trim($string), 0, 1) === '#') {
                $updated_string = str_replace('#', '', $string);
                $key = in_array(strtolower(trim($updated_string)), array_map('strtolower', $tags));
                if ($key) {
                    $new_string = $new_string . " <b ><font class='keyword_class' color=#6d96ad>$string</font></b>";
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } elseif (preg_match('/[\'^£$%&*()}{@#~?.><>,|=_+¬-]/', $first_string) && preg_match('/[\'^£$%&*()}{@#~?.><>,|=_+¬-]/', $last_charter)) {
                $updated_string = str_replace($last_charter, '', $string);
                $updated_string = str_replace($first_string, '', $updated_string);
                $key = in_array(strtolower(trim($updated_string)), array_map('strtolower', $tags));
                if ($key) {
                    $new_string = $new_string . $first_string . " <b ><font class='keyword_class' color=#6d96ad>$updated_string</font></b>" . $last_charter;
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } elseif (preg_match('/[\'^£$%&*()}{@#~?.><>,|=_+¬-]/', $last_charter)) {
                $updated_string = str_replace($last_charter, '', $string);
                $key = in_array(strtolower(trim($updated_string)), array_map('strtolower', $tags));
                if ($key) {
                    $new_string = $new_string . " <b ><font class='keyword_class' color=#6d96ad>$updated_string</font></b>" . $last_charter;
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } elseif (preg_match('/[\'^£$%&*()}{@#~?.><>,|=_+¬-]/', $first_string)) {
                $updated_string = str_replace($first_string, '', $string);
                $key = in_array(strtolower(trim($updated_string)), array_map('strtolower', $tags));
                if ($key) {
                    $new_string = $new_string . $first_string . " <b ><font class='keyword_class' color=#6d96ad>$updated_string</font></b>";
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } else {
                $new_string = $new_string . ' ' . $string;
            }
        }
    }
    $new_string = str_replace('. ', '.', $new_string);
    return str_replace('__', '<br />', $new_string);
}

// $on_user (activity ownere)
// $text (text to be show)
// $notification_text (text to be display to owner of post)
// $description (it key value to be displayed)
// $type model
// $relation model
// $type_id sub type id
function addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id = '', $unique_description = '') {
    $add_activity = new UserActivity;
    $add_activity->user_id = Auth::user()->id;
    $add_activity->on_user = $on_user;
    $add_activity->text = $text;
    $add_activity->notification_text = $notification_text;
    $add_activity->description = $description;
    $add_activity->type = $type;
    $add_activity->model = $relation;
    $add_activity->type_id = $type_id;
    $add_activity->type_sub_id = $type_sub_id;
    $add_activity->unique_description = $unique_description;
    $add_activity->save();
    return TRUE;
}

function removeActivity($type, $relation, $type_id) {
    UserActivity::where(array('user_id' => Auth::user()->id, 'type' => $type, 'model' => $relation, 'type_id' => $type_id))->delete();
    return TRUE;
}

function removeGroupActivity($type, $type_id) {
    UserActivity::where(array('type' => $type, 'type_id' => $type_id))->delete();
    return TRUE;
}

function removeGroupInviteActivity($type, $relation, $type_id) {
    UserActivity::where(array('on_user' => Auth::user()->id, 'type' => $type, 'model' => $relation, 'type_id' => $type_id))->delete();
    return TRUE;
}

function removeAnswerActivity($type_sub_id) {
    UserActivity::where('type_sub_id', $type_sub_id)->whereIn('type', ['Answers', 'Likes'])->delete();
    return TRUE;
}

function removeJournalActivity($type, $type_id) {
    UserActivity::where(array('type' => $type, 'type_id' => $type_id))->delete();
    return TRUE;
}

function removeQuestionActivity($type_id) {
    UserActivity::where('type_id', $type_id)->whereIn('type', ['Questions'])->delete();
    UserActivity::where('type_id', $type_id)->where('model', 'Question')->whereIn('type', ['Tags', 'Favorites', 'Answers'])->delete();
    return TRUE;
}

function removePostActivity($type_id) {
    UserActivity::where('type_id', $type_id)->where('model', 'UserPost')->delete();
    return TRUE;
}

function removePostCommentActivity($type_id, $type_sub_id) {
    UserActivity::where(['type' => 'Comment', 'type_id' => $type_id, 'model' => 'UserPost', 'type_sub_id' => $type_sub_id])->delete();
    return TRUE;
}

function removeUserStrainActivity($type_sub_id) {
    UserActivity::where('type_sub_id', $type_sub_id)->whereIn('type', ['Strains', 'Likes'])->delete();
    return TRUE;
}

function removeUserActivity($userId, $type, $relation, $type_id) {
    if ($userId == 0) {
        UserActivity::where(array('type' => $type, 'model' => $relation, 'type_id' => $type_id))->delete();
    } else {
        UserActivity::where(array('user_id' => $userId, 'type' => $type, 'model' => $relation, 'type_id' => $type_id))->delete();
    }

    return TRUE;
}

function addMySave($user_id, $model, $description, $type_id, $type_sub_id, $strain_search_title = NULL) {
    $my_save = new MySave();
    $my_save->user_id = $user_id;
    $my_save->model = $model;
    $my_save->description = $description;
    $my_save->type_id = $type_id;
    $my_save->type_sub_id = $type_sub_id;
    $my_save->strain_search_title = $strain_search_title;
    if ($my_save->save()) {
        return $my_save;
    }
    return FALSE;
}

//function deleteMySave($user_id, $model, $type_id, $type_sub_id){
//   MySave::where(array('user_id'=>$user_id,'model'=>$model,'type_id'=>$type_id,'type_sub_id'=>$type_sub_id))->delete();
//   return TRUE;
//}
function checkMySave($user_id, $model, $type_id, $type_sub_id) {
    $check = MySave::where(['user_id' => $user_id, 'model' => $model, 'type_id' => $type_id, 'type_sub_id' => $type_sub_id])->first();
    if ($check) {
        return TRUE;
    }
    return FALSE;
}

function deleteMySave($user_id, $model, $type_id, $type_sub_id) {
    $check = MySave::where(['user_id' => $user_id, 'model' => $model, 'type_id' => $type_id, 'type_sub_id' => $type_sub_id])->delete();
    if ($check) {
        return TRUE;
    }
    return FALSE;
}

function addAdminActivity($user_id, $message, $title, $type, $model, $type_id) {
    $add_notification = new UserActivity;
    $add_notification->on_user = $user_id;
    $add_notification->type = $type;
    $add_notification->description = $message;
    $add_notification->text = $title;
    $add_notification->notification_text = $title;
    $add_notification->unique_description = $message . time();
    $add_notification->model = $model;
    $add_notification->type_id = $type_id;
    $add_notification->save();
    return TRUE;
}

function deleteUserSave($model, $type_id, $type_sub_id) {
    $check = MySave::where(['model' => $model, 'type_id' => $type_id, 'type_sub_id' => $type_sub_id])->delete();
    if ($check) {
        return TRUE;
    }
    return FALSE;
}

function addVideo($video, $path) {
    $video_extension = $video->getClientOriginalExtension(); // getting image extension
    $video_extension = strtolower($video_extension);
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
        $video_destinationPath = base_path('public/videos/' . $path); // upload path
        $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
        $fileDestination = $video_destinationPath . '/' . $video_fileName;
        $filePath = $video->getRealPath();
        exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
//        echo '<pre>';
//        print_r($result);
//        print_r($status);exit;
        $info = getVideoInformation($result);
        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
        $poster = 'public/images/' . $path . '/posters/' . $poster_name;
        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
        $data['file'] = '/' . $path . '/' . $video_fileName;
        $data['poster'] = '/' . $path . '/posters/' . $poster_name;
    } else {
        $data['file'] = '';
        $data['poster'] = '';
    }
    return $data;
}

function getVideoInformation($video_information) {
    $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
    if (preg_match($regex_duration, implode(" ", $video_information), $regs)) {
        $hours = $regs [1] ? $regs [1] : null;
        $mins = $regs [2] ? $regs [2] : null;
        $secs = $regs [3] ? $regs [3] : null;
        $ms = $regs [4] ? $regs [4] : null;
        $random_duration = sprintf("%02d:%02d:%02d", rand(0, $hours), rand(0, $mins), rand(0, $secs));
        $original_duration = $hours . ":" . $mins . ":" . $secs;
        $parsed = date_parse($original_duration);
        $seconds = ($parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']) > 20 ? true : false;
        return [$original_duration, $random_duration, $seconds];
    }
}

function getImage($image, $icon) {
    if (strpos($image, 'http') !== false) {
        return $image;
    }
    if ($image) {
        return asset(image_fix_orientation('public/images' . $image));
    }
    if ($icon) {
        return asset('public/images' . $icon);
    } else {
        return asset('public/images/profile_pics/demo.png');
    }
}

function getGroupUserImage($image, $icon) {
    if ($image) {
        return $image;
    }
    if ($icon) {
        return $icon;
    } else {
        return '/profile_pics/demo.png';
    }
}

function getSubImage($image) {
    if ($image) {
        return asset(image_fix_orientation('public/images' . $image));
    } else {
        return asset('userassets/images/budz-adz-thumbnail.svg');
    }
}

function getBusinessTypeIcon($type) {
    if ($type == 'Medical Practitioner' || $type == 'Holistic Medical' || $type == 'Clinic') {
        return asset('userassets/images/Medical.svg');
    } else if ($type == 'Lounge' || $type == 'Cannabis Club/Bar') {
        return asset('userassets/images/Entertainment.svg');
    } else {
        return asset('userassets/images/' . $type . '.svg');
    }
}

function getBusinessTypeId($sub_user_id) {
    $sub_user = SubUser::find($sub_user_id);
    return $sub_user->business_type_id;
}

function getSubBanner($image) {
    if ($image) {
        return asset(image_fix_orientation('public/images' . $image));
    } else {
//        return asset('userassets/images/buds-map-banner.jpg');
    }
}

function getSubSpecialImage($image) {
    if ($image) {
        return asset(image_fix_orientation('public/images' . $image));
    } else {
        return asset('userassets/images/maps-icon.svg');
    }
}

function getNotificationCount() {

    return UserActivity::where(array('on_user' => Auth::user()->id, 'is_read' => 0))
                    ->where(function ($q) {
                        $q->where('user_id', '!=', Auth::user()->id);
                        $q->orWhere('user_id', Null);
                    })
                    ->count();
}

function getShoutNotificationCount() {
    return ShoutOutNotification::where(array('user_id' => Auth::user()->id, 'is_read' => 0))->count();
}

function timeago($ptime) {
    $difference = time() - strtotime($ptime);
    if ($difference) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        for ($j = 0; $difference >= $lengths[$j]; $j++)
            $difference /= $lengths[$j];

        $difference = round($difference);
        if ($difference != 1)
            $periods[$j] .= "s";

        $text = "$difference $periods[$j] ago";


        return $text;
    }else {
        return 'Just Now';
    }
}

function get_time_zone($lat, $lng) {
    // get time zone
    $timestamp = strtotime(date('Y-m-d'));
//        $lat  	   = $request['lat'];
//        $lng  	   = $request['lng'];
    $curl_url = "https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=$timestamp&key=AIzaSyDdxlXEZmkr-7RJsFN7wqX5bJpBUTfzhxk";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    //$timezone = $response->timeZoneId;
    $sign = "+";
    $GMT_hours = "+00";



    if ($response) {
        if ($response->status == 'OK') {
            if (strpos($response->rawOffset, '-') !== FALSE)
                $sign = "-";

            $GMT_hours = $sign . gmdate("H", abs($response->rawOffset));
            return $GMT_hours;
        }
        else {
            return FALSE;
        }
    } else {
        return $GMT_hours;
    }
}

function getGroupImage($image) {
    if ($image) {
        return asset('public/images' . $image);
    } else {
        return asset('public/images/groups/bg1.png');
    }
}

function floorToFraction($number, $denominator = 1) {
    $x = $number * $denominator;
    $x = floor($x);
    $x = $x / $denominator;
    return $x;
}

function checkSpecialSave($sub_id) {
    return VGetMySave::Where(array('user_id' => Auth::user()->id, 'type_id' => 11, 'type_sub_id' => $sub_id))->first();
}

function checkChatSave($sub_id) {
    return VGetMySave::Where(array('user_id' => Auth::user()->id, 'type_id' => 2, 'type_sub_id' => $sub_id))->first();
}

function checkBussChatSave($sub_id) {
    return VGetMySave::Where(array('user_id' => Auth::user()->id, 'type_id' => 13, 'type_sub_id' => $sub_id))->first();
}

function getShoutoutImage($image) {
    if ($image) {
        return asset(image_fix_orientation('public/images' . $image));
    } else {
        return asset('userassets/images/img5.png');
    }
}

function sendSuccess($message, $data) {
//    return Response::json(array('status' => 'success', 'successMessage' => $message, 'successData' => $data), 200, [], JSON_NUMERIC_CHECK);
    return Response::json(array('status' => 'success', 'successMessage' => $message, 'successData' => $data), 200, []);
}

function sendError($error_message, $code) {
    return Response::json(array('status' => 'error', 'errorMessage' => $error_message), $code);
}

function getLoginUser() {
    $session = LoginUsers::where('user_id', Auth::user()->id)->where('device_type', 'web')->where('lat', '!=', '')->first();
    if (!$session) {
        $session = LoginUsers::where('user_id', Auth::user()->id)->where('lat', '!=', '')->first();
    }
    return $session;
}

function saveUsedTag($tag_id, $user_id, $menu_item_id, $type_used) {
    $used_tag = new UsedTag;
    $used_tag->tag_id = $tag_id;
    $used_tag->user_id = $user_id;
    $used_tag->menu_item_id = $menu_item_id;
    $used_tag->type_used_id = $type_used;
    $used_tag->save();
}

function addFile($file, $path) {
    if ($file) {
        if ($file->getClientOriginalExtension() != 'exe') {
            $type = $file->getClientMimeType();
            if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                $destination_path = 'public/images/' . $path; // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = 'image_' . Str::random(15) . '.' . $extension; // renameing image
                $file->move($destination_path, $fileName);
                $file_path = '/' . $path . '/' . $fileName;
//                $data['file'] = $file_path;
                image_fix_orientation('public/images' . $file_path);
                return $file_path;
            } else {
                return False;
            }
        } else {
            return False;
        }
    } else {
        return False;
    }
}

function journalsCount($user_id) {
    return Journal::where('user_id', $user_id)->count();
}

function journalsTagCount($user_id) {
    $journals = Journal::where('user_id', $user_id)->pluck('id')->toarray();
    return JournalEventTag::whereIn('journal_id', $journals)->count();
}

function todayJournalsEntries($user_id) {
    return JournalEvent::where('user_id', $user_id)
                    ->whereDate('date', Carbon::today())
                    ->count();
}

function isGroupFollowing($user_id, $group_id) {
    return GroupFollower::where(array('user_id' => $user_id, 'group_id' => $group_id))->first();
}

function sendGroupNotification($heading, $message, $data = null, $userId, $url = NULL) {
    $group_setting = UserGroupSetting::where(['user_id' => $userId, 'group_id' => $data['group_id']])->first();
    $send = TRUE;
    if ($group_setting) {
        if ($group_setting->mute_forever == 1) {
            $send = FALSE;
        } elseif ($group_setting->is_mute == 1) {
            $send = FALSE;
        } elseif ($group_setting->start_time <= Carbon::now() && $group_setting->end_time >= Carbon::now()) {
            $send = FALSE;
        }
    }

    if ($send) {
        $ios_badgeType = 'SetTo';
        $ios_badgeCount = UserActivity::where('on_user', $userId)->where('user_id', '!=', $userId)->where('is_read', 0)->count();
        //web
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //ios
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //android
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
    }
}

function sendNotification($heading, $message, $data = null, $userId, $url = NULL) {
    $ios_badgeType = 'SetTo';
    $ios_badgeCount = UserActivity::where('on_user', $userId)->where('user_id', '!=', $userId)->where('is_read', 0)->count();
    $send = checkNotificationSetting($heading, $userId);
    if ($send) {

        //web
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //ios
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url = null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //android
        OneSignal::sendNotificationUsingTags(
                $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url = null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
    }
}

function sendNotificationSpecial($heading, $message, $data = null, $userId, $url = NULL) {
    $ios_badgeType = 'SetTo';
    $ios_badgeCount = UserActivity::where('on_user', $userId)->where('user_id', '!=', $userId)->where('is_read', 0)->count();
//    $send = checkNotificationSetting($heading, $userId);
//    if ($send) {
    //web
    OneSignal::sendNotificationUsingTags(
            $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
    );
    //ios
    OneSignal::sendNotificationUsingTags(
            $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url = null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
    );
    //android
    OneSignal::sendNotificationUsingTags(
            $heading, $message, [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $userId)], $url = null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
    );
//    }
}

function checkNotificationSetting($heading, $userId) {
    $setting = NotificationSetting::where('user_id', $userId)->first();

    if ($setting) {
        if ($setting->new_question == 1 && $heading == 'New Question') {
            return TRUE;
        } elseif ($setting->follow_question_answer == 1 && $heading == 'Question Answered') {
            return TRUE;
        } elseif ($setting->like_question == 1 && $heading == 'Favorit Question') {
            return TRUE;
        } elseif ($setting->public_joined == 1 && $heading == 'Joined Public Group') {
            return TRUE;
        } elseif ($setting->private_joined == 1 && $heading == 'Joined Private Group') {
            return TRUE;
        } elseif ($setting->follow_journal == 1 && $heading == 'Journal Follow') {
            return TRUE;
        } elseif ($setting->follow_profile == 1 && $heading == 'Follow Bud') {
            return TRUE;
        } elseif ($setting->like_answer == 1 && $heading == 'Answer Liked') {
            return TRUE;
        } elseif ($setting->follow_strains == 1 && $heading == 'Like User Strain') {
            return TRUE;
        } elseif ($setting->shout_out == 1 && $heading == 'Shout Out') {
            return TRUE;
        } elseif ($setting->message == 1 && $heading == 'User Chat') {
            return TRUE;
        } elseif ($heading == 'Repost') {
            return TRUE;
        } elseif ($heading == 'Strain') {
            return TRUE;
        } elseif ($heading == 'Strains') {
            return TRUE;
        } elseif ($heading == 'Post Added') {
            return TRUE;
        } elseif ($heading == 'Post Liked') {
            return TRUE;
        } elseif ($heading == 'Post Comment') {
            return TRUE;
        } elseif ($heading == 'Budz Adz') {
            return TRUE;
        } elseif ($heading == 'Question') {
            return TRUE;
        } elseif ($heading == 'Answer') {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return TRUE;
    }
}

function getSurveyAnswers($strain_id, $question_id, $question, $id) {
    $query_results = VTopSurveyAnswer::where(['strain_id' => $strain_id, 'question_id' => $question_id])->where($question, '!=', NULL)->groupBy($id)->get();
    $total_results = VTopSurveyAnswer::where(['strain_id' => $strain_id, 'question_id' => $question_id])->where($question, '!=', NULL)->count();
//    $result_total['total'] = 0;
    $names = [];

    foreach ($query_results as $query_result) {
//        $result_total['total'] += $query_result->result;
        $names[$query_result->$question] = $query_result->result;
    }
    $results = [];
//    echo '<pre>';
//    print_r($result_total['total']);exit;
    foreach ($names as $key => $value) {
        $count_val = VTopSurveyAnswer::where(['strain_id' => $strain_id, 'question_id' => $question_id])->where($question, $key)->count();
        $total_results;
        $object = new \stdClass();
        $object->name = ucfirst((string) $key);
        $object->result = round(($count_val / $total_results) * 100, 2);
        $results[] = $object;
    }
    $order_by = 'result';
    usort($results, function ($a, $b) use ($order_by) {
        return ($a->{$order_by} < $b->{$order_by} ? 1 : -1);
    });
//echo '<pre>';
//print_r($results);exit;
    return $results;
}

function cmp($a, $b) {
    return strcmp($a->result, $b->result);
}

function checkIsFolloing($other_id) {
    return UserFollow::where(array('user_id' => Auth::user()->id, 'followed_id' => $other_id))->first();
}

function getSubUser($id) {
    return SubUser::find($id);
}

function getFlagCountSubUser() {
    return SubUserFlag::where('is_read', 0)->count();
}

function getFlagCountSubUserReviews() {
    return App\BusinessReviewReport::where('is_read', 0)->count();
}

function getFlagCountPosts() {
    return UserPostFlag::where('is_read', 0)->count();
}

function getFlagCountStainImages() {
    return App\StrainImageFlag::where('is_read', 0)->count();
}

function getFlagCountStainReviews() {
    return App\StrainReviewFlag::where('is_read', 0)->count();
}

function getFlagCountAnswers() {
    return FlagedAnswer::where('is_read', 0)->count();
}

function getFlagCountQuestion() {
    return QuestionLike::where('is_read', 0)->count();
}

function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) : DateTimeZone::listIdentifiers();

    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach ($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat = $location['latitude'];
                $tz_long = $location['longitude'];

                $theta = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }
        return $time_zone;
    }
    return 'unknown';
}

function timeZoneConversion($date, $formate, $ip) {
    $user = '';
    if (Auth::user()) {
        $user = LoginUsers::where(['user_id' => Auth::user()->id, 'device_type' => 'web', 'device_id' => $ip])->first();
    }
    if ($user) {
        $time_zone = $user->time_zone * 60;
        return date($formate, strtotime($date . " $time_zone minutes"));
    } else {
        $ipInfo = json_decode(file_get_contents('http://api.ipstack.com/' . $ip . '?access_key=' . env('IP_STACK_KEY')));
//        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
//        $url = 'http://ip-api.com/json/' . $ip;
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_RETURNTRANSFER => 1,
//            CURLOPT_URL => $url,
//            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
//        ));
//        $ipInfo = curl_exec($curl);
//        curl_close($curl);
//        $ipInfo = json_decode($ipInfo);
        $timezone = 'America/New_York';

        if (isset($ipInfo->country_code)) {
            $responce = get_nearest_timezone($ipInfo->latitude, $ipInfo->longitude, $ipInfo->country_code);
            if ($responce != 'unknown') {
                $timezone = $responce;
            }
        }
        $time = new \DateTime('now', new DateTimeZone($timezone));

        $timezoneOffset = $time->format('P');

        $time_zone = intval($timezoneOffset) * 60;
//        echo $time_zone;exit;
        return date($formate, strtotime($date . " $time_zone minutes"));
    }
}

function adminTimeZoneConversion($date, $formate, $ip) {

    $url = 'http://ip-api.com/json/' . $ip;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
    $ipInfo = curl_exec($curl);
    curl_close($curl);
    $ipInfo = json_decode($ipInfo);
    $timezone = 'Asia/Karachi';

    if (isset($ipInfo->timezone)) {
        $timezone = $ipInfo->timezone;
    }
    $time = new \DateTime('now', new DateTimeZone($timezone));

    $timezoneOffset = $time->format('P');

    $time_zone = intval($timezoneOffset) * 60;
//        echo $time_zone;exit;
    return date($formate, strtotime($date . " $time_zone minutes"));
}

function getMessageUnreadCount() {
    $unread_count = ChatMessage::where('receiver_id', Auth::user()->id)->where('is_read', 0)->count();
    if ($unread_count) {
        return $unread_count;
    } else {
        return false;
    }
}

function getGroupUnreadCount() {
    $unread_count = GroupFollower::where('user_id', Auth::user()->id)->sum('unread_count');
    if ($unread_count) {
        return $unread_count;
    } else {
        return false;
    }
}

function savePointInvite($type, $points, $user_id, $type_id = '') {
    $add_point = new UserPoint;
    $add_point->user_id = $user_id;
    $add_point->type = $type;
    $add_point->points = $points;
    $add_point->type_id = $type_id;

    $add_point->save();

    $user = User::find($user_id);
    $user->points = $user->points + $points;
    $user->save();
    return TRUE;
}

function savePoint($type, $points, $type_id = null) {
    $add_point = new UserPoint;
    $add_point->user_id = Auth::user()->id;
    $add_point->type = $type;
    $add_point->points = $points;
    $add_point->type_id = $type_id;

    $add_point->save();

    $user = User::find(Auth::user()->id);
    $user->points = $user->points + $points;
    $user->save();
    return TRUE;
}

function removePoints($type, $points, $type_id) {
    UserPoint::where(array('points' => $points, 'type_id' => $type_id, 'type' => $type, 'user_id' => Auth::user()->id))->delete();
    $user = User::find(Auth::user()->id);
    $user->points = $user->points - $points;
    $user->save();
    return TRUE;
}

function getRatingClass($points) {
    if ($points <= 99) {
        return "color white";
    } elseif ($points > 99 && $points < 200) {
        return "color green";
    } elseif ($points > 199 && $points < 300) {
        return "color blue";
    } elseif ($points > 299 && $points < 400) {
        return "color orange";
    } else {
        return "color pink";
    }
}

function getRatingText($points) {
    if ($points <= 99) {
        return "Sprout";
    } elseif ($points > 99 && $points < 200) {
        return "Seedling";
    } elseif ($points > 199 && $points < 300) {
        return "Young Bud";
    } elseif ($points > 299 && $points < 400) {
        return "Blooming Bud";
    } else {
        return "Best Bud";
    }
}

function getRatingImage($points) {
    if ($points <= 99) {
        return asset('userassets/images/img-leaf-white.png');
    } elseif ($points > 99 && $points < 200) {
        return asset('userassets/images/img-leaf-green.png');
    } elseif ($points > 199 && $points < 300) {
        return asset('userassets/images/img-leaf-orange.png');
    } elseif ($points > 299 && $points < 400) {
        return asset('userassets/images/img-leaf.png');
    } else {
        return asset('userassets/images/img-leaf-pink.png');
    }
}

function checkMySaveSetting($col) {
    $setting = MySaveSetting::where('user_id', Auth::user()->id)->first();
    if (!$setting) {
        return FALSE;
    }
    if ($setting->$col == 1) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function revertTagSpace($string) {
    $new_string = str_replace(array(
        '<br>',
        '<br/>',
        '<br />',
            ), "\n", $string);
    $replce_font = str_replace(array(
        "class' color=#6d96ad>",
        "<b ><font class='keyword_",
        "</font></b>",
        "<b><font class"
            ), "", $new_string);
    $pattern = "/(?<=href=')[^]]+?(?=')/";
    $href_removed = preg_replace($pattern, '', $replce_font);
    return str_replace(array(
        "<a target='_blank' href=",
        "</a>",
        "''>"
            ), " ", $href_removed);
}

function revertTag($string) {
    $new_string = str_replace(array(
        '<br>',
        '<br/>',
        '<br />',
            ), "\n", $string);
    $replce_font = str_replace(array(
        "class' color=#6d96ad>",
        "<b ><font class='keyword_",
        "</font></b>",
        "<b><font class"
            ), "", $new_string);
    return $replce_font;
}

function makeUrls($urls) {
    $url_list = preg_split('/[\s]+/', $urls);

    $pattern = '/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/';
    $newString = '';
    foreach ($url_list as $key => $value) {

        if (preg_match($pattern, $value)) {
            $url = $value;
            if (substr($url, 0, 4) != 'http')
                $url = "http://" . $url;
            $newString .= "<a class='anchor_class' target='_blank' href='" . $url . "'>{$value}</a> ";
        } else {
            $newString .= $value . ' ';
        }
    }
    return $newString;
}

function revertLinkTag($string) {
    $new_string = str_replace(array(
        '<br>',
        '<br/>',
        '<br />',
            ), "\n", $string);
    $pattern = "/(?<=href=')[^]]+?(?=')/";
    $href_removed = preg_replace($pattern, '', $new_string);
    $content = str_replace(array(
        "<a class='anchor_class' target='_blank' href=",
        "</a>",
        "''>"
            ), " ", $href_removed);
    return str_replace(array(
        "<a target='_blank' href=",
        "</a>",
        "''>"
            ), " ", $content);
}

function getTopUser() {
    $useres = [];
    if (Auth::user()) {
        $followers = UserFollow::select('followed_id')->where('user_id', Auth::user()->id)->get()->toArray();
        return User::whereNotIn('id', $followers)->where('id', '!=', Auth::user()->id)->orderBy('points', 'desc')->take(3)->get();
    } else {
        return $useres;
    }
}

function getTopStrains() {

    return Strain::select('strains.*', DB::raw('avg(strain_ratings.rating) AS average'))
                    ->leftjoin('strain_ratings', 'strain_ratings.strain_id', '=', 'strains.id')
                    ->orderBy('average', 'desc')
                    ->where('approved', 1)
                    ->groupBy('strain_ratings.strain_id')
                    ->take(3)
                    ->get();
}

function showMentionsAndTags($description, $json) {
    $description = $description . ' ';
    if ($json) {
        $json_data = json_decode($json);
        $i = 0;
        $j = 0;
        $new_array = [];
        foreach ($json_data as $add_special) {
            $tag_value = $add_special->value;
            if (strpos($add_special->value, ' ') !== false) {
                $tag_value = str_replace(' ', '&!&', $add_special->value);
                $description = str_replace($add_special->value, $tag_value, $description);
            }
            $new_array[$j]['type'] = $add_special->type;
            $new_array[$j]['value'] = $tag_value;
            $new_array[$j]['trigger'] = $add_special->trigger;
            $new_array[$j]['id'] = $add_special->id;
            $j++;
        }
        $obj = json_decode(json_encode($new_array));
        $object = (object) $obj;
//       print_r($object);exit;
        foreach ($object as $data) {
            if ($data->type == 'user') {
                $user = User::find($data->id);
                if ($user) {
                    $class = getRatingClass($user->points);
                    $description = str_replace('@' . $data->value . ' ', "<a class='$class'  href='" . asset('user-profile-detail/' . $data->id) . "' style='font-weight: 600;font-style: italic;color: #63a1c8;'>@" . $data->value . ' ' . "</a>", $description);
                }
//                else{
//                    unset($json_data[$i]);
//                }
            } else if ($data->type == 'tag') {
                $description = str_replace('#' . $data->value . ' ', "<font class='keyword_class' color='#6d96ad'>#" . $data->value . ' ' . "</font>", $description);
            } else if ($data->type == 'budz') {
                $sub_user = SubUser::find($data->id);
                if ($sub_user) {
                    $description = str_replace('@' . $data->value . ' ', "<a class=''  href='" . asset("get-budz?business_id= $data->id&business_type_id=$sub_user->business_type_id") . "' style='font-weight: 600;font-style: italic;color: #F7921F;'>@" . $data->value . ' ' . "</a>", $description);
                }
            }
            $i++;
        }
        $description = str_replace('&!&', ' ', $description);
        return $description;
    } else {
        return $description;
    }
}

function getChats() {
    $user_id = Auth::user()->id;
    return ChatUser::with(['sender' => function ($q) {
                            $q->withCount(['isOnline' => function ($q) {
                                    $q->where('is_online', 1);
                                }]);
                        }])->with(['receiver' => function ($q) {
                            $q->withCount(['isOnline' => function ($q) {
                                    $q->where('is_online', 1);
                                }]);
                        }])
                    ->withCount(['messages' => function ($q) {
                            $q->where('is_read', 0);
                        }])
                    ->where(function ($q) use($user_id) {
                        $q->where('sender_id', $user_id);
                        $q->orWhere('receiver_id', $user_id);
                    })
                    ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                    ->orderBy('updated_at', 'desc')->get();
}

function getFeeds() {
    $user_id = Auth::user()->id;

    return UserActivity::where(function($q) use ($user_id) {
                        $q->where('on_user', $user_id);
                        $q->where('user_id', '!=', $user_id);
                    })->orwhere(function($q) use ($user_id) {
                        $q->where('on_user', $user_id);
                        $q->where('user_id', null);
                    })
                    ->take(5)
                    ->with('user')
                    ->groupBy('unique_description')
                    ->orderBy('created_at', 'desc')
                    ->get();
}

function addHbMedia($path, $type = 'image', $poster = '') {
    $check = HbGalleryMedia::where(['path' => $path, 'type' => $type])->first();
    if ($check) {
        return true;
    }
    $add_media = new HbGalleryMedia;
    $add_media->user_id = Auth::user()->id;
    $add_media->type = $type;
    $add_media->path = $path;
    $add_media->poster = $poster;
    $add_media->save();
    return $add_media;
}

function makeDone($user_id, $rewRd_id) {
    $check_done = UserRewardStatus::where(array('user_id' => $user_id, 'reward_points_id' => $rewRd_id))->first();
    if (!$check_done) {
        $add_new = new UserRewardStatus;
        $add_new->user_id = $user_id;
        $add_new->reward_points_id = $rewRd_id;
        $add_new->save();
    }
}

function addCheckUserPoint($count, $type, $type_id, $message, $user_id = '') {

    if (!$user_id) {
        $user_id = Auth::user()->id;
    }
    if ($type == 'share' || $type == 'follower') {
        if ($count >= 10) {
            $check_points = UserPointRecord::where('type', $type)->whereUserId(Auth::user()->id)->first();
            if (!$check_points) {
                $add_point_record = new UserPointRecord;
                $add_point_record->last_point = 10;
                $add_point_record->type = $type;
                $add_point_record->user_id = Auth::user()->id;
                $add_point_record->save();
                savePoint($message, 5, $type_id);
                return $add_point_record;
            } else {
                if ($count >= $check_points->last_point + 10) {
                    $check_points->last_point = $check_points->last_point + 10;
                    $check_points->save();
                    savePoint($message, 5, $type_id);
                    return $check_points;
                }
            }
        }
    } else {

        if ($count >= 10) {
            $check_points = UserPointRecord::where('type', $type)->where('type_id', $type_id)->whereUserId($user_id)->first();
            if (!$check_points) {
                $add_point_record = new UserPointRecord;
                $add_point_record->last_point = 10;
                $add_point_record->type = $type;
                $add_point_record->user_id = $user_id;
                $add_point_record->type_id = $type_id;
                $add_point_record->save();
                savePointInvite($message, 5, $user_id, $type_id);
                return $add_point_record;
            } else {
                if ($count >= $check_points->last_point + 10) {
                    $check_points->last_point = $check_points->last_point + 10;
                    $check_points->save();
                    savePointInvite($message, 5, $user_id, $type_id);
                    return $check_points;
                }
            }
        }
    }
}

function addUserShare($type_id, $model) {
    $add_Share = new UserShare;
    $add_Share->user_id = Auth::user()->id;
    $add_Share->type_id = $type_id;
    $add_Share->model = $model;
    $add_Share->save();
    return Usershare::where('user_id', Auth::user()->id)->count();
}

function getUser($user_id) {
    return User::find($user_id);
}

function getQuestoinsAnswers($id) {
    return \App\Answer::where('question_id', $id)->count();
}

function getUserLatLng($user_id) {
    $headers = getallheaders();
    $user = User::where('id', $user_id)->first();
    $login_user = LoginUsers::where(['user_id' => $user_id, 'session_key' => $headers['session_token']])->first();
    if ($login_user->lat && $login_user->lng) {
        $data['lat'] = $login_user->lat;
        $data['lng'] = $login_user->lng;
    } elseif ($user->lat && $user->lng) {
        $data['lat'] = $user->lat;
        $data['lng'] = $user->lng;
    } else {
        $data['lat'] = '37.0902';
        $data['lng'] = '95.7129';
    }
    if (env('location_mode') == 'dev') {
        $data['lat'] = env('lat');
        $data['lng'] = env('lng');
    }
    return $data;
}

function deleteNotificationFromAdmin($user_id, $message, $title) {
    $url = asset('/budz-feeds');
    $add_notification = new UserActivity;
    $add_notification->on_user = $user_id;
    $add_notification->type = 'Admin';
    $add_notification->description = $message;
    $add_notification->text = $title;
    $add_notification->notification_text = $title;
    $add_notification->unique_description = $message . '_' . time();
    $add_notification->save();
    $data['activityToBeOpened'] = 'Admin';
//            Web
    \OneSignal::sendNotificationUsingTagsAdmin(
            $title, $message, [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $user_id)], $url, $data, $buttons = null, $schedule = null, null, null
    );
    //ios

    \OneSignal::sendNotificationUsingTagsAdmin(
            $title, $message, [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $user_id)], null, $data, $buttons = null, $schedule = null, null, null
    );
//            android
    \OneSignal::sendNotificationUsingTagsAdmin(
            $title, $message, [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $user_id)], null, $data, $buttons = null, $schedule = null, null, null
    );
}

function checkToday($timestamp) {
    if ($timestamp == date('d/m/Y')) {
        return 'Today at ';
    } else if ($timestamp == date('d/m/Y', strtotime("-1 day"))) {
        return 'Yesterday at ';
    }
    return FALSE;
}

//function correctImageOrientation($filename) {
//  if (function_exists('exif_read_data')) {
//    $exif = @exif_read_data($filename);
//    if($exif && isset($exif['Orientation'])) {
//      $orientation = $exif['Orientation'];
//      if($orientation != 1){
//        $img = imagecreatefromjpeg($filename);
//        $deg = 0;
//        switch ($orientation) {
//          case 3:
//            $deg = 180;
//            break;
//          case 6:
//            $deg = 90;
//            break;
//          case 8:
//            $deg = -90;
//            break;
//        }
//        if ($deg) {
//          $img = imagerotate($img, $deg, 0);       
//        }
//        // then rewrite the rotated image back to the disk as $filename
//         imagejpeg($img, $filename, 95);
//      } // if there is some rotation necessary
//    } // if have the exif orientation info
//  } // if function exists  
//  return $filename;
//}

function image_fix_orientation($filename) {
    $exif = @exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        imagejpeg($image, $filename, 90);
    }
    return $filename;
}

function ifHasSubs() {
    return SubUser::where('user_id', Auth::user()->id)->whereHas('subscriptions')->first();
}

function getSpecialIcon($icon) {
    if ($icon) {
        return asset('public/images' . $icon);
    } else {
        return '';
    }
}

function getPostion($zip, $tag_id) {
    $user_id = Auth::user()->id;
    $tags = TagStatePrice::where(array('tag_id' => $tag_id, 'zip_code' => $zip))->orderBy('price', 'desc')->get();
    $return = 1;
    foreach ($tags as $tag) {
        if ($tag->user_id == $user_id) {
            return $return;
        }
        $return++;
    }

    function getAllIcons() {
        return Icons::all();
    }

}
