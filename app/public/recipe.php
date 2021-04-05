<?
require '../vendor/autoload.php';
?>

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
<?
$Parsedown = new Parsedown();

echo $Parsedown->text('Hello _Parsedown_!');
?>


</body>
</html>