<?php

namespace catawich\models;

/**
 * Class Image
 * @package catawish\models
 */

class Image extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'image';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sandwich(){

      return $this->belongsTo('catawich\models\Sandwich','s_id');
    }

}
