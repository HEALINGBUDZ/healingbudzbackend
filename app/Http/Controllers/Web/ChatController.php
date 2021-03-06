<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
Use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Sunra\PhpSimple\HtmlDomParser;
//Models
use App\ChatUser;
use App\ChatMessage;
use App\User;
use Jenssegers\Agent\Agent;
use App\MySave;

class ChatController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getChats() {

        $user_id = $this->userId;
        $data['title'] = 'Messages';
        $data['chats'] = ChatUser::with(['sender' => function ($q) {
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

        return view('user.chats', $data);
    }

    function getChatDetails($chat_id) {
        $user_id = $this->userId;
        $data['title'] = 'Messages';
        ChatMessage::where(array('chat_id' => $chat_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $data['chat_user_id'] = $chat_id;
        $data['messages'] = ChatMessage::with('sender', 'receiver')
//                ->where(function ($q) use($user_id) {
//                    $q->where('sender_id', $user_id);
//                    $q->orWhere('receiver_id', $user_id);
//                })
//                ->where(function ($q) use($other_user) {
//                    $q->where('sender_id', $other_user);
//                    $q->orWhere('receiver_id', $other_user);
//                })
                ->where('chat_id', $chat_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->get();

        $chat = ChatUser::find($chat_id);
        $other_user = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_user = $chat->receiver_id;
        }
        $data['other_user'] = User::find($other_user);
        $data['other_user_chat_id'] = $other_user;

        return view('user.chat-detail', $data);
        return Response::json(array('successData' => $data));
    }

    function getChatDetailsIframe($chat_id) {
        $user_id = $this->userId;
        $data['title'] = 'Messages';
        ChatMessage::where(array('chat_id' => $chat_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $data['chat_user_id'] = $chat_id;
        $data['messages'] = ChatMessage::with('sender', 'receiver')
//                ->where(function ($q) use($user_id) {
//                    $q->where('sender_id', $user_id);
//                    $q->orWhere('receiver_id', $user_id);
//                })
//                ->where(function ($q) use($other_user) {
//                    $q->where('sender_id', $other_user);
//                    $q->orWhere('receiver_id', $other_user);
//                })
                ->where('chat_id', $chat_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->get();

        $chat = ChatUser::find($chat_id);
        $other_user = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_user = $chat->receiver_id;
        }
        $data['other_user'] = User::find($other_user);
        $data['other_user_chat_id'] = $other_user;

        return view('user.chat-detail-iframe', $data);
        return Response::json(array('successData' => $data));
    }

    function getChatUserDetails($other_id) {
        $user_id = $this->userId;
        $data['title'] = 'Messages';
        ChatMessage::where(array('sender_id' => $other_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $chat = ChatUser::where(function ($q) use($user_id, $other_id) {
                            $q->where('sender_id', $user_id);
                            $q->where('receiver_id', $other_id);
                        })
                        ->orwhere(function ($q) use($other_id, $user_id) {
                            $q->where('sender_id', $other_id);
                            $q->where('receiver_id', $user_id);
                        })->first();

        if ($chat) {
            $data['chat_user_id'] = $chat->id;
        } else {
            $data['chat_user_id'] = '';
        }
        $data['messages'] = ChatMessage::with('sender', 'receiver')
                ->where(function ($q) use($user_id, $other_id) {
                    $q->where(function ($q) use($user_id, $other_id) {
                        $q->where('sender_id', $user_id);
                        $q->where('receiver_id', $other_id);
                    })
                    ->orwhere(function ($q) use($other_id, $user_id) {
                        $q->where('sender_id', $other_id);
                        $q->where('receiver_id', $user_id);
                    });
                })
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->get();
        $data['other_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;

        return view('user.chat-detail', $data);
        return Response::json(array('successData' => $data));
    }

    function returnMessage(request $request) {

        echo json_encode(makeUrls(getTaged($request['message'], '6d96ad')));
    }

    function addMessage(Request $request) {
        $validation = $this->validate($request, [
            'receiver_id' => 'required'
        ]);
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
        }
        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $chat_user = ChatUser::where(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                        })
                        ->orwhere(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $receiver_id);
                            $q->where('receiver_id', $sender_id);
                        })->first();
        if ($chat_user) {
            if ($chat_user->receiver_id == $sender_id) {
                $chat_user->receiver_deleted = 0;
                $chat_user->sender_deleted = 0;
                $chat_user->save();
            }
            if ($chat_user->sender_id == $sender_id) {
                $chat_user->sender_deleted = 0;
                $chat_user->receiver_deleted = 0;
                $chat_user->save();
            }
        }
        if (!$chat_user) {
            $chat_user = new ChatUser;
            $chat_user->sender_id = $sender_id;
            $chat_user->receiver_id = $receiver_id;
            $chat_user->save();
        }

        $message = new ChatMessage;
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->chat_id = $chat_user->id;
        if ($request['message']) {
            $tagged_message = $tagged_message = makeUrls(getTaged($request['message'], '6d96ad'));
            $message->message = $tagged_message;
        }
        if ($request['file']) {

            if (substr($file_type, 0, 5) == 'image') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'image';
            }
            if (substr($file_type, 0, 5) == 'video') {
                $video = $request['file'];
                $video_data = addVideo($video, 'chat');
                $message->file_path = $video_data['file'];
                $message->poster = $video_data['poster'];
                $message->file_type = 'video';
            }
        }
        if ($request['scrape_url']) {
            $url_data = $this->scrapeUrl($request['scrape_url']);
            if ($url_data) {
                $message->site_title = $url_data['title'];
                $message->site_content = $url_data['content'];
                if (isset($url_data['images'][0])) {
                    $message->site_image = $url_data['images'][0];
                } else {
                    $message->site_image = '';
                }
                $message->site_extracted_url = $request['scrape_url'];
                $message->site_url = $url_data['title'];
            }
        }

        $message->save();

        ChatUser::where(function($q) use($receiver_id, $sender_id) {
                    $q->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id);
                })
                ->orwhere(function($q) use($receiver_id, $sender_id) {
                    $q->where('sender_id', $receiver_id);
                    $q->where('receiver_id', $sender_id);
                })->update(['last_message_id' => $message->id]);
        $mesage = ChatMessage::find($message->id);
        $mesage->image_base = asset('public/images');
        $mesage->video_base = asset('public/videos');



        //Nodification code
        if ($receiver_id != $this->userId) {
            $message_obj = ChatMessage::where('id', $message->id)->with('sender', 'receiver')->first();
            $heading = 'User Chat';
            $messagex = $this->userName . ' sent you a private message.';
            $data['activityToBeOpened'] = "Chat";
            $data['message'] = $message_obj;
            $url = asset('message-detail/' .$chat_user->id);
            sendNotification($heading, $messagex, $data, $receiver_id, $url);
        }
        //Activity Log
        $on_user = $request['receiver_id'];
        $text = 'You send a message.';
        $notification_text = $this->userName . ' sent you a private message.';
        $description = $message->message;
        $unique_description = $message->message . '<span style="display:none">' . $message->id . '_' . $this->userId . '</span>';
        $type = 'Chat';
        $relation = 'ChatMessage';
        $type_id = $message->id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, '', $unique_description);
        echo json_encode($mesage);
    }

    function readMessages(Request $request) {
        $validation = $this->validate($request, [
            'chat_id' => 'required'
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }

        $receiver_id = $this->userId;

        $messages = ChatMessage::where(['chat_id' => $request['chat_id'], 'receiver_id' => $receiver_id])->update(['is_read' => 1]);
        return Response::json(array('status' => 'success', 'successData' => $messages, 'successMessage' => 'Messages read successfully.'));
    }

    function deleteMessage(Request $request) {
        $validation = $this->validate($request, [
            'message_id' => 'required'
        ]);
        if ($validation) {
            return Response::json(array('status' => 'error', 'errorMessage' => $validation));
        }

        $user_id = $this->userId;

        $message = ChatMessage::find($request['message_id']);
        if ($message->sender_id == $user_id) {
            $message->sender_deleted = 1;
        } elseif ($message->receiver_id == $user_id) {
            $message->receiver_deleted = 1;
        }
        $message->is_read = 1;
        $message->save();

        return Response::json(array('status' => 'success', 'successData' => $message, 'successMessage' => 'Messages deleted successfully.'));
    }

    function deleteChat($id) {
        $user_id = $this->userId;
        $chat = ChatUser::find($id);
        if ($chat->sender_id == $user_id) {
            $chat->sender_deleted = 1;
        } elseif ($chat->receiver_id == $user_id) {
            $chat->receiver_deleted = 1;
        }
        $chat->save();
        ChatMessage::where(['chat_id' => $id, 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
        ChatMessage::where(['chat_id' => $id, 'sender_id' => $user_id])->update(['sender_deleted' => 1, 'is_read' => 1]);
        MySave::where(array('type_sub_id' => $id, 'type_id' => 2, 'model' => 'ChatUser',))->delete();
        Session::flash('success', "Chat Deleted Successfully");
        return Redirect::to(URL::previous('messages'));
    }

    function addFile(Request $request) {

        print_r($request->all());
    }

    public function scrapeUrl($scrape_url) {
        if (!empty($scrape_url) && filter_var($scrape_url, FILTER_VALIDATE_URL)) {
            $get_url = $scrape_url;

            $parse = parse_url($get_url);
            $url = $parse['host'];

            //get URL content
            $get_content = HtmlDomParser::file_get_html($scrape_url);
            if (!$get_content) {
                return FALSE;
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

    function addChatMySave(Request $request) {
        if ($request->save) {
            $add_my_save = new MySave;
            $add_my_save->user_id = $this->userId;
            $add_my_save->type_sub_id = $request->chat_id;
            $add_my_save->type_id = 2;
//            $add_my_save->type_sub_id = $request->other_id;
            $add_my_save->model = 'ChatUser';
            $add_my_save->description = $request->other_id;
            $add_my_save->save();
        } else {
            MySave::where(array('user_id' => $this->userId, 'type_id' => 2, 'model' => 'ChatUser', 'type_sub_id' => $request->chat_id))->delete();
        }
    }

    function addBussChatMySave(Request $request) {
        if ($request->save) {
            $add_my_save = new MySave;
            $add_my_save->user_id = $this->userId;
            $add_my_save->type_sub_id = $request->chat_id;
            $add_my_save->type_id = 13;
//            $add_my_save->type_sub_id = $request->other_id;
            $add_my_save->model = 'BudzChat';
            $add_my_save->description =  $request->other_id;
            $add_my_save->save();
        } else {
            MySave::where(array('user_id' => $this->userId, 'type_id' => 13, 'model' => 'BudzChat', 'type_sub_id' => $request->chat_id))->delete();
        }
    }

}
