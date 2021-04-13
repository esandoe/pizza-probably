<?php


namespace App\Classes;


use App\Models\Recipe;
use Illuminate\Support\Facades\App;
use Parsedown;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class RecipeParsing
{
    protected static $requiredKeys = [
        'title',
        'image'
    ];

    public static function validate(string $id, string $content): array
    {
        if (!preg_match('/---(.+)---/s', $content, $metadata))
            return ['The metadata section at the start of the file is missing.'];

        $errors = [];
        try {
            $metadata = Yaml::parse($metadata[1]);

            foreach (self::$requiredKeys as $key)
            {
                if (!isset($metadata[$key]))
                    $errors[] = "Missing required metadata field: <strong>$key</strong>";
            }

            if (isset($metadata['title']))
            {
                $name = self::createUri($metadata['title']);
                if ($name != $id and Recipe::where('name', '=', $name)->exists())
                    $errors[] = "Name already taken: <strong>$name</strong>";
            }
        }
        catch (ParseException $exception){
            $errors[] = $exception->getMessage();
        }
        finally {
            return $errors;
        }
    }

    public static function getMetadata(string $content): array
    {
        if (!preg_match('/---(.+)---/s', $content, $metadata))
            return array_fill_keys(self::$requiredKeys, null);

        try {
            return Yaml::parse($metadata[1]);
        }catch (ParseException $exception){
            return array_fill_keys(self::$requiredKeys, null);
        }
    }

    public static function getHtml(string $content): string
    {
        $parser = App::make(Parsedown::class);
        $content = preg_replace('/---(.+)---/s', '', $content);
        return $parser->text($content);
    }

    public static function createUri(string $title)
    {
        $name = strtolower($title);
        $name = str_replace([" ", "_"], "-", $name);
        $name = preg_replace("/&([a-z])[a-z]+;/", "$1", htmlentities($name));
        $name = preg_replace("/[^a-z0-9-]/", "", $name);
        $name = preg_replace("/-{2,}/", "-", $name);
        return $name;
    }
}
