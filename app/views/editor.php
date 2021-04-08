<?
use MongoDB\BSON\ObjectId;

require '../vendor/autoload.php';

$db = new MongoDB\Client("mongodb://root:example@mongodb:27017");

$recipeId = explode("/", $request)[2];

if (isset($_POST['title']))
{
    $name = strtolower($_POST['title']);
    $name = preg_replace('/[^0-9a-zæøå\-_]/', '', $name);

    $updateResult = $db->pizzaprobably->recipes
        ->updateOne(
            ['_id' => new ObjectId($recipeId)],
            [ '$set' => [
                'name' => $name,
                'title' => $_POST['title'],
                'content' => trim($_POST['content']),
            ]]
        );
}

$recipe = $db->pizzaprobably->recipes->findOne(['_id' => new ObjectId($recipeId)]);

$Parsedown = new Parsedown();
?>

<div class="editor">
    <form method="post">
        <label for="title-input">
            <strong>Title</strong>
        </label>
        <div>
            <input id="title-input" type="text" name="title" value="<?= $recipe['title'] ?>">
        </div>

        <div class="editor-content-wrapper">
            <label for="editor-content">
                <strong>Content</strong>
            </label>
            <textarea id="editor-content" name="content"><? echo $recipe['content']; ?></textarea>
        </div>
        <button type="submit">Save</button>
    </form>
</div>

<style>
    .editor textarea {
        padding: 1em;
        width:100%;
        height: 450px;
        border: 1px solid;
        resize: none;
        background: aliceblue;
        white-space:pre-wrap;
        word-wrap: break-word;
        line-height: 1.25em;

        color: #757575 !important;
    }

    .editor .editor-content-wrapper {
        margin-top: 1em;
    }
</style>