<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\UserActivity;

class RemindLater implements ShouldQueue {

    protected $user;

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
//        return TRUE;
        $user = $this->user;
        
        $ios_badgeType = 'SetTo';
        $data['message'] = 'Its time to remind you to add expertise';
        $data['activityToBeOpened'] = "Reminder";
        $ios_badgeCount = UserActivity::where('on_user', $user->id)->where('user_id', '!=', $user->id)->where('is_read', 0)->count();
        //web
        \OneSignal::sendNotificationUsingTags(
                "Reminder", "Its time to remind you to add expertise", [array("key" => "device_type", "relation" => "=", "value" => 'web'), array("key" => "user_id", "relation" => "=", "value" => $user->id)], asset('user-profile-detail/' . $user->id), $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //ios
        \OneSignal::sendNotificationUsingTags(
                "Reminder", "Its time to remind you to add expertise", [array("key" => "device_type", "relation" => "=", "value" => 'ios'), array("key" => "user_id", "relation" => "=", "value" => $user->id)], null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
        //android
        \OneSignal::sendNotificationUsingTags(
                "Reminder", "Its time to remind you to add expertise", [array("key" => "device_type", "relation" => "=", "value" => 'android'), array("key" => "user_id", "relation" => "=", "value" => $user->id)],  null, $data, $buttons = null, $schedule = null, $ios_badgeType, $ios_badgeCount
        );
    }

}
