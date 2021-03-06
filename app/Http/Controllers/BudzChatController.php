<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
//Models
//use App\ChatUser;
//use App\ChatMessage;
use App\BudzChat;
use App\BudzChatMessage;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Log;
use App\MySave;

class BudzChatController extends Controller {

    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getBudzChats() {
        $user_id = $this->userId;
        $chats = BudzChat::with('budz.getBizType')
                ->withCount(['messagesChat' => function ($q) {
                        $q->where('is_read', 0);
                    }])
                ->withCount(['member' => function ($q) use ($user_id) {
                        $q->where('sender_id', $user_id);
                        $q->orWhere('receiver_id', $user_id);
                    }])
                ->withCount('isSaved')
                ->where(function ($q) use($user_id) {
                    $q->where('sender_id', $user_id);
                    $q->orWhere('receiver_id', $user_id);
                })
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')
                ->groupBy('budz_id')
                ->get();
        return sendSuccess('', $chats);
    }

    function sendMessage(Request $request) {
        $validation = $this->validate($request, [
            'receiver_id' => 'required',
            'budz_id' => 'required',
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $budz_id = $request['budz_id'];
        $chat_user = BudzChat::where(function($q) use($receiver_id, $sender_id, $budz_id) {
                    $q->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id)
                    ->where('budz_id', $budz_id);
                })
                ->orwhere(function($q) use($receiver_id, $sender_id, $budz_id) {
                    $q->where('sender_id', $receiver_id);
                    $q->where('receiver_id', $sender_id);
                    $q->where('budz_id', $budz_id);
                })
                ->first();

        if ($chat_user) {

            $chat_user->receiver_deleted = 0;
            $chat_user->sender_deleted = 0;
            $chat_user->save();
        }
        if (!$chat_user) {
            $chat_user = new BudzChat;
            $chat_user->sender_id = $sender_id;
            $chat_user->receiver_id = $receiver_id;
            $chat_user->budz_id = $budz_id;
            $chat_user->save();
        }

        $notification_text = '';
        $message = new BudzChatMessage;
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->chat_id = $chat_user->id;
        $message->budz_id = $budz_id;
        if ($request['message']) {
            $tagged_message = makeUrls(getTaged($request['message'], '6d96ad'));
            $message->message = $tagged_message;
            $notification_text = $request['message'];
        }

        if ($request['image']) {
            $message->file_path = addFile($request['image'], 'chat');
            $message->poster = '';
            $message->file_type = 'image';
            $notification_text = 'Send a image.';
        }
        if ($request['video']) {
            $video = $request['video'];
            $video_data = addVideo($video, 'chat');
            $message->file_path = $video_data['file'];
            $message->poster = $video_data['poster'];
            $message->file_type = 'video';
            $notification_text = 'Send a video.';
        }
        if (isset($request['url'])) {
            if ($request['url']) {
                if (strpos($request['url'], 'http') !== false) {
                    $extracted_url = $request['url'];
                } else {
                    $extracted_url = 'http://' . $request['url'];
                }
                $url_data = $this->scrapeUrl($extracted_url);
                if ($url_data) {
                    $message->site_title = $url_data['title'];
                    $message->site_content = $url_data['content'];
                    if (isset($url_data['images'][0])) {
                        $message->site_image = $url_data['images'][0];
                    } else {
                        $message->site_image = '';
                    }
                    $message->site_extracted_url = $extracted_url;
                    $message->site_url = $url_data['title'];
                }
            }
        }
        $message->save();

        BudzChat::where(function($q) use($receiver_id, $sender_id, $budz_id) {
                    $q->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id)
                    ->where('budz_id', $budz_id);
                })
                ->orwhere(function($q) use($receiver_id, $sender_id, $budz_id) {
                    $q->where('sender_id', $receiver_id);
                    $q->where('receiver_id', $sender_id);
                    $q->where('budz_id', $budz_id);
                })->update(['last_message_id' => $message->id]);
        $mesage = BudzChatMessage::find($message->id);

        //Nodification code
        if ($receiver_id != $this->userId) {
            $message_obj = BudzChatMessage::where('id', $message->id)->with('sender', 'receiver')->first();
            $heading = 'User Chat';
            $messagex = $this->userName . ' sent you a private message.';
            $data['activityToBeOpened'] = "Chat";
            $data['message'] = $message_obj;
            $url = asset('budz-message-detail/' . $message->chat_id);
            sendNotification($heading, $messagex, $data, $receiver_id, $url);
        }
        //Activity Log
        $on_user = $request['receiver_id'];
        $text = 'You send a budz message.';
        $notification_text = $this->userName . ' send you a budz message.';
        $description = $message->message;
        $unique_description = $message->message . '<span style="display:none">' . $message->id . '_' . $this->userId . '</span>';

        $type = 'BudzChat';
        $relation = 'BudzChat';
        $type_id = $message->chat_id;
        addActivity($on_user, $text, $notification_text, $description, $type, $relation, $type_id, $budz_id, $unique_description);
        return sendSuccess('Message send successfully.', $mesage);
    }

    function readMessages(Request $request) {
        $validation = $this->validate($request, [
            'chat_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $receiver_id = $this->userId;

        $messages = BudzChatMessage::where(['chat_id' => $request['chat_id'], 'receiver_id' => $receiver_id])->update(['is_read' => 1]);
        return sendSuccess('Messages read successfully.', $messages);
    }

    function deleteMessage(Request $request) {
        $validation = $this->validate($request, [
            'message_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $message = BudzChatMessage::find($request['message_id']);
        if ($message->sender_id == $user_id) {
            $message->sender_deleted = 1;
        } elseif ($message->receiver_id == $user_id) {
            $message->receiver_deleted = 1;
        }
        $message->is_read = 1;
        $message->save();
        return sendSuccess('Messages deleted successfully.', $message);
    }

    function deleteChat(Request $request) {
        $validation = $this->validate($request, [
            'chat_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }

        $user_id = $this->userId;

        $chat = BudzChat::find($request['chat_id']);
        if ($chat->sender_id == $user_id) {
            $chat->sender_deleted = 1;
        } elseif ($chat->receiver_id == $user_id) {
            $chat->receiver_deleted = 1;
        }
        $chat->save();

        BudzChatMessage::where(['chat_id' => $request['chat_id'], 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
        BudzChatMessage::where(['chat_id' => $request['chat_id'], 'sender_id' => $user_id])->update(['sender_deleted' => 1, 'is_read' => 1]);
        MySave::where(array('type_sub_id' => $request['chat_id'], 'type_id' => 13, 'model' => 'BudzChat',))->delete();
        return sendSuccess('Chat Deleted successfully.', '');
    }

    function deleteChatBudz(Request $request) {
        $validation = $this->validate($request, [
            'budz_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $budz_id = $request['budz_id'];
        $user_id = $this->userId;
        $chats = BudzChat::where('budz_id', $budz_id)
                ->where(function ($q) use($user_id) {
                    $q->where('sender_id', $user_id);
                    $q->orWhere('receiver_id', $user_id);
                })
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')
                ->get();
        foreach ($chats as $chat) {

            if ($chat->sender_id == $user_id) {
                $chat->sender_deleted = 1;
            } elseif ($chat->receiver_id == $user_id) {
                $chat->receiver_deleted = 1;
            }
            $chat->save();

            BudzChatMessage::where(['chat_id' => $chat->id, 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
            BudzChatMessage::where(['chat_id' => $chat->id, 'sender_id' => $user_id])->update(['sender_deleted' => 1, 'is_read' => 1]);
        }
        return sendSuccess('Chats Deleted successfully.', '');
    }

    function getDetailChat(Request $request) {
        $validation = $this->validate($request, [
            'chat_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $chat_id = $request['chat_id'];
        $user_id = $this->userId;
        $chat = BudzChat::find($chat_id);
        $sub_user = \App\SubUser::find($chat->budz_id);
        BudzChatMessage::where(array('chat_id' => $chat_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $messages = BudzChatMessage::with('sender', 'receiver')
                ->where('chat_id', $chat_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->get();
        return sendSuccess($sub_user, $messages);
    }

    function getChatUsers($budz_id) {
        $user_id = $this->userId;
        $chats = BudzChat::with('budz')
                ->with(['sender' => function ($q) {
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
                    }])->withCount('isSaved')
                ->where('budz_id', $budz_id)
                ->where(function ($q) use($user_id) {
                    $q->where('sender_id', $user_id);
                    $q->orWhere('receiver_id', $user_id);
                })
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')
                ->get();
        return sendSuccess('', $chats);
    }

    public function scrapeUrl($scrape_url) {
        if (!empty($scrape_url) && filter_var($scrape_url, FILTER_VALIDATE_URL)) {
            $get_url = $scrape_url;

            $parse = parse_url($get_url);
            $url = $parse['host'];

            //get URL content
            $get_content = HtmlDomParser::file_get_html($scrape_url);
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

    function getChatDetail(Request $request) {
        $validation = $this->validate($request, [
            'budz_id' => 'required',
            'other_id' => 'required'
        ]);
        if ($validation) {
            return sendError($validation, 400);
        }
        $other_id = $request['other_id'];
        $user_id = $this->userId;
        $budz_id = $request['budz_id'];
        BudzChatMessage::where(array('sender_id' => $other_id, 'receiver_id' => $user_id, 'budz_id' => $budz_id))->update(['is_read' => 1]);
        $messages = BudzChatMessage::with('sender', 'receiver')
                ->where(function ($q) use($user_id, $other_id, $budz_id) {
                    $q->where('sender_id', $user_id);
                    $q->where('receiver_id', $other_id);
                    $q->where('budz_id', $budz_id);
                })
                ->orwhere(function ($q) use($other_id, $user_id, $budz_id) {
                    $q->where('sender_id', $user_id);
                    $q->where('receiver_id', $other_id);
                    $q->where('budz_id', $budz_id);
                })
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->get();
        return sendSuccess('', $messages);
    }

    function addBuzChatMySave(Request $request) {
        if ($request->save) {
            $add_my_save = new MySave;
            $add_my_save->user_id = $this->userId;
            $add_my_save->type_sub_id = $request->chat_id;
            $add_my_save->type_id = 13;
//            $add_my_save->type_sub_id = $request->chat_id;
            $add_my_save->model = 'BudzChat';
            $add_my_save->description = $request->other_id;
            $add_my_save->save();
            return sendSuccess('Chat saved successfully', '');
        } else {
            MySave::where(array('user_id' => $this->userId, 'type_id' => 13, 'model' => 'BudzChat', 'type_sub_id' => $request->chat_id))->delete();
            return sendSuccess('Chat unsaved successfully', '');
        }
    }

}
