<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
//Models
use App\User;
use App\Tag;
use App\SubUser;
use App\UserPost;
use App\UserPostAttachment;
use App\UserPostTaged;
use App\UserPostLike;
use App\UserPostComment;
use App\UserPostCommentAttachment;
use App\UserPostMute;
use App\UserPostFlag;
use App\UserPostScrape;
use App\UserFollow;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\UserActivity;
use App\UserPostCommentLike;

class PostController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $videos_path;
    private $posters_path;
    private $video_extentions;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $this->userId = Auth::user()->id;
                $this->user = Auth::user();
                $this->userName = Auth::user()->first_name;
            }
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

    function index() {
        echo 'sada';
    }

    function show(Request $request) {
//        echo '<pre>';
//        print_r($request->all());exit;
        if ($request->remove_session) {
            $request->session()->forget('is_register');
        }
        $data['title'] = 'Wall';
        $user_follows = UserFollow::where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
        $data['mention_budz'] = SubUser::select('title','id','logo')->where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['user_follows'] = UserFollow::where('user_id', $this->userId)->with('getUser')->get();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['subusers'] = SubUser::select('title','id','logo')->where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        return view('user.wall', $data);
        return Response::json(['data' => $data], 200);
    }

    function fetchPosts() {
        $user_follows = UserFollow::where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
        $data['mention_budz'] = SubUser::select('title','id','logo')->where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $filters = '';
        if (isset($_GET['filters'])) {
            $filters = $_GET['filters'];
        }
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
//        $user_follow[] = $this->userId;
//       
        $followed_post = UserPost::whereIn('user_id', $user_follow)
                ->orderBy('created_at', 'asc')->pluck('id')
                ->toArray();
        $followed_posts = implode(',', $followed_post);
        if ($followed_posts == '') {
            $followed_posts = 0;
        }
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['asd'] = $user_follow;
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['subusers'] = SubUser::select('title','id','logo')->where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        $data['posts'] = UserPost::
//                with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
//                ->whereIn('user_id', $user_follow)
                withCount('Liked', 'Comments', 'Likes', 'Shared', 'Flaged', 'MutePostByUser')
                ->whereDoesntHave('Flaged', function ($q) {
                    
                })->skip($_GET['skip'])
                ->take($_GET['take'])
                ->when($filters == "", function ($query) {
//                    return $query->orderBy('id', 'Desc');
                })
                ->when($filters == "Most Liked", function ($query) {
                    return $query->orderBy('likes_count', 'Desc')->orderBy('created_at', 'Desc');
                })
                ->when($filters == "Newest", function ($query) {
                    return $query->orderBy('created_at', 'Desc');
                })
                ->with(['Comments' => function($q) {
                        $q->orderBy('id', 'Desc');
//                        $q->take(5);
                    }])
                ->orderByRaw(DB::raw("FIELD(id, $followed_posts) desc"))
                ->orderBy('created_at', 'Desc')
                ->get();
//        print_r($data);
//        echo 'asdasdasdas';
        return view('user.includes.posts', $data);
//        return Response::json(['data' => $data], 200);
    }

    function getPostView($post_id) {
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        $data['post_id'] = $post_id;
        $data['title'] = 'Wall';
        $posts = UserPost::with(['Files' => function($q) {
                        $q->where('type', 'image');
                    }])->where('id', $post_id)->first();

        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        $data['og_image'] = asset('userassets/images/thebuzz.png');
        if ($posts->Files->count() > 0) {
            foreach ($posts->Files as $file) {
                if (exif_imagetype(asset('public/images' . $file->file)) == IMAGETYPE_PNG) {
                    $data['og_image'] = asset('public/images' . $file->file);
                }
            }
//            $data['og_image'] = asset('public/images' . $posts->Files[0]->file);
        }
        $data['og_title'] = $posts->description;
        $data['og_description'] = $posts->description;
        return view('user.wall-single-post', $data);
    }

    function getPost($post_id) {
        $user_follows = UserFollow::where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
        $data['mention_budz'] = SubUser::where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        $data['posts'] = UserPost::where('id', $post_id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->withCount('Liked', 'Shared', 'Flaged', 'Comments', 'MutePostByUser')
                ->get();
        return view('user.includes.posts', $data);
//        return Response::json(['data' => $data], 200);
    }

    public function savePost(Request $request) {
        $user_follows = UserFollow::where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
        $data['mention_budz'] = SubUser::where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $user_post = new UserPost;
        if ($request['post_id']) {
            $user_post = UserPost::find($request['post_id']);
            UserPostAttachment::where('post_id', $request['post_id'])->delete();

            UserPostTaged::where('post_id', $request['post_id'])->delete();
        }
        $user_post->user_id = $this->userId;
        $user_array = explode('_', $request['posting_user']);
        if ($user_array[0] == 's') {
            $user_post->sub_user_id = $user_array[1];
        }
        if ($request->description_data) {
            $description = json_decode($request->description_data);
        } else {
            $description = [];
        }
        $tags = Tag::where('is_approved', 1)->pluck('title')->toArray();
        $new_string_ = str_replace('<br />', ' __ ', $request['post_description']);
        $string_array = explode(' ', $new_string_);
        $new_string = '';
        foreach ($string_array as $string) {
            if (substr(trim($string), 0, 1) === '#') {
                $tag = Tag::where(['title' => str_replace('#', '', $string), 'is_approved' => 1])->first();
                if ($tag) {
                    $check_if_not = 0;
                    if ($description) {
                        foreach ($description as $check) {
                            if ($check->id == $tag->id) {
                                $check_if_not = 1;
                            }
                        }
                    }
                    if (!$check_if_not) {
                        $MyObject = new \stdClass();
                        $MyObject->id = $tag->id;
                        $MyObject->type = 'tag';
                        $MyObject->value = str_replace('#', '', $string);
                        $MyObject->trigger = '#';
                        $description[] = $MyObject;
                    }
                }
            }
            $key = in_array(strtolower(trim($string)), array_map('strtolower', $tags));
            if ($key) {
                $tag = Tag::where(['title' => $string, 'is_approved' => 1])->first();
                if ($tag) {
                    if ($new_string == '') {
                        $new_string = $new_string . "#$string" . ' ';
                    } else {
                        $new_string = $new_string . ' ' . "#$string";
                    }
                    $MyObject = new \stdClass();
                    $MyObject->id = $tag->id;
                    $MyObject->type = 'tag';
                    $MyObject->value = $string;
                    $MyObject->trigger = '#';
                    $description[] = $MyObject;
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } else {
                $new_string = $new_string . ' ' . $string;
            }
        }

        $description_to_add = str_replace('__', '<br />', $new_string);
        $user_post->description = trim(makeUrls(nl2br($description_to_add))) . ' ';
        $user_post->json_data = json_encode($description);
        $user_post->allow_repost = $request['repost_to_wall'];
        $user_post->save();

        //scraped url
        if ($request['scraped_title'] || $request['scraped_content']) {
            UserPostScrape::where('post_id', $user_post->id)->delete();
            $scraped_url = new UserPostScrape;
            $scraped_url->post_id = $user_post->id;
            $scraped_url->title = $request['scraped_title'];
            $scraped_url->content = $request['scraped_content'];
            $scraped_url->image = $request['scraped_image'];
            $scraped_url->extracted_url = $request['scraped_url'];
            $scraped_url->url = $request['site_url'];
            $scraped_url->save();
        }


        $image_attachments = json_decode($request['images']);
        if (count($image_attachments) > 0) {
            foreach ($image_attachments as $attachment) {
                $add_image = new UserPostAttachment();
                $add_image->post_id = $user_post->id;
                $add_image->user_id = $this->userId;
                $add_image->ratio = (string) $attachment->ratio;
                $add_image->file = '/posts/' . $attachment->file_name;
                $add_image->thumnail = '/posts/thumnails/' . $attachment->resize_name;
                $add_image->type = 'image';
                $add_image->save();
                if (!$request['post_id']) {
                    addHbMedia('/posts/' . $attachment->file_name);
                }
            }
        }

        $video_attachments = json_decode($request['video']);
        if (count($video_attachments) > 0) {
            foreach ($video_attachments as $attachment) {
                $add_video = new UserPostAttachment();
                $add_video->post_id = $user_post->id;
//                $add_video->original_name = $attachment->original_name;
                $add_video->file = '/posts/' . $attachment->file_name;
                $add_video->user_id = $this->userId;
                $add_video->poster = '/posts/posters/' . $attachment->poster;
                $add_video->thumnail = '/posts/posters/thumnails/' . $attachment->resize_poster;
                $add_video->type = 'video';
                $add_video->save();
                if (!$request['post_id']) {
                    addHbMedia('/posts/' . $attachment->file_name, 'video', '/posts/posters/' . $attachment->poster);
                }
            }
        }

        $tagged_users = json_decode($request['tagged_users']);
        if (count($tagged_users) > 0) {
            $heading = 'Post Added';
            $message = ' tagged you in the post.';
            $notification_text = 'You added a post';
            $activity_type = 'Post';
            $sub_type_id = null;
            $this->sendPostNotification($tagged_users, $user_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);

            foreach ($tagged_users as $id) {
                $tagged = new UserPostTaged;
                $tagged->post_id = $user_post->id;
                $tagged->user_id = $id;
                $tagged->save();
            }
        }

        //send notification to users who are tagged in post description
        $tagged_users = [];
        if ($request['description_data']) {
            $description_tagged = json_decode($request['description_data']);
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
                $this->sendPostNotification($tagged_users, $user_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);
            }
        }
        addActivity($this->userId, 'You added a post', 'You added a post', $user_post->description, 'Post', 'UserPost', $user_post->id, '', $user_post->description . ' <span style="display:none">' . $user_post->id . '</span>');
//        $data['post'] = UserPost::where('id', $user_post->id)->with('Files', 'Tagged', 'Likes', 'Comments')->first();
        $data['posts'] = UserPost::where('id', $user_post->id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->withCount('Liked', 'Flaged', 'Comments', 'MutePostByUser')
                ->get();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        $user_follow = UserFollow::select('followed_id')->where('user_id', $this->userId)->pluck('followed_id')->toArray();
        $data['followers'] = User::whereIn('id', $user_follow)->get()->toJson();
        return view('user.includes.posts', $data);
//        return Response::json(['data' => $tagged_users], 200);
    }

    function deletePost() {

        if (UserPost::where(['id' => $_GET['post_id'], 'user_id' => $this->userId])->delete()) {
            $ids = UserPost::select('id')->where(['shared_id' => $_GET['post_id']])->get()->toArray();
            UserPost::where(['shared_id' => $_GET['post_id']])->delete(); //delete shared posts
            UserActivity::whereIn('type_id', $ids)->where('model', 'UserPost')->delete();
            removePostActivity($_GET['post_id']); //remove activity log
            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function likePost(Request $request) {
        $post_like = UserPostLike::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_like) {
            $post_like = new UserPostLike;
        }
        $post_like->post_id = $request['post_id'];
        $post_like->user_id = $this->userId;
        $post_like->is_like = $request['is_like'];
        if ($post_like->save()) {
            $retated_users = '';
            if ($request['is_like'] == 1) {
                $retated_users = $this->getPostRelatedUsers($request['post_id']);
                $retated_users = array_unique($retated_users);
                $heading = 'Post Liked';
                $message = ' liked the post.';
                $notification_text = 'You Liked post';
                $activity_type = 'Likes';
                $sub_type_id = $post_like->id;
                $this->sendPostNotification($retated_users, $request['post_id'], $heading, $message, $notification_text, $activity_type, $sub_type_id);
            }
            $likes_count = UserPostLike::where(['post_id' => $request['post_id'], 'is_like' => 1])->count();
            return Response::json(['message' => 'success',
                        'likes_count' => $likes_count,
                        'retated_users' => $retated_users,
                        'mute_users' => UserPostMute::where(['post_id' => $request['post_id'], 'is_mute' => 1])->pluck('user_id')->toArray()
                            ], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function mutePost(Request $request) {
        $post_mute = UserPostMute::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_mute) {
            $post_mute = new UserPostMute;
        }
        $post_mute->post_id = $request['post_id'];
        $post_mute->user_id = $this->userId;
        $post_mute->is_mute = $request['is_mute'];
        if ($post_mute->save()) {

            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function reportPost(Request $request) {
        $post_flag = UserPostFlag::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_flag) {
            $post_flag = new UserPostFlag;
        }
        $post_flag->post_id = $request['post_id'];
        $post_flag->user_id = $this->userId;
        $post_flag->reason = $request['reason'];
        if ($post_flag->save()) {

            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function editPost($post_id) {
//        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['user_follows'] = UserFollow::where('user_id', $this->userId)->with('getUser')->get();
        $data['users'] = User::where('id', '!=', $this->userId)->get()->toJson();
        $data['mention_budz'] = SubUser::where('business_type_id', '!=', '')->where('is_blocked', 0)->get()->toJson();
        $data['tags'] = Tag::where('is_approved', 1)->get()->toJson();
        $data['subusers'] = SubUser::where('user_id', $this->userId)->where('is_blocked', 0)->where('business_type_id', '!=', '')->get();
        $data['post'] = UserPost::where('id', $post_id)
                ->with('user', 'SubUser', 'SharedPost', 'SharedUser', 'Files', 'Tagged', 'Likes', 'Flags', 'Comments', 'Comments.User', 'Comments.Attachment', 'scrapedUrl')
                ->withCount('Liked', 'Flaged', 'Comments', 'MutePostByUser')
                ->first();
        return view('user.post-edit', $data);
        return Response::json(['data' => $data], 200);
    }

    public function getPostImages($post_id) {
        $images = UserPostAttachment::where(['post_id' => $post_id, 'type' => 'image'])->get();
        $imageAnswer = [];
        if ($images) {
            foreach ($images as $image) {
                $file = explode('/', $image->file);
                $thumnail = explode('/', $image->thumnail);
                $imageAnswer[] = [
                    'ratio' => $image->ratio,
                    'server' => $file[2],
                    'path' => asset('public/images/' . $image->file),
                    'thumnail' => $thumnail[3],
                    'thumnail_path' => asset('public/images/' . $image->thumnail),
                    'size' => File::size('public/images' . $image->file)
                ];
            }
        }

        return response()->json([
                    'images' => $imageAnswer
        ]);
    }

    public function getPostVideo($post_id) {
        $videos = UserPostAttachment::where(['post_id' => $post_id, 'type' => 'video'])->get();
        $imageAnswer = [];
        if ($videos) {
//            $file = explode('/', $videos[0]->poster);
//            print_r($file);
//            exit();
            foreach ($videos as $video) {
                $file = explode('/', $video->file);
                $poster = explode('/', $video->poster);
                $poster_thumnail = explode('/', $video->thumnail);
                $imageAnswer[] = [
//                    'original' => $video->original_name,
                    'server' => $file[2],
                    'poster_path' => asset('public/images' . $video->thumnail),
                    'poster_name' => $poster[3],
                    'poster_thumnail' => $poster_thumnail[4],
                    'size' => File::size('public/videos/' . $video->file)
                ];
            }
        }

        return response()->json([
                    'videos' => $imageAnswer
        ]);
    }

    public function addImage(Request $request) {
        $photos = $request->file('file');
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }
        for ($i = 0; $i < count($photos); $i++) {
            $file = $photos[$i];
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
            }
        }
        return Response::json([
                    'message' => 'Image saved Successfully',
                    'file_name' => $save_name,
                    'resize_name' => $resize_name,
                    'ratio' => $ratio,
                    'type' => 'image',
                    'thumnail_path' => asset(image_fix_orientation($this->photos_path . '/thumnails/' . $resize_name))
                        ], 200);
    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function deleteImage(Request $request) {
        $file_name = $request->file_name;
        $file_type = $request->file_type;

        $file_path = $this->photos_path . '/' . $file_name;
//        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;
//        if (file_exists($file_path)) {
//            unlink($file_path);
//        }
//        if (file_exists($resized_file)) {
//            unlink($resized_file);
//        }


        return Response::json(['message' => 'File successfully delete'], 200);
    }

    public function addVideo(Request $request) {
        $photos = $request->file('file');
//        return Response::json(['images' => $photos], 200);

        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (!is_dir($this->videos_path)) {
            mkdir($this->videos_path, 0777);
        }
        if (!is_dir($this->posters_path)) {
            mkdir($this->posters_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $file = $photos[$i];
            $save_name = '';
            $poster_name = '';
            $resize_poster = '';
//            $original_name = '';
            $poster = '';
            $info[0] = '';
            $extension = strtolower($file->getClientOriginalExtension());
            if ($extension != 'exe') {
                if (in_array($extension, $this->video_extentions)) {

                    $name = 'video_' . str_random(10);
                    $save_name = $name . '.' . 'mp4'; // renameing image
                    $video = $this->videos_path . $save_name;
                    $filePath = $file->getRealPath();
                    exec("ffmpeg -i $filePath -strict -2 $video 2>&1", $result, $status);
//                    return Response::json([
//                            'status' => $status,
//                        'result' => $result,
//                                ], 200);
                    if ($status === 0) {

                        $info = $this->getVideoInformation($result);
                        $poster_name = explode('.', $save_name)[0] . '.jpg';
                        $poster = $this->posters_path . $poster_name;
                        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");

                        $resize_poster = 'thum_' . $poster_name;
                        Image::make($poster)
                                ->resize(200, null, function ($constraints) {
                                    $constraints->aspectRatio();
                                })->orientate()
                                ->save($this->posters_path . 'thumnails/' . $resize_poster);
//                        $original_name = basename($file->getClientOriginalName());
                    } else {
                        $poster_name = '';
                        $resize_poster = '';
                    }
                }
            }
        }
        return Response::json([
                    'message' => 'Video saved Successfully',
                    'file_name' => $save_name,
//                    'original_name' => $original_name,
                    'poster_name' => $poster_name,
                    'poster_path' => asset($poster),
                    'resize_poster' => $resize_poster,
                    'resize_poster_path' => asset(image_fix_orientation($this->posters_path . 'thumnails/' . $resize_poster)),
                    'type' => 'video',
                    'duration' => $info[0]
                        ], 200);
    }

    public function deleteVideo(Request $request) {
        $file_name = $request->file_name;
        $poster_name = $request->poster_name;
        $file_type = $request->file_type;

        $file_path = $this->videos_path . $file_name;
        $poster = $this->posters_path . $poster_name;

//        if (file_exists($file_path)) {
//            unlink($file_path);
//        }
//
//        if (file_exists($poster)) {
//            unlink($poster);
//        }
        return Response::json(['message' => 'File successfully delete'], 200);
    }

    public function saveComment(Request $request) {
        $user_comment = new UserPostComment;
        if (isset($request['comment_id']) && $request['comment_id'] != '') {
            $user_comment = UserPostComment::find($request['comment_id']);
            UserPostCommentAttachment::where('comment_id', $user_comment->id)->delete();
        }

        if ($request->description_data) {
            $description = json_decode($request->description_data);
        } else {
            $description = [];
        }
        $tags = Tag::where('is_approved', 1)->pluck('title')->toArray();
        $new_string_ = str_replace('<br />', ' __ ', $request['comment']);
        $string_array = explode(' ', $new_string_);
        $new_string = '';
        foreach ($string_array as $string) {
            $tag = Tag::where(['title' => str_replace('#', '', $string), 'is_approved' => 1])->first();
            if ($tag) {
                $check_if_not = 0;
                if ($description) {
                    foreach ($description as $check) {
                        if ($check->id == $tag->id) {
                            $check_if_not = 1;
                        }
                    }
                }
                if (!$check_if_not) {
                    $MyObject = new \stdClass();
                    $MyObject->id = $tag->id;
                    $MyObject->type = 'tag';
                    $MyObject->value = str_replace('#', '', $string);
                    $MyObject->trigger = '#';
                    $description[] = $MyObject;
                }
            }
            $key = in_array(strtolower(trim($string)), array_map('strtolower', $tags));
            if ($key) {
                $tag = Tag::where(['title' => $string, 'is_approved' => 1])->first();
                if ($tag) {
                    if ($new_string == '') {
                        $new_string = $new_string . "#$string" . ' ';
                    } else {
                        $new_string = $new_string . ' ' . "#$string";
                    }
                    $MyObject = new \stdClass();
                    $MyObject->id = $tag->id;
                    $MyObject->type = 'tag';
                    $MyObject->value = $string;
                    $MyObject->trigger = '#';
                    $description[] = $MyObject;
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } else {
                $new_string = $new_string . ' ' . $string;
            }
        }
        $description_to_add = str_replace('__', '<br />', $new_string);

        $user_comment->user_id = $this->userId;
        $user_comment->post_id = $request['post_id'];
//        $user_comment->comment = $request['comment'];
        $user_comment->comment = trim(makeUrls(nl2br($description_to_add)));
        $user_comment->json_data = json_encode($description);
        if ($request['comment_id']) {
            $user_comment->updated_at = Carbon::now();
        }
        $user_comment->save();

        $image_attachments = json_decode($request['images']);
        if (count($image_attachments) > 0) {
            foreach ($image_attachments as $attachment) {
                $add_image = UserPostCommentAttachment::where(['comment_id' => $user_comment->id, 'user_id' => $this->userId])->first();
                if (!$add_image) {
                    $add_image = new UserPostCommentAttachment();
                }

                $add_image->comment_id = $user_comment->id;
                $add_image->user_id = $this->userId;
                $add_image->file = '/posts/' . $attachment->file_name;
                $add_image->thumnail = '/posts/thumnails/' . $attachment->resize_name;
                $add_image->type = 'image';
                $add_image->save();
            }
        }

        $video_attachments = json_decode($request['video']);
        if (count($video_attachments) > 0) {
            foreach ($video_attachments as $attachment) {
                $add_video = UserPostCommentAttachment::where(['comment_id' => $user_comment->id, 'user_id' => $this->userId])->first();
                if (!$add_video) {
                    $add_video = new UserPostCommentAttachment();
                }
                $add_video->comment_id = $user_comment->id;
                $add_video->user_id = $this->userId;
                $add_video->file = '/posts/' . $attachment->file_name;
                $add_video->poster = '/posts/posters/' . $attachment->poster;
                $add_video->thumnail = '/posts/posters/thumnails/' . $attachment->resize_poster;
                $add_video->type = 'video';
                $add_video->save();
            }
        }
        $data['current_id'] = $this->userId;
        $data['comments'] = UserPostComment::where('id', $user_comment->id)->with('Attachment')->get();
        $data['comments_count'] = UserPostComment::where('post_id', $request['post_id'])->count();
        $data['add_edit'] = 1;
        $data['post'] = UserPost::find($request['post_id']);
        return view('user.includes.post_comments', $data);
//        return Response::json(['data' => $user_comment], 200);
    }

    function deleteComment() {
        $post_id = UserPostComment::where(['id' => $_GET['comment_id'], 'user_id' => $this->userId])->pluck('post_id')->toArray();
        if (UserPostComment::where(['id' => $_GET['comment_id'], 'user_id' => $this->userId])->delete()) {

            //Delete Entry from User Activity Log
            $type_id = $post_id;
            $type_sub_id = $_GET['comment_id'];
            removePostCommentActivity($type_id, $type_sub_id);
            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    public function getCommentImages($comment_id) {
        $images = UserPostCommentAttachment::where(['comment_id' => $comment_id, 'type' => 'image'])->get();
        $imageAnswer = [];
        if ($images) {
            foreach ($images as $image) {
                $file = explode('/', $image->file);
                $thumnail = explode('/', $image->thumnail);
                $imageAnswer[] = [
//                    'original' => $image->original_name,
                    'server' => $file[2],
                    'path' => asset('public/images/' . $image->file),
                    'thumnail' => $thumnail[3],
                    'thumnail_path' => asset('public/images/' . $image->thumnail),
                    'size' => File::size('public/images' . $image->file)
                ];
            }
        }

        return response()->json([
                    'images' => $imageAnswer
        ]);
    }

    public function getCommentVideo($comment_id) {
        $videos = UserPostCommentAttachment::where(['comment_id' => $comment_id, 'type' => 'video'])->get();
        $imageAnswer = [];
        if ($videos) {
//            $file = explode('/', $videos[0]->poster);
//            print_r($file);
//            exit();
            foreach ($videos as $video) {
                $file = explode('/', $video->file);
                $poster = explode('/', $video->poster);
                $poster_thumnail = explode('/', $video->thumnail);
                $imageAnswer[] = [
//                    'original' => $video->original_name,
                    'server' => $file[2],
                    'poster_path' => asset('public/images' . $video->thumnail),
                    'poster_name' => $poster[3],
                    'poster_thumnail' => $poster_thumnail[4],
                    'size' => File::size('public/videos/' . $video->file)
                ];
            }
        }

        return response()->json([
                    'videos' => $imageAnswer
        ]);
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

        return Response::json(['response' => 'success', 'retated_users' => $retated_users], 200);
    }

    public function getComments() {

        $data['comments'] = UserPostComment::where('post_id', $_GET['post_id'])->with('Attachment')
                ->skip($_GET['skip'])
                ->take($_GET['take'])
                ->orderBy('id', 'Desc')
                ->get();
        $data['post'] = UserPost::find($_GET['post_id']);
        $data['current_id'] = $this->userId;
        $data['comments_count'] = UserPostComment::where('post_id', $_GET['post_id'])->count();
        return view('user.includes.post_comments', $data);
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

    public function sendPostNotification($users, $post_id, $heading, $message, $notification_text, $activity_type, $sub_type_id) {
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

    public function repost(Request $request) {
//        print_r($request['tagged_users']);
//        exit();

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
        $new_post->post_added_comment = $request->post_added_comment;
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
            $this->sendPostNotification([$shared_user_id], $new_post->id, $heading, $message, $notification_text, $activity_type, $sub_type_id);
        }
        $tagged_users = ($request['tagged_users']);
        if (($tagged_users)) {
            if (count($tagged_users) > 0) {
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
        }
        echo TRUE;
    }

    public function scrapeUrl(Request $request) {
        if (!empty($request->url) && filter_var($request->url, FILTER_VALIDATE_URL)) {
            $get_url = $request->url;

            $parse = parse_url($get_url);
            $url = $parse['host'];

            //get URL content
            $get_content = HtmlDomParser::file_get_html($request->url);
            if (!$get_content) {
                return Response::json([FALSE], 200);
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

            if (!$page_body) {


                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('name') == 'description') {
                        $page_body = $meta->getAttribute('content');

                        //return $page_body;
                    } elseif ($meta->getAttribute('property') == 'description') {
                        $page_body = $meta->getAttribute('content');

                        //return $page_body;
                    } elseif ($meta->getAttribute('name') == 'og:description') {
                        $page_body = $meta->getAttribute('content');
                        //return $page_body;
                    }
                }
                if (count($get_content->find('body')) > 0 && !$page_body) {
                    foreach ($get_content->find('body') as $element) {
                        $page_body = trim($element->plaintext);
                        if ($page_body) {
                            $pos = strpos($page_body, ' ', 200); //Find the numeric position to substract
                            $page_body = substr($page_body, 0, $pos); //shorten text to 200 chars
                        }
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
            return json_encode($output); //output JSON data
        } else {
            return Response::json([FALSE], 200);
        }
    }

    function addSharedUrlPost(Request $request) {
        $user_post = new UserPost;
        $user_post->user_id = $this->userId;
        $tags = Tag::where('is_approved', 1)->pluck('title')->toArray();
        $new_string_ = str_replace('<br />', ' __ ', $request['post_description']);
        $string_array = explode(' ', $new_string_);
        $new_string = '';
        $description = [];
        foreach ($string_array as $string) {
            if (substr(trim($string), 0, 1) === '#') {
                $tag = Tag::where(['title' => str_replace('#', '', $string), 'is_approved' => 1])->first();
                if ($tag) {
                    $MyObject = new \stdClass();
                    $MyObject->id = $tag->id;
                    $MyObject->type = 'tag';
                    $MyObject->value = str_replace('#', '', $string);
                    $MyObject->trigger = '#';
                    $description[] = $MyObject;
                }
            }
            $key = in_array(strtolower(trim($string)), array_map('strtolower', $tags));
            if ($key) {
                $tag = Tag::where(['title' => $string, 'is_approved' => 1])->first();
                if ($tag) {
                    if ($new_string == '') {
                        $new_string = $new_string . "#$string" . ' ';
                    } else {
                        $new_string = $new_string . ' ' . "#$string";
                    }
                    $MyObject = new \stdClass();
                    $MyObject->id = $tag->id;
                    $MyObject->type = 'tag';
                    $MyObject->value = $string;
                    $MyObject->trigger = '#';
                    $description[] = $MyObject;
                } else {
                    $new_string = $new_string . ' ' . $string;
                }
            } else {
                $new_string = $new_string . ' ' . $string;
            }
        }
        $description_to_add = str_replace('__', '<br />', $new_string);
        $user_post->description = $request['scraped_url'] . ' ';
        $user_post->json_data = json_encode($description);
        $user_post->allow_repost = 1;
        $user_post->save();
        //scraped url
        if ($request['scraped_title'] || $request['scraped_content']) {
            $scraped_url = new UserPostScrape;
            $scraped_url->post_id = $user_post->id;
            $scraped_url->title = $request['scraped_title'];
            $scraped_url->content = $request['scraped_content'];
            $scraped_url->image = $request['scraped_image'];
            $scraped_url->extracted_url = $request['scraped_url'];
            $scraped_url->url = $request['site_url'];
            $scraped_url->save();
        }

        addActivity($this->userId, 'You added a post', 'You added a post', $user_post->description, 'Post', 'UserPost', $user_post->id, '', $user_post->description . ' <span style="display:none">' . $user_post->id . '</span>');
        echo TRUE;
    }

    function likeComment(Request $request) {
        $post_like = UserPostCommentLike::where(['comment_id' => $request['comment_id'], 'user_id' => $this->userId])->first();
        if (!$post_like) {
            $post_like = new UserPostCommentLike;
        }
        $post_like->comment_id = $request['comment_id'];
        $post_like->user_id = $this->userId;
        $post_like->is_like = $request['is_like'];
        if ($post_like->save()) {
            $retated_users = '';
$comment = UserPostComment::find($request['comment_id']);
            if ($request['is_like'] == 1) {
                
                $unique_description = '';
                if ($comment->id) {
                    $unique_description = $comment->comment . ' <span style="display:none">' . $comment->id . '_' . $comment->user_id . '</span>';
                }
                $heading = 'Post Comment Like';
                $message = 'You liked a comment';
                $notification_text = $this->userName.' liked your comment.';
                $activity_type = 'Comment';

                $comment_message = $this->userName . ' liked your comment.';
                $data['post_id'] = (int) $comment->post_id;
                $url = asset('get-post/' . $comment->post_id);
                $data['type_id'] = (int) $comment->post_id;
                sendNotification($heading, $comment_message, $data, $comment->user_id, $url);
                $description = $comment->comment;;
                addActivity($comment->user_id, $message, $notification_text, $description, $activity_type, 'UserPost', $comment->post_id, $comment->id, $unique_description);
            }
            $likes_count = UserPostCommentLike::where(['comment_id' => $request['comment_id'], 'is_like' => 1])->count();
            return Response::json(['message' => 'success',
                        'likes_count' => $likes_count,
                        'retated_users' => $retated_users,
                        'mute_users' => UserPostMute::where(['post_id' => $request['post_id'], 'is_mute' => 1])->pluck('user_id')->toArray()
                            ], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

}
