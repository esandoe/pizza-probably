<?
$db = new MongoDB\Client("mongodb://root:example@mongodb:27017");

$recipes = $db->pizzaprobably->recipes->find([]);

?>

<h1>Eriks oppskrifter</h1>

<ul>
<? foreach ($recipes as $recipe): ?>
    <li>
        <a href="/recipes/<?= urlencode(strtolower($recipe['name'])) ?>">
            <?= $recipe['title'] ?>
        </a>
    </li>
<? endforeach; ?>
<ul>