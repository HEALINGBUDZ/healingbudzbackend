<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
//Models
use App\UserPost;
use App\UserPostAttachment;
use App\UserPostTaged;
use App\UserPostComment;
use App\UserPostCommentAttachment;
use App\UserPostLike;
use App\UserPostFlag;
use App\UserPostShare;
use App\UserPostMute;
use App\UserFollow;
use App\SubUser;
use App\UserPostScrape;
use App\UserPostCommentLike;

class PostController extends Controller {

    private $user;
    private $userId;
    private $userName;
    private $videos_path;
    private $posters_path;
    private $video_extentions;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
        $this->photos_path = 'public/images/posts';
        $this->videos_path = 'public/videos/posts/';
        $this->posters_path = 'public/images/posts/posters/';
        $this->video_extentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
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
    }

    function fetchPosts() {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10;
        }
        $filters = "";
        if (isset($_GET['filters'])) {
            $filters = $_GET['filters'];
        }
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
//        $user_follow[] = $this->userId;

        $followed_post = UserPost::whereIn('user_id', $user_follow)->orderBy('created_at', 'asc')->pluck('id')->toArray();
        $followed_posts = implode(',', $followed_post);
        if ($followed_posts == '') {
            $followed_posts = 0;
        }

        $data['posts'] = UserPost::with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged.user', 'Likes', 'Likes.User', 'Flags', 'scrapedUrl')
//                        ->whereIn('user_id', $user_follow)
                ->withCount('Likes', 'Liked', 'Shared', 'Flaged', 'Comments', 'MutePostByUser')

//                        ->when($filters == "", function ($query) {
////                            return $query->orderBy('id', 'Desc');
//                        })
                ->when($filters == "Most Liked", function ($query) {
                    return $query->orderBy('likes_count', 'Desc')->orderBy('created_at', 'Desc');
                })
                ->when($filters == "Newest", function ($query) {
                    return $query->orderBy('created_at', 'Desc');
                })
                ->with(['Comments' => function($q) {
                        $q->with('User', 'Attachment', 'likes', 'likes.user');
                        $q->withCount('likes', 'Liked');
                    }])->whereDoesntHave('Flaged', function ($q) {
                    
                })
//                        ->with('Comments.User', 'Comments.Attachment')
                ->orderByRaw(DB::raw("FIELD(id, $followed_posts) desc"))
                ->orderBy('created_at', 'Desc')->take(10)->skip($skip)
                ->get();

//        foreach ($data['posts'] as $post) {
//            
//            $post->Comments = $post->Comments->take(10);
//            
//        }
//        $data['posts']->forget('comments');
        return sendSuccess('', $data);
    }

    function userPosts($user_id) {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 5;
        }
        $data['posts'] = UserPost::where('user_id', $user_id)
                        ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged.user', 'Likes', 'Flags', 'scrapedUrl')
                        ->withCount('Likes', 'Liked', 'Shared', 'Flaged', 'Comments', 'MutePostByUser')
                        ->with(['Comments' => function($q) {
                                $q->with('User', 'Attachment', 'likes', 'likes.user');
                                $q->withCount('likes', 'Liked');
                            }])->whereDoesntHave('Flaged', function ($q) {
                            
                        })->whereDoesntHave('Flaged', function ($q) {
                            
                        })
                        ->orderBy('id', 'Desc')
                        ->take(5)->skip($skip)->get();

        return sendSuccess('', $data);
    }

    function getSubUsers(Request $request) {
        $take = 100;
        $skip = 0;
        $query = '';
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 100;
        }
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
        }
        $data['sub_users'] = SubUser::select('id', 'logo', 'title')
                ->when($query, function ($qs) use ($query) {
                    return $qs->where('title', 'like', "%$query%");
                })
                ->where('user_id', $this->userId)
                ->where('is_blocked', 0)
                ->where('business_type_id', '!=', '')
                ->skip($skip)
                ->take($take)
                ->get();
        return sendSuccess('', $data);
    }

    function getAllSubUsers(Request $request) {
        $take = 100;
        $skip = 0;
        $query = '';
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 100;
        }
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
        }
        $data['sub_users'] = SubUser::select('id', 'logo', 'title')->where('business_type_id', '!=', '')
                ->when($query, function ($qs) use ($query) {
                            return $qs->where('title', 'like', "%$query%");
                        })
                        ->where('is_blocked', 0)->skip($skip)
                        ->take($take)->with('special')->get();
        return sendSuccess('', $data);
    }

    function addPost(Request $request) {
        $validation = $this->validate($request, [
//            'description' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $add_post = new UserPost;
        if (isset($request['post_id'])) {
            $add_post = UserPost::find($request['post_id']);
            UserPostAttachment::where('post_id', $request['post_id'])->delete();
            UserPostTaged::where('post_id', $request['post_id'])->delete();
        }
        $add_post->description = trim(makeUrls(($request['description'])));
        $add_post->json_data = $request['json_data'];
        $add_post->allow_repost = $request['repost_to_wall'];
        $add_post->user_id = $this->userId;
        $user_array = explode('_', $request['posting_user']);
        if ($user_array[0] == 's') {
            $add_post->sub_user_id = $user_array[1];
        }

        $add_post->save();
        if ($request['images']) {
            $images = explode(',', $request['images']);
            $thumb = explode(',', $request['thumb']);
            $ratio = explode(',', $request['ratio']);
            $i = 0;
            foreach ($images as $image) {
                $add_image = new UserPostAttachment;
                $add_image->post_id = $add_post->id;
                $add_image->user_id = $this->userId;
                $add_image->file = $image;
                $add_image->thumnail = '/posts/thumnails/' . $thumb[$i];
                $add_image->ratio = (string) $ratio[$i];
                $add_image->type = 'image';
                $add_image->save();
                if (!$request['post_id']) {
                    addHbMedia($image);
                }
                $i++;
            }
        }

        if ($request['video']) {
            $add_image = new UserPostAttachment;
            $add_image->post_id = $add_post->id;
            $add_image->file = $request['video'];
            $add_image->type = 'video';
            $add_image->user_id = $this->userId;
            $add_image->poster = $request['poster'];
            $add_image->save();
            if (!$request['post_id']) {
                addHbMedia($request['video'], 'video', $request['poster']);
            }
        }

        if ($request['tagged']) {
            $tags = explode(',', $request['tagged']);
            $heading = 'Post Added';
            $message = ' tagged you in the post.';
            $notification_text = 'You added a post';
            $activity_type = 'Post';
            $sub_type_id = null;
//            $this->sendPostNotification($tags, $user_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);

            foreach ($tags as $tagged_id) {
                $add_image = new UserPostTaged;
                $add_image->post_id = $add_post->id;
                $add_image->user_id = $tagged_id;
                $add_image->save();
            }
        }
        if (isset($request['url'])) {
            if ($request['url']) {
                $url_data = $this->scrapeUrl($request['url']);
                if ($url_data) {

                    UserPostScrape::where('post_id', $add_post->id)->delete();
                    $scraped_url = new UserPostScrape;
                    $scraped_url->post_id = $add_post->id;
                    $scraped_url->title = $url_data['title'];
                    $scraped_url->content = $url_data['content'];
                    if (isset($url_data['images'][0])) {
                        $scraped_url->image = $url_data['images'][0];
                    } else {
                        $scraped_url->image = '';
                    }
                    if (strpos($url_data['url'], 'http') !== false) {
                        $extracted_url = $url_data['url'];
                    } else {
                        $extracted_url = 'http://' . $url_data['url'];
                    }
                    $scraped_url->extracted_url = $extracted_url;
                    if (strpos($request['url'], 'http') !== false) {
                        $url = $request['url'];
                    } else {
                        $url = 'http://' . $request['url'];
                    }
                    $scraped_url->url = $url;
                    $scraped_url->save();
                }
            }
        }


        //send notification to users who are tagged in post description
        $tagged_users = [];
        if ($request['json_data']) {
            $description_tagged = json_decode($request['json_data']);

            foreach ($description_tagged as $tagged) {
                if ($tagged->type == 'user') {
                    $tagged_users[] = $tagged->id;
                }
            }
            if (count($tagged_users) > 0) {
                $heading = 'Post Added';
                $message = ' tagged you in the post.';
                $notification_text = 'You added a post';
                $activity_type = 'Post';
                $sub_type_id = null;
                $this->sendPostNotification($tagged_users, $add_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);
            }
        }
        addActivity($this->userId, 'You added a post', 'You added a post', $add_post->description, 'Post', 'UserPost', $add_post->id, '', $add_post->description . ' <span style="display:none">' . $add_post->id . '</span>');
//addActivity($this->userId, $message, $notification_text, $add_post->title, $activity_type, 'UserPost', $post->id, $user_comment->id, $unique_description);
        $data['posts'] = UserPost::where('id', $add_post->id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged.user', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->get();

        return sendSuccess('Post saved successfully.', $data);
    }

    function addImage(Request $request) {

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }
        $file = $request->file('image');
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension != 'exe') {
            $name = 'image_' . str_random(10);
            $save_name = $name . '.' . $file->getClientOriginalExtension();
//                $original_name = basename($file->getClientOriginalName());
            $resize_name = 'thum_' . $save_name;
            $preview_height = Image::make($file->getRealPath())->height();
            $get_width = Image::make($file->getRealPath())->width();
            $ratio = $get_width / $preview_height;
            Image::make($file)
                    ->resize(200, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })->orientate()
                    ->save($this->photos_path . '/thumnails/' . $resize_name);
//                image_fix_orientation($this->photos_path . '/thumnails/' . $resize_name);      
            $file->move($this->photos_path, $save_name);
            $data['file'] = '/posts/' . $save_name;
            $data['thumb'] = $resize_name;
            $data['ratio'] = $ratio;
            $data['width'] = $get_width;
            $data['height'] = $preview_height;
            return json_encode($data);
        }
//        }
//                $data['file'] = addFile($request['image'], 'posts');
//        return json_encode($data);
    }

    function addVideo(Request $request) {
        return json_encode(addVideo($request['video'], 'posts'));
    }

    function addComment(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_comment = new UserPostComment;
        if (isset($request['comment_id'])) {
            $add_comment = UserPostComment::find($request['comment_id']);
            UserPostCommentAttachment::where(['comment_id' => $request['comment_id'], 'user_id' => $this->userId])->delete();
        }

        $add_comment->user_id = $this->userId;
        $add_comment->post_id = $request['post_id'];
        $add_comment->comment = $request['comment'];
        if ($request['json_data']) {
            $add_comment->json_data = $request['json_data'];
        }
        $add_comment->save();

        if ($request['attachment']) {
            $add_comment_attachment = new UserPostCommentAttachment;
            $add_comment_attachment->comment_id = $add_comment->id;
            $add_comment_attachment->user_id = $this->userId;
            $add_comment_attachment->file = $request['attachment'];
            $add_comment_attachment->poster = $request['poster'];
            $add_comment_attachment->type = $request['type'];
            $add_comment_attachment->thumnail = '/posts/thumnails/' . $request['thumb'];
            $add_comment_attachment->save();
        }
        $data['comments'] = UserPostComment::where('id', $add_comment->id)->withCount('likes', 'Liked')->with('User', 'Attachment', 'likes', 'likes.user')->first();
        $this->sendCommentNotifications($request);
        return sendSuccess('Comment saved successfully.', $data);
    }

    function deleteComment(Request $request) {
        $validation = $this->validate($request, [
            'comment_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $comment = UserPostComment::find($request['comment_id']);
        if (!$comment) {
            return sendError('Comment Not Found', 400);
        }
        if ($comment->user_id != $this->userId) {
            return sendError('You are not autherized to delete post', 402);
        }
        $post_id = $comment->post_id;

        $comment->delete();
        //Delete Entry from User Activity Log
        $type_id = $post_id;
        $type_sub_id = $request['comment_id'];
        removePostCommentActivity($type_id, $type_sub_id);
        return sendSuccess('Comment deleted successfully.', '');
    }

    function postLikeDislike(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required',
            'is_like' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_post_like = UserPostLike::where(['user_id' => $this->userId, 'post_id' => $request['post_id']])->first();
        if (!$add_post_like) {
            $add_post_like = new UserPostLike;
        }
        $add_post_like->post_id = $request['post_id'];
        $add_post_like->user_id = $this->userId;
        $add_post_like->is_like = $request['is_like'];
        $add_post_like->save();
        $retated_users = '';
        if ($request['is_like'] == 1) {
            $retated_users = $this->getPostRelatedUsers($request['post_id']);
            $retated_users = array_unique($retated_users);
            $heading = 'Post Liked';
            $message = ' liked the post.';
            $notification_text = 'You Liked post';
            $activity_type = 'Likes';
            $sub_type_id = $add_post_like->id;
            $this->sendPostNotificationLike($retated_users, $request['post_id'], $heading, $message, $notification_text, $activity_type, $sub_type_id);
        }
        return sendSuccess('Post like saved successfully.', $add_post_like);
    }

    function addSave(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $model = 'UserPost';
        $description = '';
        $type_id = 12;
        $type_sub_id = $request['post_id'];
        if ($request['is_like'] == 1) {
            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
                if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {
                    $post_detail = UserPost::find($request['post_id']);
                    //Notification Code
                    if ($post_detail->user_id != $this->userId) {
                        $heading = 'Favorit Post';
                        $message = $this->userName . ' added your post to his favorites.';
                        $data['activityToBeOpened'] = "UserPost";
                        $data['post_id'] = (int) $post_detail->id;
                        $data['type_id'] = (int) $post_detail->id;
                        $data['question'] = $post_detail->description;
                        $url = asset('get-post/' . $post_detail->id);
                        sendNotification($heading, $message, $data, $post_detail->user_id, $url);
                    }
                    //Add Activity

                    addActivity($post_detail->user_id, 'You added a post to your favorites', $message, $post_detail->description, 'Favorites', 'UserPost', $post_detail->id, '', $post_detail->description . ' <span style="display:none">' . $type_sub_id->id . '_' . $this->userId . '</span>');
                    return sendSuccess('Post has been saved as your favorit.', '');
                } else {
                    return sendError('Error in saving discussion.', 417);
                }
            }
            return sendError('This Post is already exist in your saves.', 418);
        } else {
            deleteMySave($user_id, $model, $type_id, $type_sub_id);
            return sendSuccess('Post has been removed', '');
        }
    }

    function flagPost(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required',
            'reason' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_post_flag = UserPostFlag::where(['user_id' => $this->userId, 'post_id' => $request['post_id']])->first();
        if (!$add_post_flag) {
            $add_post_flag = new UserPostFlag;
        }
        $add_post_flag->post_id = $request['post_id'];
        $add_post_flag->user_id = $this->userId;
        $add_post_flag->reason = $request['reason'];
        $add_post_flag->save();

        return sendSuccess('Post flag saved successfully.', $add_post_flag);
    }

    function getPost($post_id) {
        $data['post'] = UserPost::where('id', $post_id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged.user', 'Likes.User', 'Flags', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->with(['Comments' => function($q) {
                        $q->with('User', 'Attachment', 'likes', 'likes.user');
                        $q->withCount('likes', 'Liked');
                    }])->withCount('Likes', 'Liked', 'Shared', 'Flaged', 'Comments', 'MutePostByUser')
                ->first();

        return sendSuccess('', $data);
    }

    function getComments($post_id) {
        $skip = 10;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10;
        }
        $data['comments'] = UserPostComment::where('post_id', $post_id)
                ->with('User', 'Attachment', 'likes', 'likes.user')
                ->withCount('likes', 'Liked')
                ->orderBy('id', 'desc')
                ->take(10)->skip($skip)
                ->get();

        return sendSuccess('', $data);
    }

    function deletePost(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $post = UserPost::find($request['post_id']);
        if (!$post) {
            sendError('Post Not Found', 400);
        }
        if ($post->user_id != $this->userId) {
            sendError('You are not autherized to delete post', 402);
        }
        UserPost::where(['shared_id' => $request['post_id']])->delete();
        $post->delete();
        //Delete Entry from User Activity Log
        $type_id = $request['post_id'];
        removePostActivity($type_id);

        //Delete Entry from Saves List
        $model = 'UserPost';
        $menu_item_id = 12;
        $type_sub_id = $request['post_id'];
        deleteUserSave($model, $menu_item_id, $type_sub_id);
        return sendSuccess('Post deleted successfully', '');
    }

    function mutePost(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required',
            'is_mute' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_post_mute = UserPostMute::where(['user_id' => $this->userId, 'post_id' => $request['post_id']])->first();
        if (!$add_post_mute) {
            $add_post_mute = new UserPostMute;
        }
        $add_post_mute->post_id = $request['post_id'];
        $add_post_mute->user_id = $this->userId;
        $add_post_mute->is_mute = $request['is_mute'];
        $add_post_mute->save();

        return sendSuccess('Post mute saved successfully.', $add_post_mute);
    }

    public function repost(Request $request) {
        $validation = $this->validate($request, [
            'post_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $post = UserPost::find($request['post_id']);
        $new_post = $post->replicate();
        $new_post->user_id = $this->userId;
        $user_array = explode('_', $request['posting_user']);
        if ($user_array[0] == 's') {
            $new_post->sub_user_id = $user_array[1];
        }
        $shared_id = $post->id;
        $shared_user_id = $post->user_id;
        if ($post->shared_id) {
            $shared_id = $post->shared_id;
            $shared_user_id = $post->shared_user_id;
        }
        $new_post->shared_id = $shared_id;
        $new_post->shared_user_id = $shared_user_id;
        if ($request->post_added_comment) {
            $new_post->post_added_comment = $request->post_added_comment;
        }
        $new_post->save();
        $attachments = UserPostAttachment::where('post_id', $post->id)->get();
        foreach ($attachments as $attachment) {
            $new_attachment = $attachment->replicate();
            $new_attachment->post_id = $new_post->id;
            $new_attachment->save();
        }
        $scraped_urls = UserPostScrape::where('post_id', $post->id)->get();
        foreach ($scraped_urls as $scraped_url) {
            $new_url = $scraped_url->replicate();
            $new_url->post_id = $new_post->id;
            $new_url->save();
        }

        //send notification to orignal post user
        $mute_post = UserPostMute::where(['post_id' => $request['post_id'], 'is_mute' => 1])->first();
        if (!$mute_post) {
            $heading = 'Repost';
            $message = ' reposted your post';
            $notification_text = 'You added a post';
            $activity_type = 'Post';
            $sub_type_id = null;
            $this->sendPostNotificationLike([$shared_user_id], $new_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);
        }

        if (isset($request['tagged_users']) && $request['tagged_users']) {
            $tagged_users = explode(',', $request['tagged_users']);
            $heading = 'Post Added';
            $message = ' tagged you in the post.';
            $notification_text = 'You added a post';
            $activity_type = 'Post';
            $sub_type_id = null;
            $this->sendPostNotification($tagged_users, $new_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);

            foreach ($tagged_users as $id) {
                $tagged = new UserPostTaged;
                $tagged->post_id = $new_post->id;
                $tagged->user_id = $id;
                $tagged->save();
            }
        }
        $data['posts'] = UserPost::where('id', $new_post->id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged.user', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->get();
        return sendSuccess('Post saved successfully.', $data);
    }

    public function sendPostNotification($users, $post_id, $heading, $message, $notification_text, $activity_type, $sub_type_id) {
        $post = UserPost::find($post_id);
        if ($sub_type_id) {
            $unique_text = $post->description . ' <span style="display:none">' . $post->id . '_' . $sub_type_id . '</span>';
        } else {
            $unique_text = $post->description . ' <span style="display:none">' . $post->id . '</span>';
        }
        $message = $this->userName . $message;
        foreach ($users as $id) {
            //Notification Code

            if ($id != $this->userId) {
                $heading = $heading;

                $data['activityToBeOpened'] = "Post";
                $data['post_id'] = (int) $post_id;
                $data['type_id'] = (int) $post_id;
                $url = asset('get-post/' . $post_id);
                sendNotification($heading, $message, $data, $id, $url);
            }
            //Add Activity
            addActivity($id, $notification_text, $message, $post->description, $activity_type, 'UserPost', $post_id, $sub_type_id, $unique_text);
        }
    }

    public function scrapeUrl($scrape_url) {
        if (!empty($scrape_url) && filter_var($scrape_url, FILTER_VALIDATE_URL)) {
            $get_url = $scrape_url;

            $parse = parse_url($get_url);
            $url = $parse['host'];

            //get URL content
            $get_content = HtmlDomParser::file_get_html($scrape_url);
            if (!$get_content) {
                return false;
            }
//            return Response::json(['data' => $get_content], 200);
            $dom_obj = new \DOMDocument();
            libxml_use_internal_errors(true);

            $dom_obj->loadHTML($get_content);
            $meta_val = null;
            //$page_body = null;
            //Get Page Title
            $page_title = '';
            foreach ($get_content->find('title') as $element) {
                $page_title = $element->plaintext;
                break;
            }


            //Get Body Text
            $page_body = '';
            if (count($get_content->find('body')) > 0) {
                foreach ($get_content->find('body') as $element) {
                    $page_body = trim($element->plaintext);
                    if ($page_body) {
                        $pos = strpos($page_body, ' ', 200); //Find the numeric position to substract
                        $page_body = substr($page_body, 0, $pos); //shorten text to 200 chars
                    }
                }
            } if (!$page_body) {


                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {

                    if ($meta->getAttribute('property') == 'og:description') {
                        $page_body = $meta->getAttribute('content');

                        //return $page_body;
                    } elseif ($meta->getAttribute('name') == 'description') {
                        $page_body = $meta->getAttribute('content');
                        //return $page_body;
                    }
                }
            }
            $image_urls = array();

            if (count($get_content->find('img')) > 0) {

                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {

                    if ($meta->getAttribute('property') == 'og:image') {

                        $image_urls[] = $meta->getAttribute('content');
                        //dd($meta->getAttribute('content'));
                    }
                }
                if (empty($image_urls)) {
                    //get all images URLs in the content
                    foreach ($get_content->find('img') as $element) {
                        //  check image URL is valid and name isn't blank.gif/blank.png etc..
                        // you can also use other methods to check if image really exist 
                        if (!preg_match('/blank.(.*)/i', $element->src) && filter_var($element->src, FILTER_VALIDATE_URL)) {
                            $image_urls[] = $element->src;
                        }
                    }
                }
            } else {
                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {

                    if ($meta->getAttribute('property') == 'og:image') {

                        $image_urls[] = $meta->getAttribute('content');
                        //dd($meta->getAttribute('content'));
                    }
                }
            }

            //prepare for JSON
            $output = array('title' => $page_title, 'images' => $image_urls, 'content' => utf8_decode($page_body), 'url' => $url);
            return $output; //output JSON data
        } else {
            return FALSE;
        }
    }

    public function getPostRelatedUsers($post_id) {

        $mute_post_users = UserPostMute::where(['post_id' => $post_id, 'is_mute' => 1])->pluck('user_id')->toArray();
        $retated_users = new Collection();
        //user who posted on wall
        $retated_users = $retated_users->union(UserPost::where('id', $post_id)->pluck('user_id')->toArray());
        //Users who commented on post
        $retated_users = $retated_users->union(UserPostComment::where('post_id', $post_id)->groupBy('user_id')->pluck('user_id', 'user_id')->toArray());
        //Users who liked post
        $retated_users = $retated_users->union(UserPostLike::where(['post_id' => $post_id, 'is_like' => 1])->pluck('user_id')->toArray());
        //Users who taged in the post
        $retated_users = $retated_users->union(UserPostTaged::where('post_id', $post_id)->pluck('user_id')->toArray());
//        $new_array = [];
//        foreach($mute_post_users as $mute_post_user){
//            $new_array = $retated_users->forget($mute_post_user);//remove users who muted the post
//        }
//        $retated_users->forget($mute_post_users);
        $new_array = array_diff($retated_users->toArray(), $mute_post_users);

        return $new_array;
    }

    public function sendPostNotificationLike($users, $post_id, $heading, $message, $notification_text, $activity_type, $sub_type_id) {
        $post = UserPost::find($post_id);
        if ($sub_type_id) {
            $unique_description = $post->description . ' <span style="display:none">' . $post->id . '_' . $sub_type_id . '</span>';
        } else {
            $unique_description = $post->description . ' <span style="display:none">' . $post->id . '</span>';
        }
        $message = $this->userName . $message;
        foreach ($users as $id) {
            //Notification Code

            if ($id != $this->userId) {
                $heading = $heading;

                $data['activityToBeOpened'] = "Post";
                $data['post_id'] = (int) $post_id;
                $data['type_id'] = (int) $post_id;
                $url = asset('get-post/' . $post_id);
                sendNotification($heading, $message, $data, $id, $url);
            }
            //Add Activity
            $description = $post->description;
            addActivity($id, $notification_text, $message, $description, $activity_type, 'UserPost', $post_id, $sub_type_id, $unique_description);
        }
    }

    public function sendCommentNotifications(Request $request) {
        $user_comment = UserPostComment::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->orderBy('created_at', 'Desc')->first();
        $post = UserPost::find($request['post_id']);
        if ($user_comment->id) {
            $unique_description = $post->description . ' <span style="display:none">' . $post->id . '_' . $user_comment->id . '</span>';
        } else {
            $unique_description = $post->description . ' <span style="display:none">' . $post->id . '</span>';
        }
        $retated_users = $this->getPostRelatedUsers($request['post_id']);
        $retated_users = array_unique($retated_users);
        $heading = 'Post Comment';
        $message = ' commented on post.';
        $notification_text = 'You commented on post';
        $activity_type = 'Comment';
        $sub_type_id = $user_comment->id;
        $this->sendPostNotification($retated_users, $request['post_id'], $heading, $message, $notification_text, $activity_type, $sub_type_id);
        $user_attached = json_decode($request['description_data']);
        if (($user_attached)) {
            if (count($user_attached) > 0) {
                foreach ($user_attached as $user) {
                    $comment_message = $this->userName . ' mention you in a comment.';
                    $data['post_id'] = (int) $post->id;
                    $url = asset('get-post/' . $post->id);
                    $data['type_id'] = (int) $post->id;
                    sendNotification($heading, $comment_message, $data, $user->id, $url);
                    $description = $post->description;
                    addActivity($user->id, $message, $notification_text, $description, $activity_type, 'UserPost', $post->id, $user_comment->id, $unique_description);
                }
            }
        }

        return TRUE;
    }

    function addSharedUrlPost(Request $request) {
        $user_post = new UserPost;
        $user_post->user_id = $this->userId;
        $user_post->description = $request['url'];
        $user_post->json_data = json_encode([]);
        $user_post->allow_repost = 1;
        $user_post->save();
        //scraped url
        if (isset($request['url'])) {
            if ($request['url']) {
                $url_data = $this->scrapeUrl($request['url']);
                if ($url_data) {
                    $url_data['url'] = strtolower($url_data['url']);
                    $request['url'] = strtolower($request['url']);
                    $scraped_url = new UserPostScrape;
                    $scraped_url->post_id = $user_post->id;
                    $scraped_url->title = $url_data['title'];
                    $scraped_url->content = trim(revertTagSpace($request['content']));
//                    
                    $scraped_url->image = asset('userassets/images/Strains_fb_scrape.png');
                    if (strpos($request['url'], 'get-question-answers') !== false) {
                        $scraped_url->image = asset('userassets/images/q_a.png');
                    }
                    if (strpos(strtolower($url_data['url']), 'http') !== false) {
                        $extracted_url = $url_data['url'];
                    } else {
                        $extracted_url = 'http://' . $url_data['url'];
                    }
                    $scraped_url->extracted_url = $request['url'];
                    if (strpos(strtolower($request['url']), 'http') !== false) {
                        $url = $request['url'];
                    } elseif (strpos($request['url'], 'Http') !== false) {
                        $url = strtolower($request['url']);
                    }
                    $scraped_url->url = strtolower($url);
                    $scraped_url->save();
                }
            }
        }

        addActivity($this->userId, 'You added a post', 'You added a post', $user_post->description, 'Post', 'UserPost', $user_post->id, '', $user_post->description . ' <span style="display:none">' . $user_post->id . '</span>');
        return sendSuccess('Post shared successfully', '');
    }

    function commentLikeDislike(Request $request) {
        $validation = $this->validate($request, [
            'comment_id' => 'required',
            'is_like' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $add_post_like = UserPostCommentLike::where(['user_id' => $this->userId, 'comment_id' => $request['comment_id']])->first();
        if (!$add_post_like) {
            $add_post_like = new UserPostCommentLike;
        }
        $add_post_like->comment_id = $request['comment_id'];
        $add_post_like->user_id = $this->userId;
        $add_post_like->is_like = $request['is_like'];
        $add_post_like->save();
//        $retated_users = '';
        $comment = UserPostComment::find($request['comment_id']);
        if ($request['is_like'] == 1) {

            $unique_description = '';
            if ($comment->id) {
                $unique_description = $comment->comment . ' <span style="display:none">' . $comment->id . '_' . $comment->user_id . '</span>';
            }
            $heading = 'Post Comment Like';
            $message = 'You liked a comment';
            $notification_text = $this->userName . ' liked your comment.';
            $activity_type = 'Comment';
            $comment_message = $this->userName . ' liked your comment.';
            $data['post_id'] = (int) $comment->post_id;
            $url = asset('get-post/' . $comment->post_id);
            $data['type_id'] = (int) $comment->post_id;
            sendNotification($heading, $comment_message, $data, $comment->user_id, $url);
            $description = $comment->comment;
            addActivity($comment->user_id, $message, $notification_text, $description, $activity_type, 'UserPost', $comment->post_id, $comment->id, $unique_description);
        }
        $likes = UserPostCommentLike::where('id', $add_post_like->id)->with('user')->first();
        $likes->likes_count = 0;
        $likes->liked_count = 0;
        return sendSuccess('Post comment like saved successfully.', $likes);
    }

}
