<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
//Models
use App\UserActivity;
use App\NotificationSetting;
class SendNotification implements ShouldQueue {

    protected $heading;
    protected $message;
    protected $users;
    protected $data;
    protected $url;

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($heading, $message, $users, $data, $url) {
        $this->heading = $heading;
        $this->message = $message;
        $this->users = $users;
        $this->data = $data;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        foreach ($this->users as $user) {
            $ios_badgeType = 'SetTo';
            $ios_badgeCount = UserActivity::where('on_user', $user['user_id'])->where('user_id', '!=', $user['user_id'])->where('is_read', 0)->count();
            //web
            $send = $this->checkNotificationSetting($this->heading, $user['user_id']);
    if ($send) {
            \OneSignal::sendNotificationUsingTags(
                    $this->heading, $this->message, 
                    [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $user['user_id'])],
                    $this->url, $this->data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
            );
            //ios
            \OneSignal::sendNotificationUsingTags(
                    $this->heading, $this->message, 
                    [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $user['user_id'])],
                    $this->url = null, $this->data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
            );
            //android
            \OneSignal::sendNotificationUsingTags(
                    $this->heading, $this->message, 
                    [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $user['user_id'])],
                    $this->url = null, $this->data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
            );
        }}
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
        }elseif ($heading == 'Strain') {
            return TRUE;
        }elseif ($heading == 'Strains') {
            return TRUE;
        } elseif ($heading == 'Post Added') {
            return TRUE;
        } elseif ($heading == 'Post Liked') {
            return TRUE;
        } elseif ($heading == 'Post Comment') {
            return TRUE;
        } elseif ($heading == 'Keyword') {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return TRUE;
    }
}

}
