<!DOCTYPE html>
<html>
<head>
<style>
    body {
        max-width: 1200px;
        margin: 150px auto 0 auto;
    }
</style>
</head>

<body>

<h1>Eriks oppskrifter</h1>

<?
$recipes = ["Pizzadeig", "Pasta, grunnoppskrift", "Nudler"]
?>

<ul>
<? foreach ($recipes as $recipe): ?>
    <li>
        <a href="recipe.php?id=<?= urlencode($recipe) ?>">
            <?= $recipe ?>
        </a>
    </li>
<? endforeach; ?>
<ul>

</body>
</html>