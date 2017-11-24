<?php

namespace catawich\models;

/**
 * Class Sandwich
 * @package catawish\models
 */

class Sandwich extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'sandwich';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function images(){

      return $this->hasMany('catawich\models\Image','s_id');
    }

    public function categories(){
      return $this->belongsToMany('catawich\models\Categorie', 'sand2cat', 'sand_id', 'cat_id');

    }
    public function tailles(){
      return $this->belongsToMany('catawich\models\Taille_sandwich', 'tarif', 'sand_id', 'taille_id')->withPivot(['prix']);

    }

}
