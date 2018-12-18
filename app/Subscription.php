<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subscription extends Model {

    protected $table = 'subscriptions';
    protected $fillable = ['name', 'stripe_id', 'sub_user_id', 'stripe_plan', 'quantity', 'ends_at', 'trial_ends_at', 'created_at', 'updated_at'];

}
