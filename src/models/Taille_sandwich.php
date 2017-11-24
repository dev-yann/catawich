<?php

namespace catawich\models;

/**
 * Class Taille_sandich
 * @package catawish\models
 */

class Taille_sandwich extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'taille_sandwich';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sandwichs(){
      return $this->belongsToMany('catawich\models\Sandwich', 'tarif', 'taille_id', 'sand_id')->withPivot(['prix']);

    }
}
