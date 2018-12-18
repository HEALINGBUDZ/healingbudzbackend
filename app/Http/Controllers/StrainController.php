<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
//Models
use App\User;
use App\Strain;
use App\StrainReview;
use App\StrainRating;
use App\StrainReviewImage;
use App\StrainLike;
use App\UserStrain;
use App\UserStrainLike;
use App\StrainSurveyQuestion;
use App\StrainSurveyAnswer;
use App\MedicalConditions;
use App\Sensation;
use App\NegativeEffect;
use App\DiseasePrevention;
use App\Flavor;
use App\StrainImage;
use App\VTopSurveyAnswer;
use App\SubUser;
use App\StrainReviewFlag;
use App\StrainImageLikeDislike;
use App\StrainImageFlag;
use App\UserPoint;
use App\VGetMySave;
use App\UserRewardStatus;
use App\VSurveyCount;
use App\VProduct;
use App\Jobs\SendNotification;
use Carbon\Carbon;
use App\StrainReviewLike;

class StrainController extends Controller {

    private $userId;
    private $userName;
    private $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getStrains() {
        $user_id = $this->userId;
        $strains = Strain::with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->where('approved', 1)
                ->orderBy('created_at', 'desc')
                ->with(['getImages' => function($query) {
//                    flagged
                $query->whereDoesntHave('flagged', function ($q) {
                            
                        });
//                        $query->where('is_approved', 1);
                $query->where(function($q) {
                            $q->where('is_approved', 1)
                            ->orwhere('user_id', $this->userId);
                        });
                $query->withCount('likeCount');
                $query->orderBy('like_count_count', 'desc');
                $query->orderBy('is_main', 'desc');
                $query->orderBy('created_at', 'asc');
            }]);
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10; //page number start from 0;
            $strains->take(10);
            $strains->skip($skip);
        }
        $data['strains'] = $strains->get();

        $data['madical_condition_answers'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensation_answers'] = Sensation::where('is_approved', 1)->get();
        $data['negative_effect_answers'] = NegativeEffect::where('is_approved', 1)->get();
        $data['prevention_answers'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['survey_flavor_answers'] = Flavor::where('is_approved', 1)->get();

        return sendSuccess('', $data);
    }

    function getStrain($id) {
        $strain = Strain::with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->where('approved', 1)
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->orderBy('created_at', 'desc')
                ->where('id', $id)
                ->first();
        return sendSuccess('', $strain);
    }

    function getStrainsAlphabitically() {
        $strains = Strain::with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->where('approved', 1)
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
//                        $query->where('is_approved', 1);
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->orderBy('title', 'asc');
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10; //page number start from 0;
            $strains->take(10);
            $strains->skip($skip);
        }
        $data['strains'] = $strains->get();
        $data['madical_condition_answers'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensation_answers'] = Sensation::where('is_approved', 1)->get();
        $data['negative_effect_answers'] = NegativeEffect::where('is_approved', 1)->get();
        $data['prevention_answers'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['survey_flavor_answers'] = Flavor::where('is_approved', 1)->get();
        return sendSuccess('', $data);
    }

    function getStrainsByType($type_id) {
        $strains = Strain::with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->where('approved', 1)
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
//                        $query->where('is_approved', 1);
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->where('type_id', $type_id)
                ->orderBy('title', 'asc')
                ->orderBy('created_at', 'desc');
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10; //page number start from 0;
            $strains->take(10);
            $strains->skip($skip);
        }
        $data['strains'] = $strains->get();

        return sendSuccess('', $data);
    }

    function searchStrainByName() {

        $strains = Strain::where('title', 'like', '%' . $_GET['name'] . '%')
                ->with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->orderBy('created_at', 'desc')
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
//                        $query->where('is_approved', 1);
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->where('approved', 1);
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10; //page number start from 0;
            $strains->take(10);
            $strains->skip($skip);
        }
        $data['strains'] = $strains->get();
        return sendSuccess('', $data);
    }

    function getStrainDetail($strain_id) {
//        $data['count'] = StrainSurveyAnswer::where('strain_id',$strain_id)->groupBy('question_id','user_id')->count();
        $data['strain'] = Strain::with('getType', 'ratingSum', 'getReview', 'getReview.getUser', 'getReview.rating', 'getReview.attachment', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                ->with(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($q) {
                                    $q->where('flaged_by', $this->userId);
                                    $q->where('is_flaged', 1);
                                });
                        $q->withCount('isUserFlaged');
                        $q->withCount('isReviewed');
                        $q->withCount('likes');
                    }])
                ->withCount('getStrainSurveyUser', 'getUserReview', 'getUserFlag', 'getLikes', 'getDislikes', 'isSaved', 'getUserLike', 'getUserDislike')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->with(['getStrainSurveys' => function($query) use($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->groupBy('user_id');
                    }])
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
//                        $query->where('is_approved', 1);
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->where('id', $strain_id)
                ->first();
        $data['survey_budz_count'] = (int) VSurveyCount::where(['strain_id' => $strain_id])->count();

        $data['madical_conditions'] = getSurveyAnswers($strain_id, 1, 'm_condition', 'm_id');
        $data['sensations'] = getSurveyAnswers($strain_id, 2, 'sensation', 's_id');
        $data['negative_effects'] = getSurveyAnswers($strain_id, 3, 'n_effect', 'n_id');
        $data['preventions'] = getSurveyAnswers($strain_id, 5, 'prevention', 'p_id');
        $data['survey_flavors'] = getSurveyAnswers($strain_id, 6, 'flavor', 'f_id');

        $data['madical_condition_answers'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensation_answers'] = Sensation::where('is_approved', 1)->get();
        $data['negative_effect_answers'] = NegativeEffect::where('is_approved', 1)->get();
        $data['prevention_answers'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['survey_flavor_answers'] = Flavor::where('is_approved', 1)->get();

        $data['top_strain'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser')
                ->where('strain_id', $strain_id)
                ->orderBy('get_likes_count', 'desc')
                ->orderBy('id', 'desc')
                ->first();

        return sendSuccess('', $data);
    }

    function getStrainDetailByName($name) {
        $strain = Strain::select('id')->where('title', $name)->first();
        if ($strain) {
            $strain_id = $strain->id;
            $strain = Strain::with('getType', 'ratingSum', 'getImages.getUser', 'getImages.likeCount', 'getImages.disLikeCount', 'getImages.liked', 'getImages.disliked', 'getImages.flagged')
                    ->withCount('getLikes', 'getDislikes', 'getUserLike', 'getUserDislike', 'getUserFlag', 'isSaved')
                    ->withCount(['getReview' => function($q) {
                            $q->whereDoesntHave('flags', function ($query) {
                                        $query->where('flaged_by', $this->userId);
                                    });
                        }])->where('approved', 1)
                    ->with(['getImages' => function($query) {
//                    flagged
                            $query->whereDoesntHave('flagged', function ($q) {
                                        
                                    });
//                        $query->where('is_approved', 1);
                            $query->where(function($q) {
                                        $q->where('is_approved', 1)
                                        ->orwhere('user_id', $this->userId);
                                    });
                            $query->withCount('likeCount');
                            $query->orderBy('like_count_count', 'desc');
                            $query->orderBy('is_main', 'desc');
                            $query->orderBy('created_at', 'asc');
                        }])
                    ->orderBy('created_at', 'desc')
                    ->where('id', $strain_id)
                    ->first();
            return sendSuccess('', $strain);
        }
        return sendError('invalid strain name', 410);
    }

    function saveStrainImage(Request $request) {

        $validation = $this->validate($request, [
            'strain_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        if ($request['image']) {

            $strain_image = new StrainImage();
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/strain_images', $photo_name);
            $strain_image->image_path = '/strain_images/' . $photo_name;
            $strain_image->strain_id = $request['strain_id'];
            $strain_image->user_id = $this->userId;
            $strain_image->save();
            addHbMedia($strain_image->image_path);
            return sendSuccess('Image uploaded successfully.', $strain_image);
        }
        return sendError('Provide image', 403);
    }

//    function addStrainRating(Request $request){
//        $validation = $this->validate($request, [
//            'strain_id' => 'required',
//            'rating'  => 'required'
//        ]);
//        if ($validation) {
//            return sendError($validation, 400);
//        }
//        
//        $strain_rating = new StrainRating();
//        $strain_rating->strain_id = $request['strain_id'];
//        $strain_rating->user_id = Auth::user()->id;
//        $strain_rating->rating = $request['rating'];
//        $strain_rating->save();
//        
//        return Response::json(array('status' => 'success', 'successData' => $strain_rating, 'successMessage' => 'Rating added successfully.'));
//    }


    function addReview(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'review' => 'required',
            'rating' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;

        $add_review = new StrainReview;
        if (isset($request['strain_review_id'])) {
            $add_review = StrainReview::where('id', $request['strain_review_id'])->first();
        } else {
            $check_review = StrainReview::where('reviewed_by', $user_id)->where('strain_id', $request['strain_id'])->first();
            if ($check_review) {
                return sendError('Review Already Added', 402);
            }
        }

        $add_review->strain_id = $request['strain_id'];
        $add_review->reviewed_by = $user_id;
        $review = getTaged($request['review'], 'f4c42f');
        $add_review->review = $review;
        $add_review->save();
        if (isset($request['delete_attachment'])) {
            if (isset($request['strain_review_id'])) {
                StrainReviewImage::where('strain_review_id', $request['strain_review_id'])->delete();
            }
        }

        if ($request['image']) {
            $validation = $this->validate($request, [
                'image' => 'image'
            ]);
            if ($validation) {
                return sendError($validation, 400);
            }
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/reviews', $photo_name);

            if (isset($request['strain_review_id'])) {
                StrainReviewImage::where('strain_review_id', $request['strain_review_id'])->delete();
            }
            $add_att = new StrainReviewImage;
            $add_att->strain_id = $request['strain_id'];
            $add_att->user_id = $user_id;
            $add_att->strain_review_id = $add_review->id;
            $add_att->attachment = '/reviews/' . $photo_name;
            $add_att->type = 'image';
            $add_att->save();
            if (!isset($request['strain_review_id']) || !$request['strain_review_id']) {
                addHbMedia($add_att->attachment);
            }
        }

        if ($request['video']) {
            $video = $request['video'];
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
                $video_destinationPath = base_path('public/videos/strain_reviews'); // upload path
                $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
                $fileDestination = $video_destinationPath . '/' . $video_fileName;
                $filePath = $video->getRealPath();
                exec("ffmpeg -i $filePath -strict -2 $fileDestination 2>&1", $result, $status);
                if ($status === 0) {
                    $info = getVideoInformation($result);
                    $poster_name = explode('.', $video_fileName)[0] . '.jpg';
                    $poster = 'public/images/strain_review/posters/' . $poster_name;
                    exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
                } else {
                    return sendError('Sorry Some Thing wnet wrong', 419);
                }
                $data['path'] = '/strain_reviews/' . $video_fileName;
                $data['poster'] = '/strain_review/posters/' . $poster_name;

                if (isset($request['strain_review_id'])) {
                    StrainReviewImage::where('strain_review_id', $request['strain_review_id'])->delete();
                }

                $add_att = new StrainReviewImage;
                $add_att->strain_id = $request['strain_id'];
                $add_att->user_id = $user_id;
                $add_att->strain_review_id = $add_review->id;
                $add_att->attachment = $data['path'];
                $add_att->type = 'video';
                $add_att->poster = $data['poster'];
                $add_att->save();
                if (!isset($request['strain_review_id']) || !$request['strain_review_id']) {
                    addHbMedia($add_attchment->attachment, 'video', $add_attchment->poster);
                }
            }
        }


//        if(isset($request['rating']) && $request['rating']){
        $add_rating = new StrainRating;

        if (isset($request['strain_review_id'])) {
            $add_rating = StrainRating::where(['strain_id' => $request['strain_id'], 'strain_review_id' => $request['strain_review_id']])->first();
        }

        $add_rating->strain_id = $request['strain_id'];
        $add_rating->strain_review_id = $add_review->id;
        $add_rating->rated_by = $user_id;
        $add_rating->rating = $request['rating'];
        $add_rating->save();
//        }


        $data['review'] = $add_review = StrainReview::where('id', $add_review->id)->with('rating', 'attachment')->first();
        $strain_id = $request['strain_id'];
        $data['strain'] = Strain::with('getType', 'ratingSum', 'getReview', 'getReview.getUser', 'getReview.rating', 'getReview.attachment')
                ->with(['getReview' => function($q) {
                        $q->withCount('isUserFlaged');
                        $q->withCount('isReviewed');
                    }])
                ->withCount('getUserReview', 'getLikes', 'getDislikes', 'isSaved')
                ->withCount(['getReview' => function($q) {
                        $q->whereDoesntHave('flags', function ($query) {
                                    $query->where('flaged_by', $this->userId);
                                });
                    }])->with(['getStrainSurveys' => function($query) use($strain_id) {
                        $query->where('strain_id', $strain_id);
                        $query->groupBy('user_id');
                    }])
                ->with(['getImages' => function($query) {
//                    flagged
                        $query->whereDoesntHave('flagged', function ($q) {
                                    
                                });
//                        $query->where('is_approved', 1);
                        $query->where(function($q) {
                                    $q->where('is_approved', 1)
                                    ->orwhere('user_id', $this->userId);
                                });
                        $query->withCount('likeCount');
                        $query->orderBy('like_count_count', 'desc');
                        $query->orderBy('is_main', 'desc');
                        $query->orderBy('created_at', 'asc');
                    }])
                ->where('id', $strain_id)
                ->first();
        $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $request->strain_id)->get()->toArray();
        $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();
        $text = 'Strain';
        $notification_text = $this->userName . ' added a review for strain';
        if (isset($request['strain_review_id'])) {
            $notification_text = $this->userName . ' edit his review for strain';
            $text = 'Strain';
        }
        if (count($user_count) > 0) {
            $notificaion_data['activityToBeOpened'] = "Strains";
            $notificaion_data['user_strain'] = $add_review->review;
            $url = asset('user-strains-listing/' . $request['strain_id']);
            $notificaion_data['type_id'] = (int) $request['strain_id'];

            SendNotification::dispatch($text, $notification_text, $user_count, $notificaion_data, $url)->delay(Carbon::now()->addSecond(5));
        }
        return sendSuccess('Review added SuccessFuly', $data);
    }

    function deleteReview(Request $request) {
        $validation = $this->validate($request, [
            'strain_review_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        StrainRating::where('strain_review_id', $request['strain_review_id'])->delete();
        StrainReview::where('id', $request['strain_review_id'])->delete();
        return sendSuccess('Review Deleted SuccessFuly', '');
    }

    function flagStrainReview(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'strain_review_id' => 'required',
            'is_flaged' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $flag_strain = StrainReviewFlag::where(['strain_id' => $request['strain_id'], 'strain_review_id' => $request['strain_review_id'], 'flaged_by' => $this->userId])->first();
        if (!$flag_strain) {
            $flag_strain = new StrainReviewFlag();
        }
        $flag_strain->strain_id = $request['strain_id'];
        $flag_strain->strain_review_id = $request['strain_review_id'];
        $flag_strain->flaged_by = $this->userId;
        $flag_strain->is_flaged = $request['is_flaged'];
        $flag_strain->reason = $request['reason'];

        $flag_strain->save();
        return sendSuccess('Flagged Successfully', $flag_strain);
    }

    function saveStrainLikeDislike(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'is_like' => 'required',
            'is_dislike' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $strain_like_dislike = StrainLike::where('strain_id', $request['strain_id'])->where('user_id', $user_id)->first();
        if (!$strain_like_dislike) {
            $strain_like_dislike = new StrainLike();
        }
        $strain_like_dislike->strain_id = $request['strain_id'];
        $strain_like_dislike->user_id = $user_id;
        $strain_like_dislike->is_like = $request['is_like'];
        $strain_like_dislike->is_dislike = $request['is_dislike'];
        $strain_like_dislike->save();
        return sendSuccess('', $strain_like_dislike);
    }

    function saveStrainDislike(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $check = StrainLike::where('strain_id', $request['strain_id'])
                ->where('user_id', $user_id)
                ->where('is_dislike', 1)
                ->first();
        if (!$check) {
            $strain_dislike = new StrainLike();
            $strain_dislike->strain_id = $request['strain_id'];
            $strain_dislike->user_id = $user_id;
            $strain_dislike->is_dislike = 1;
            $strain_dislike->save();
            return sendSuccess('Dislike added successfully.', $strain_dislike);
        } else {
            return sendSuccess('Dislike already added.', $check);
        }
    }

    function saveStrainFlag(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'is_flaged' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $strain_flag = StrainLike::where('strain_id', $request['strain_id'])->where('user_id', $user_id)->first();
        if (!$strain_flag) {
            $strain_flag = new StrainLike();
        }
        $strain_flag->strain_id = $request['strain_id'];
        $strain_flag->user_id = $user_id;
        $strain_flag->is_flaged = $request['is_flaged'];
        $strain_flag->reason = $request['reason'];
        $strain_flag->save();
        return sendSuccess('Dislike added successfully.', $strain_flag);
    }

    function saveUserStrain(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'indica' => 'required',
            'sativa' => 'required',
//            'genetics' => 'required',
//            'cross_breed' => 'required',
            'min_CBD' => 'required',
            'max_CBD' => 'required',
            'min_THC' => 'required',
            'max_THC' => 'required',
            'growing' => 'required',
            'plant_height' => 'required',
            'flowering_time' => 'required',
            'min_fahren_temp' => 'required',
            'max_fahren_temp' => 'required',
            'min_celsius_temp' => 'required',
            'max_celsius_temp' => 'required',
            'yeild' => 'required',
            'climate' => 'required',
//            'note' => 'required',
//            'description' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        $strain = Strain::find($request['strain_id']);
        $user_strain = new UserStrain();
        if (isset($request['user_strain_id'])) {
            $user_strain = UserStrain::find($request['user_strain_id']);
        }
        $user_strain->strain_id = $request['strain_id'];
        $user_strain->user_id = $user_id;
        $user_strain->indica = $request['indica'];
        $user_strain->sativa = $request['sativa'];
        if (isset($request['genetics'])) {

            $user_strain->genetics = $request['genetics'];
        }
        if (isset($request['cross_breed'])) {
            $user_strain->cross_breed = $request['cross_breed'];
        }
        $user_strain->min_CBD = $request['min_CBD'];
        $user_strain->max_CBD = $request['max_CBD'];
        $user_strain->min_THC = $request['min_THC'];
        $user_strain->max_THC = $request['max_THC'];
        $user_strain->growing = $request['growing'];
        $user_strain->plant_height = $request['plant_height'];
        $user_strain->flowering_time = $request['flowering_time'];
        $user_strain->min_fahren_temp = $request['min_fahren_temp'];
        $user_strain->max_fahren_temp = $request['max_fahren_temp'];
        $user_strain->min_celsius_temp = $request['min_celsius_temp'];
        $user_strain->max_celsius_temp = $request['max_celsius_temp'];
        $user_strain->yeild = $request['yeild'];
        $user_strain->climate = $request['climate'];
        $user_strain->note = $request['note'];
        $user_description = getTaged($request['description'], 'f4c42f');
        $user_strain->description = $user_description;
        $user_strain->save();

        if ($request['image']) {
            $photo_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move('public/images/strain_images', $photo_name);

            $add_att = new StrainImage();
            $add_att->strain_id = $request['strain_id'];
            $add_att->user_id = $this->userId;
            $add_att->image_path = '/strain_images/' . $photo_name;
            $add_att->save();
        }

        //Activity Log
        $text = 'You have added a strain.';
        $other_user_text = 'Strain';
        $notification_text = Auth::user()->first_name . ' has added a strain.';
        if (isset($request['user_strain_id'])) {
            $text = 'You have updated a strain.';
            $other_user_text = 'Strain';
            $notification_text = Auth::user()->first_name . ' has updated a strain.';
        }

        $description = $strain->title;
        $type = 'Strains';
        $relation = 'UserStrain';
        $type_id = $request['strain_id'];
        $type_sub_id = $user_strain->id;

        addActivity($user_id, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $strain->title . ' <span style="display:none">' . $strain->id . '_' . $user_strain->id . '</span>');
        $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $request->strain_id)->get()->toArray();
        $user_count = User::select('id as user_id')->whereIn('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();

        if (count($user_count) > 0) {
            $data['activityToBeOpened'] = "Strains";
            $data['user_strain'] = $user_strain;
            $url = asset('user-strains-listing/' . $user_strain->strain_id);
            $data['type_id'] = (int) $type_id;

            SendNotification::dispatch($other_user_text, $notification_text, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
        }
        return sendSuccess('User Strain added successfully.', $user_strain);
    }

    function getUserStrains($strain_id) {
//        $data['user_strain'] = UserStrain::where('id', $user_strain_id)->withCount('getLikes')->first();
        $data['user_strains'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser')
                ->where('strain_id', $strain_id)
                ->orderBy('get_likes_count', 'desc')
                ->orderBy('id', 'desc')
                ->get();
        return sendSuccess('', $data);
    }

    function getUserStrainDetail($user_strain_id) {
//        $data['user_strain'] = UserStrain::where('id', $user_strain_id)->withCount('getLikes')->first();
        $data['user_strain'] = UserStrain::withCount('getLikes', 'getUserLike')->with('getUser', 'getAttachments')->where('id', $user_strain_id)->first();
        return sendSuccess('', $data);
    }

    function saveUserStrainLike(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'user_strain_id' => 'required',
            'is_like' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $strain_id = $request['strain_id'];
        $user_strain_id = $request['user_strain_id'];
        $is_like = $request['is_like'];
        $user_id = $this->userId;

        $user_strain_like = UserStrainLike::where('strain_id', $strain_id)->where('user_id', $user_id)->first();
        if ($user_strain_like) {
            removeUserActivity($user_id, 'Likes', 'UserStrainLike', $strain_id);
        } else {
            $user_strain_like = new UserStrainLike();
        }
        $user_strain_like->strain_id = $strain_id;
        $user_strain_like->user_strain_id = $user_strain_id;
        $user_strain_like->user_id = $user_id;
        $user_strain_like->is_like = $is_like;
        $user_strain_like->save();
        $message = $this->userName . ' liked your strain.';
        $user_strain = UserStrain::find($user_strain_id);
        $count = UserStrainLike::where(array('user_strain_id' => $user_strain_id))->count();
        addCheckUserPoint($count, 'strain', $user_strain_id, "Strain Like", $user_strain->user_id);
        if ($is_like) {

            //Notification Code
            if ($user_strain->user_id != $this->userId) {
                $heading = 'Like User Strain';

                $data['activityToBeOpened'] = "Strains";
                $data['user_strain'] = $user_strain;
                $data['type_id'] = (int) $strain_id;
                $url = asset('user-strains-listing/' . $user_strain->strain_id);
                sendNotification($heading, $message, $data, $user_strain->user_id, $url);
            }
            //Activity Log
            $on_user = $user_strain->user_id;
            $text = $message;
            $notification_text = $message;
            $description = $user_strain->description;
            $type = 'Likes';
            $relation = 'UserStrainLike';
            $type_id = $user_strain->strain_id;
            $type_sub_id = $user_strain->id;
            addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $type_sub_id, $user_strain->description . '<span style="display:none">' . $user_strain_like->id . '_' . $user_strain->id . '</span>');
        }
        return sendSuccess('Liked successfully.', $user_strain_like);
    }

    function deleteUserStrain(Request $request) {
        $validation = $this->validate($request, [
            'user_strain_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $delete = UserStrain::where(['id' => $request['user_strain_id']])->delete();

        //Delete Entry from User Activity Log
        $type_sub_id = $request['user_strain_id'];
        removeUserStrainActivity($type_sub_id);
        return sendSuccess('Strain deleted successfully.', $delete);
    }

    function getSurveyQuestions() {
        $data['questions'] = StrainSurveyQuestion::all();
        return sendSuccess('Strain deleted successfully.', $data);
    }

    function saveSurveyAnswer(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'q1_answer' => 'required',
            'q2_answer' => 'required',
            'q3_answer' => 'required',
            'q4_answer' => 'required',
//            'q5_answer' => 'required',
            'q6_answer' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;
        if ($request['q1_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 1;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q1_answer'];
            $survery_answer->save();
        }
        if ($request['q2_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 2;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q2_answer'];
            $survery_answer->save();
        }
        if ($request['q3_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 3;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q3_answer'];
            $survery_answer->save();
        }
        if ($request['q4_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 4;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q4_answer'];
            $survery_answer->save();
        }
        if ($request['q5_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 5;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q5_answer'];
            $survery_answer->save();
        }
        if ($request['q6_answer']) {
            $survery_answer = new StrainSurveyAnswer();
            $survery_answer->strain_id = $request['strain_id'];
            $survery_answer->question_id = 6;
            $survery_answer->user_id = $user_id;
            $survery_answer->answer = $request['q6_answer'];
            $survery_answer->save();
            //save survey points
//            $user_points = UserPoint::where(['user_id' => $this->userId, 'type' => 'Strain Survey', 'type_id' => $request['strain_id']])->first();
//            if (!$user_points) {
            $type = 'Strain Survey';
            $points = 5;
            $type_id = $request['strain_id'];
            savePoint($type, $points, $type_id);
//            }
            $strain_count = UserRewardStatus::where('user_id', $this->userId)->where('reward_points_id', 8)->first();
            if (!$strain_count) {
                savePoint('Strain Survey', 50, $survery_answer->id);
                makeDone($this->userId, 8);
            }
        }

        return sendSuccess('Answers saved successfully.', '');
    }

    function searchMedicalCondition() {
        $data['medical_coditions'] = MedicalConditions::where('m_condition', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return sendSuccess('', $data);
    }

    function searchSensation() {
        $data['sensations'] = Sensation::where('sensation', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return sendSuccess('', $data);
    }

    function searchNegativeEffect() {
        $data['negative_effects'] = NegativeEffect::where('effect', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return sendSuccess('', $data);
    }

    function searchDiseasePrevention() {
        $data['disease_preventions'] = DiseasePrevention::where('prevention', 'like', '%' . $_GET['search'] . '%')
                ->where('is_approved', 1)
                ->get();
        return sendSuccess('', $data);
    }

    function saveSuggestedMedicalCondition(Request $request) {
        $validation = $this->validate($request, [
            'medical_condition' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $medical_condition = MedicalConditions::where('m_condition', $request['medical_condition'])->first();
        if (!$medical_condition) {
            $medical_condition = new MedicalConditions();
        }
        $medical_condition->m_condition = $request['medical_condition'];
        $medical_condition->save();
        return sendSuccess('Your request has been sent for approval.', $medical_condition);
    }

    function saveSuggestedSensation(Request $request) {
        $validation = $this->validate($request, [
            'sensation' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $sensation = Sensation::where('sensation', $request['sensation'])->first();
        if (!$sensation) {
            $sensation = new Sensation();
        }
        $sensation->sensation = $request['sensation'];
        $sensation->save();
        return sendSuccess('Your request has been sent for approval.', $sensation);
    }

    function saveSuggestedNegativeEffect(Request $request) {
        $validation = $this->validate($request, [
            'negative_effect' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $negative_effect = NegativeEffect::where('effect', $request['negative_effect'])->first();
        if (!$negative_effect) {
            $negative_effect = new NegativeEffect();
        }
        $negative_effect->effect = $request['negative_effect'];
        $negative_effect->save();
        return sendSuccess('Your request has been sent for approval.', $negative_effect);
    }

    function saveSuggestedDiseasePrevention(Request $request) {
        $validation = $this->validate($request, [
            'prevention' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $disease_prevention = DiseasePrevention::where('prevention', $request['prevention'])->first();
        if (!$disease_prevention) {
            $disease_prevention = new DiseasePrevention();
        }
        $disease_prevention->prevention = $request['prevention'];
        $disease_prevention->save();
        return sendSuccess('Your request has been sent for approval.', $disease_prevention);
    }

    function addToFavorit(Request $request) {
        $validation = $this->validate($request, [
            'strain_id' => 'required',
            'is_favorit' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $model = 'Strain';
        $description = '';
        $type_id = 7;
        $type_sub_id = $request['strain_id'];

        if ($request['is_favorit'] == 0) {
            deleteMySave($user_id, $model, $type_id, $type_sub_id);
            removeUserActivity($user_id, 'Favorites', 'Strain', $request['strain_id']);
            return sendSuccess('Favorite removed successfully.', '');
        }

        if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
            if (addMySave($user_id, $model, $description, $type_id, $type_sub_id)) {

                //Activity Log
                $strain = Strain::find($request['strain_id']);


                $on_user = $user_id;
                $text = 'You have added a strain to favorite.';
                $notification_text = Auth::user()->first_name . ' has added a strain to favorite.';
                $description = $strain->title;
                $type = 'Favorites';
                $relation = 'Strain';
                $type_id = $request['strain_id'];
                addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $strain->title . ' <span style="display:none">' . $strain->id . '_' . $user_id . '</span>');
                return sendSuccess('Strain has been saved as your favorite.', '');
            } else {
                sendError('Error in saving strain.', 430);
            }
        }
        sendError('This strain is already exist in your saves.', 431);
    }

    function searchStrainBySurvey() {
        $skip = 0;
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'];
        }
        $searched_strains = StrainSurveyAnswer::with('getStrain.getType', 'getStrain.ratingSum', 'getStrain.getImages.getUser', 'getStrain.getImages.likeCount', 'getStrain.getImages.disLikeCount', 'getStrain.getImages.liked', 'getStrain.getImages.disliked', 'getStrain.getImages.flagged')
                ->with('getStrain.getReview', 'getStrain.getLikes', 'getStrain.getDislikes', 'getStrain.getUserLike', 'getStrain.getUserDislike', 'getStrain.getUserFlag', 'getStrain.isSaved')
                ->with(['getStrain' => function($q) {
                        $q->where('approved', 1);
                    }])
                ->groupBy('strain_id');
        $select_str = [];


        if (isset($_GET['medical_use']) && $_GET['medical_use'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . $_GET['medical_use'] . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . $_GET['medical_use'] . "%',1,0)";
        }
        if (isset($_GET['disease_prevention']) && $_GET['disease_prevention'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . $_GET['disease_prevention'] . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . $_GET['disease_prevention'] . "%',1,0)";
        }
        if (isset($_GET['mood_sensation']) && $_GET['mood_sensation'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . $_GET['mood_sensation'] . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . $_GET['mood_sensation'] . "%',1,0)";
        }
        if (isset($_GET['flavor']) && $_GET['flavor'] != '') {
            $searched_strains->orWhere('answer', 'like', '%' . $_GET['flavor'] . '%');
            $select_str[] = "IF(GROUP_CONCAT(`answer`) LIKE '%" . $_GET['flavor'] . "%',1,0)";
        }
        $select_column = "";
        if (count($select_str) > 0) {
            $select_column = ",(" . implode('+', $select_str) . ") AS matched";
        } else {
            $select_column = ',0 AS matched';
        }
        $searched_strains->selectRaw('*' . $select_column);
        $searched_strains->orderByRaw('matched DESC');
        if (isset($_GET['skip'])) {
            $skip = $_GET['skip'] * 10; //page number start from 0;
            $searched_strains->take(10);
            $searched_strains->skip($skip);
        }

        $searched_strains = $searched_strains->get();
        foreach ($searched_strains as $searched_strain) {
            $searched_strain->getStrain->get_review_count = count($searched_strain->getStrain->getReview);
            $searched_strain->getStrain->get_likes_count = count($searched_strain->getStrain->getLikes);
            $searched_strain->getStrain->get_dislikes_count = count($searched_strain->getStrain->getDislikes);
            if ($searched_strain->getStrain->getUserLike) {
                $searched_strain->getStrain->get_user_like_count = 1;
            } else {
                $searched_strain->getStrain->get_user_like_count = 0;
            }
            if ($searched_strain->getStrain->getUserDislike) {
                $searched_strain->getStrain->get_user_dislike_count = 1;
            } else {
                $searched_strain->getStrain->get_user_dislike_count = 0;
            }
            if ($searched_strain->getStrain->getUserFlag) {
                $searched_strain->getStrain->get_user_flag_count = 1;
            } else {
                $searched_strain->getStrain->get_user_flag_count = 0;
            }
            if ($searched_strain->getStrain->isSaved) {
                $searched_strain->getStrain->is_saved_count = 1;
            } else {
                $searched_strain->getStrain->is_saved_count = 0;
            }
        }

        $data['strains'] = $searched_strains;

        $data['madical_condition_answers'] = MedicalConditions::where('is_approved', 1)->get();
        $data['sensation_answers'] = Sensation::where('is_approved', 1)->get();
        $data['negative_effect_answers'] = NegativeEffect::where('is_approved', 1)->get();
        $data['prevention_answers'] = DiseasePrevention::where('is_approved', 1)->get();
        $data['survey_flavor_answers'] = Flavor::where('is_approved', 1)->get();

        return sendSuccess('', $data);
    }

    function saveStrainSurveySearch() {
        $data = new \stdClass();
        $data->search_title = $_GET['search_title'];
        $data->search_data = '?medical_use=' . $_GET['medical_use'] . '&disease_prevention=' . $_GET['disease_prevention'] . '&mood_sensation=' . $_GET['mood_sensation'] . '&flavor=' . $_GET['flavor'];

        $user_id = $this->userId;
        $model = 'MySave';

        $description = json_encode($data);
        $type_id = 10;
        $strain_search_title = $_GET['search_title'];
        addMySave($user_id, $model, $description, $type_id, 0, $strain_search_title);
        return sendSuccess('Search saved successfully.', '');
    }

//    function saveStrainSurveySearch() {
//        $searched_strains = StrainSurveyAnswer::with('getStrain.getType', 'getStrain.ratingSum')
//                ->with(['getStrain' => function($q) {
//                        $q->where('approved', 1);
//                    }])
//                ->groupBy('question_id', 'strain_id');
//        $select_str = [];
//        if ($_GET['medical_use']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['medical_use'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['medical_use'] . "%',1,0)";
//        }
//        if ($_GET['disease_prevention']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['disease_prevention'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['disease_prevention'] . "%',1,0)";
//        }
//        if ($_GET['mood_sensation']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['mood_sensation'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['mood_sensation'] . "%',1,0)";
//        }
//        if ($_GET['flavor']) {
//            $searched_strains->orWhere('answer', 'like', '%' . $_GET['flavor'] . '%');
//            $select_str[] = "IF(`answer` LIKE '%" . $_GET['flavor'] . "%',1,0)";
//        }
//        $select_column = "";
//        if (count($select_str) > 0) {
//            $select_column = ",(" . implode('+', $select_str) . ") AS matched";
//        } else {
//            $select_column = ',0 AS matched';
//        }
//        $searched_strains->selectRaw('*' . $select_column);
//        $searched_strains->orderByRaw('matched DESC');
//        if ($_GET['skip']) {
//            $skip = $_GET['skip'] * 10; //page number start from 0;
//            $searched_strains->take(10);
//            $searched_strains->skip($skip);
//        }
//
//        $searched_strains = $searched_strains->get();
//        $user_id = $this->userId;
//        $model = 'Strain';
//        $description = '';
//        $type_id = 7;
//        foreach ($searched_strains as $searched_strain) {
//            $type_sub_id = $searched_strain->strain_id;
//            if (!checkMySave($user_id, $model, $type_id, $type_sub_id)) {
//                addMySave($user_id, $model, $description, $type_id, $type_sub_id);
//            }
//        }
//        return sendSuccess('Search saved successfully.', '');
//    }

    function locateStrainBudz() {
        $strain_id = $_GET['strain_id'];
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $skip = $_GET['skip'] * 20;
        $radious = env('LOCATE_BUD_RADIUS');

//        $data['budz'] = SubUser::selectRaw("*,( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
//                ->having("distance", "<", $radious)
//                ->with('getProducts', 'getProducts.images', 'getProducts.strainType', 'getProducts.pricing')
//                ->whereHas('getProducts', function($q) use ($strain_id) {
//                    $q->where('strain_id', $strain_id);
//                })
//                ->orderBy('distance', 'asc')
//                ->take(20)->skip($skip)
//                ->get();
        $data['budz'] = VProduct::selectRaw("v_products.*, ( 6371 * acos( cos( radians($lat))*cos( radians(lat) ) * cos( radians(lng) - radians($lng) ) + sin( radians($lat) ) * sin( radians(lat) ) ) ) AS distance")
//                ->having("distance", "<", $radious)
                ->where('zip_code', $this->user->zip_code)
                ->with('strainType', 'images', 'pricing')
                ->where('is_blocked', 0)
                ->whereHas('subUser', function($q) {
                    $q->where('business_type_id', 1);
                })
//                    ->when($tag != "", function ($query) use($tag) {
//                        return $query->where('tag_title', $tag)->orWhere('tag_title', NULL)->orderBy('price', 'DESC');
//                    })
                ->where('strain_id', $strain_id)
                ->groupBy('id')
                ->get();
        return sendSuccess('', $data);
    }

    function saveStrainImageLike(Request $request) {
        $validation = $this->validate($request, [
            'strain_image_id' => 'required',
            'is_like' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $add_like = StrainImageLikeDislike::where('image_id', $request['strain_image_id'])->where('user_id', $user_id)->first();
        if (!$add_like) {
            $add_like = new StrainImageLikeDislike;
            $add_like->user_id = $user_id;
            $add_like->image_id = $request['strain_image_id'];
        }
        $add_like->is_liked = $request['is_like'];
        if ($request['is_like']) {
            $add_like->is_disliked = 0;
        }
        $add_like->save();
        return sendSuccess("Like Updated Successfully", $add_like);
    }

    function saveStrainImageDislike(Request $request) {
        $validation = $this->validate($request, [
            'strain_image_id' => 'required',
            'is_disliked' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $add_like = StrainImageLikeDislike::where('image_id', $request['strain_image_id'])->where('user_id', $user_id)->first();
        if (!$add_like) {
            $add_like = new StrainImageLikeDislike;
            $add_like->user_id = $user_id;
            $add_like->image_id = $request['strain_image_id'];
        }
        $add_like->is_disliked = $request['is_disliked'];
        if ($request['is_disliked']) {
            $add_like->is_liked = 0;
        }
        $add_like->save();
        return sendSuccess("Dislike Updated Successfully", $add_like);
    }

    function saveStrainImageFlag(Request $request) {
        $validation = $this->validate($request, [
            'strain_image_id' => 'required',
            'is_flagged' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $user_id = $this->userId;
        $strain_image_flag = StrainImageFlag::where(array('user_id' => $user_id, 'image_id' => $request['']))->first();
        if (!$strain_image_flag) {
            $strain_image_flag = new StrainImageFlag();
            $strain_image_flag->image_id = $request['strain_image_id'];
            $strain_image_flag->user_id = $user_id;
        }
        $strain_image_flag->is_flagged = $request['is_flagged'];
        $strain_image_flag->reason = $request['reason'];
        $strain_image_flag->save();
        return sendSuccess("Flag Updated Successfully", $strain_image_flag);
    }

    function addStrainReviewLike(Request $request) {
        $validation = $this->validate($request, [
            'review_id' => 'required',
            'strain_id' => 'required',
            'like_val' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $review_id = $request->review_id;
        $strain_id = $request->strain_id;
        $val = $request->like_val;
        $check_strain_review_like = StrainReviewLike::where(array('user_id' => $this->userId, 'strain_id' => $strain_id, 'strain_review_id' => $review_id))->first();
        if (!$check_strain_review_like && $val) {
            $add_review = new StrainReviewLike;
            $add_review->user_id = $this->userId;
            $add_review->strain_id = $strain_id;
            $add_review->strain_review_id = $review_id;
            $add_review->save();
            $strain_review_user_id = StrainReview::find($review_id);
            $get_users = [];
//            $get_users = \App\VGetMySave::select('user_id')->where('type_id', 7)->where('type_sub_id', $strain_id)->get()->toArray();
            if ($strain_review_user_id->reviewed_by != $this->userId) {
                $get_users[]['user_id'] = $strain_review_user_id->reviewed_by;
            }
            $user_count = User::select('id as user_id')->wherein('id', $get_users)->where('id', '!=', $this->userId)->get()->toArray();

            if (count($user_count) > 0) {
                $notification_text = $this->userName . ' like strain review';
                $other_user_text = 'Strain';
                $data['activityToBeOpened'] = "Strains";
                $data['strain_id'] = $strain_id;
                $url = asset('strain-details/' . $strain_id);
                $data['type_id'] = (int) $strain_id;
                SendNotification::dispatch($other_user_text, $notification_text, $user_count, $data, $url)->delay(Carbon::now()->addSecond(5));
            }
        } else {
            StrainReviewLike::where(array('user_id' => $this->userId, 'strain_id' => $strain_id, 'strain_review_id' => $review_id))->delete();
        }
        return sendSuccess("Like updated", '');
    }

    function deleteStrainImage($id) {
        StrainImage::where('id', $id)->delete();
        return sendSuccess("Image Deleted Successfully", '');
    }

}
