<?php
/**
 * File:  Categorie.php
 * Creation Date: 09/11/2017
 * description:
 *
 * @author: canals
 */

namespace catawich\models;


/**
 * Class Categorie
 * @package catawish\models
 */
class Categorie extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sandwichs(){
      return $this->belongsToMany('catawich\models\Sandwich', 'sand2cat', 'cat_id', 'sand_id')->withPivot(['sand_id','cat_id']);

    }




}
