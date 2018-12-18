<?php

namespace App;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class SubUser extends Model {
use Billable;

    protected $casts = [
        'is_organic' => 'integer',
        'user_id' => 'integer',
        'business_type_id'=> 'integer',
        'is_delivery' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
        'menu_tab_count' => 'integer',
        'purchase_ticket_count' => 'integer',
        'get_user_review_count' => 'integer',
        'get_user_save_count' => 'integer',
        'is_flaged_count' => 'integer',
    ];

    function getUser(){
       return $this->hasOne('\App\User','id', 'user_id'); 
    }
    
    function reviews() {
        return $this->hasMany('App\BusinessReview', 'sub_user_id')->selectRaw('sub_user_id , COUNT(reviewed_by) as total')
                        ->groupBy('sub_user_id');
    }
    
    function allReviews(){
        return $this->hasMany('App\BusinessReview', 'sub_user_id');
    }
    function ratingSum() {
        return $this->hasOne('App\BusinessReview', 'sub_user_id')
                ->selectRaw('sub_user_id , CAST(AVG(rating) AS DECIMAL(8,2)) as total') ->groupBy('sub_user_id');
    }

    function review() {
        return $this->hasMany('App\BusinessReview', 'sub_user_id')->orderBy('created_at','desc');
    }
    
    function getLatestReview(){
        return $this->hasMany(BusinessReview::class,'sub_user_id')->take(3)->orderBy('created_at', 'desc');
    }
    
    function getUserReview(){
        if(Auth::user()){
        return $this->hasMany('\App\BusinessReview','sub_user_id')->where(['reviewed_by'=>Auth::user()->id]);
    }else{
        return $this->hasMany('\App\BusinessReview','sub_user_id');
    }}

    function rating() {
        return $this->hasMany('App\BusinessUserRating', 'sub_user_id');
    }

    function timeing() {
        return $this->hasOne('App\BusinessTiming', 'sub_user_id');
    }

    function products() {
        return $this->hasMany('App\Product', 'sub_user_id')->orderBy('updated_at','desc');
    }
    
    function services() {
        return $this->hasMany('App\Service', 'sub_user_id');
    }

    function specials() {
        return $this->hasMany('App\ShoutOut', 'sub_user_id')->orderBy('id','desc');
    }
    
    function getImages(){
       return $this->hasMany('App\SubUserImage', 'sub_user_id'); 
    }
    
    function getProducts() {
        return $this->hasMany('App\Product', 'sub_user_id');
    }
    
    function languages() {
        return $this->hasMany('App\BusinessLanguage', 'sub_user_id');
    }
    
    
    function events() {
        return $this->hasMany('App\BusinessEvent', 'sub_user_id');
    }
    
    function tickets() {
        return $this->hasMany('App\Ticket', 'sub_user_id');
    }
    
    function getBizType() {
        return $this->belongsTo('App\BusinessType','business_type_id', 'id');
    }
    
    function getUserSave(){
        return $this->hasMany('\App\VGetMySave','type_sub_id')->whereTypeId(8);
    }
    
    function subscriptions(){
        return $this->hasOne('App\Subscription','sub_user_id','id');
    }
    
    function budzFeed() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id');
    }
    
    function budFeedViews() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('views', 1);
    }
    
    function budFeedViewsByTag() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('tag_id', '!=', NULL);
    }
    
    function budFeedReviews() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('review_id', '!=', NULL);
    }
    
    function budFeedSaves() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('my_save_id', '!=', NULL);
    }
    
    function budFeedShare() {
        return $this->hasMany(BudzFeed::class, 'sub_user_id','id')->where('share_id', '!=', NULL);
    }
    
    function budFeedClickToCall() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('click_to_call', 1);
    }
    function budFeedClickToTicket() {
        return $this->hasMany('App\BudzFeed', 'sub_user_id')->where('cta', 1);
    }
    function tags(){
      return $this->hasMany(TagStatePrice::class,'user_id','user_id');
    }
    function paymantMethods(){
       return $this->hasMany(SubUserPaymentType::class,'sub_user_id'); 
    }
    
    public function getEmailAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getLogoAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getBannerAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getPhoneAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getWebAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getFacebookAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getTwitterAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getInstagramAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getInsuranceAcceptedAttribute($value) {
        if (is_null($value)) {
            $value = 'No';
        }
        return $value;
    }
    
    public function getOfficePoliciesAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    
    public function getVisitRequirementsAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    function isFlaged(){
        if(Auth::user()){
        return $this->hasOne(SubUserFlag::class,'budz_id')->where(['reported_by'=>Auth::user()->id]);
        }else{
         return $this->hasOne(SubUserFlag::class,'budz_id');   
        }
    }
    
    function flags(){
        return $this->hasMany(SubUserFlag::class,'budz_id');
    }
    function special(){
        return $this->hasMany(BudzSpecial::class,'budz_id');
    }
}
