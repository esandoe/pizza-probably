<?
require '../vendor/autoload.php';

$db = new MongoDB\Client("mongodb://root:example@mongodb:27017");

$recipeName = explode("/", $request)[2];
$recipeName = strtolower($recipeName);

$recipe = $db->pizzaprobably->recipes->findOne(['name' => $recipeName]);

$Parsedown = new Parsedown();
?>

<h1><?= $recipe['title'] ?></h1>
<a href="/edit/<?= $recipeName ?>">Edit</a>

<div>
    <?= $Parsedown->text($recipe['content']) ?>
</div>
