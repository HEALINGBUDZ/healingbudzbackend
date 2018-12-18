<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
class Contact extends Model
{
    use AlgoliaEloquentTrait;
    protected $fillable = ['name'];
     public $algoliaSettings = [
        'searchableAttributes' => [
            'id',
            'name',
        ],
        'customRanking' => [
            'desc(popularity)',
            'asc(name)',
        ],
    ];
    public function getAlgoliaRecord()
    {
        return array_merge($this->toArray(), [
            'custom_name' => 'Custom Name'
        ]);
    }
}
