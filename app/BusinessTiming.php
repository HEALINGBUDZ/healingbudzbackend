<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessTiming extends Model {
    
    protected $casts = [
        'sub_user_id' => 'integer',
    ];

    public function getSaturdayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getSundayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getMondayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getTuesdayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
    public function getWednesdayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getThursdayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getFridayAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getMonEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getTueEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getWedEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getThuEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getFriEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getSatEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getSunEndAttribute($value) {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

}
