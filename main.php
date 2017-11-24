<?php
use \catawich\models\Sandwich;
use \catawich\models\Image;
use \catawich\models\Categorie;

use Illuminate\Database\Eloquent\ModelNotFoundException;
require_once ('vendor/autoload.php');

// initialisation connection
$config = parse_ini_file('conf/config.ini');
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection( $config );
$db->setAsGlobal();
$db->bootEloquent();



echo "<h1>Liste des sandwichs</h1>";
$requete = Sandwich::select('nom','description','type_pain')->get();
foreach($requete as $key => $value){

	echo "$key => $value </br></br>";
}


echo "<h1>Liste des sandwichs selon type pain</h1>";
$requete = Sandwich::select('nom','description','type_pain')->orderBy('type_pain')->get();
foreach($requete as $key => $value){

	echo "$key => $value </br></br>";
}


echo "<h1>Sandwich 42</h1>";
$requete = Sandwich::select('nom','description','type_pain')->orderBy('type_pain')->get();
foreach($requete as $key => $value){

	echo "$key => $value </br></br>";
}

echo "<h1>Sandwich 42</h1>";

try{
	$requete = Sandwich::select('nom','description','type_pain')->where('id', '=', '42')->first();

	if (!empty($requete)){

	$html = $requete->nom . "</br>";
	$html .= $requete->description. "</br>";
	$html .= $requete->type_pain. "</br>";
	echo $html;

	}else {
		throw new ModelNotFoundException("Le produit n'existe pas ");
	}
}
catch(ModelNotFoundException $e) {
	echo $e->getMessage();
}

echo "<h1>Pain de type baguette :</h1>";
$requete = Sandwich::where('type_pain','like','%baguette%')->orderBy('type_pain')->get();

foreach ($requete as $key => $value) {
	echo "$key => $value";
}

// création nouveau sandwichs et insertions dans la base
// $mySandwich = new Sandwich();
// $mySandwich->nom = "Montagnard buddah cheese";
// $mySandwich->description = "Pur buddah cheese, salade gourmande, steakhouse";
// $mySandwich->type_pain = "baguette sésame";
//
// $mySandwich->save();

echo "<h1>afficher le sandwich n°4 et lister les images associées</h1>";
$requete = Sandwich::where('id','=',4)->first()->images()->with('sandwich')->get();
foreach ($requete as $key => $value) {
	# code...
	echo "$key => $value";
}


// lister l'ensemble des sandwichs, triés par type de pain, et pour chaque sandwich afficher la
// liste des images associées. Utiliser un chargement lié.

echo "<h1>Ensemble des sandwich, trié par type de pain, avec images associés</h1>";
$requete = Sandwich::select()->orderBy('type_pain')->with('images')->get();
foreach ($requete as $key => $value) {
	# code...
	echo "$key => $value";
}

// Lister les images et indiquer pour chacune d'elle le sandwich associé en affichant son nom et
// son type de pain.
echo "<h1>Lister les images et indiquer pour chacune d'elle le sandwich associé en affichant son nom et son type de pain</h1>";
$imgs = Image::with('sandwich')->get();
foreach ($imgs as $img) {
	# code...
	echo $img->id;
	echo $img->sandwich->nom;
}

// créer 3 images associées au sandwich ajouté dans l'exercice 1
//echo "<h1>Ajouter une image a un sandwich</h1>";
$mySandwich = new Sandwich();
$mySandwich->nom = "Montagnard buddah cheese";
$mySandwich->description = "Pur buddah cheese, salade gourmande, steakhouse";
$mySandwich->type_pain = "baguette sésame";
//$mySandwich->save();

$myImage = new Image();
$myImage->titre =  "Montagnard";
$myImage->type = "image/jpeg";
$myImage->def_x = 2018;
$myImage->def_y = 2048;
$myImage->taille= 546165;
$myImage->filename = "sandwiiiiich.jpeg";

// images : Nom de l'asssociation du model
//$mySandwich->images()->save($myImage);

echo "<h1>changer le sandwich associé à la 3ème image créée</h1>";
//$mySand = new Sandwich();
$myImg = Image::find(4);
$myImg->s_id = 14;
$myImg->save();

echo "<h1>lister les catégories du sandwich d'ID 5
; afficher le sandwich (nom, description, type de
pain) et le nom de chacune des catégories auxquelles il est associé.</h1>";
$mySand = Sandwich::find(5);
$c = $mySand->categories()->select()->get();

foreach ($c as $value) {
 	echo $value;
 }


echo "<h1>Lister l'ensemble des catégories, et pour chaque catégorie la liste de sandwichs associés utiliser un chargement lié</h1>";
$categorie = Categorie::with('sandwichs')->get();


foreach ($categorie as $key => $value) {
	# code...
	echo "$key => $value";
}

echo "<h1>lister les sandwichs dont le type_pain contient 'baguette' et pour chaque sandwich, afficher
ses catégories et la liste des images qui lui sont associées
; utiliser un chargement lié.</h1>";
$sandwich = Sandwich::where('type_pain','=','baguette')->with('categories','images')->get();
foreach ($sandwich as $key => $value) {
	# code...
	echo "$key => $value </br>";
}

echo "<h1>associer le sandwich créé au 1.5 aux catégories 1 et 3</h1>";
$sandwich = Sandwich::find(16);
// ajout a chaque chargement
$sandwich->categories()->sync([1,3]);

echo "<h1>afficher la liste des tailles proposées pour le sandwich d'ID 5</h1>";
$sandwich = Sandwich::find(5);
$taille = $sandwich->tailles()->get();
foreach ($taille as $key => $value) {
	# code...
	echo "$key => $value </br>";
}

echo "<h1>idem, mais en ajoutant le prix du sandwich pour chaque taille</h1>";
$s = Sandwich::with('tailles')->where('id','=',5)->first();
foreach ($s->tailles as $key => $value) {
	# code...
	echo "$key => $value </br>";
	echo $value->pivot->prix;
}

echo "<h1>associer le sandwich créé au 1.5 aux différentes tailles existantes en précisant le prix dans
chaque cas</h1>";
$sandwich = Sandwich::find(16);
$sandwich->tailles()->sync([1=>['prix'=>6.00],2=>['prix'=>7.00], 3=>['prix'=>8.50]]);

echo "<h1>pour la catégorie dont le nom contient 'traditionnel', lister les sandwichs dont le type_pain
contient 'baguette</h1>";
$sandwich = Sandwich::where('type_pain','like','%baguette%')->whereHas('categories',function($q){
	$q->where('categorie.nom', 'like', '%traditionnel%');
})->get();
foreach ($sandwich as $key => $value) {
	# code...
	echo "$key => $value </br>";
}
