<?php


namespace App\Http\Controllers;


use App\Models\Recipe;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected static $publicFolder = '/public';
    protected static $uploadPath = '/uploads/img/';

    protected static $maxSize = 1200;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function uploadImage(Request $request, string $id)
    {
        if (!Recipe::exists($id))
            return response()->json(['error' => "No recipe found for id \"$id\""], 404);

        $file = $request->file('file');
        if (!$file->isValid())
            return response('Upload error', 400);

        $fileLocation = base_path(self::$publicFolder.self::$uploadPath);
        $fileName = self::createUniqueFilename($id);
        $destination = $fileLocation.$fileName;

        self::resizeAndSave($file->get(), $destination);
        Recipe::find($id)->push('images', self::$uploadPath.$fileName);

        $image = self::$uploadPath.$fileName;

        return response()->json(['url' => $image]);
    }

    public function deleteImage(Request $request, string $id)
    {
        if (!Recipe::exists($id))
            return response()->json(['error' => "No recipe found for id \"$id\""], 404);

        $image = $request->input('image');
        $isRemoved = Recipe::find($id)->pull('images', $image);

        if ($isRemoved) {
            $filePath = base_path(self::$publicFolder) . $image;
            unlink($filePath);
        }

        return response('Deleted', 200);
    }

    protected static function createUniqueFilename($id, $ext = '.jpg')
    {
        $prefix = preg_replace('/[^a-z]/i', '', $id);
        $prefix = substr($prefix, 0, 5);

        return uniqid($prefix) . $ext;
    }


    protected static function resizeAndSave($string, $destination)
    {
        list($width, $height) = getimagesizefromstring($string);
        $aspect_ratio = $width / $height;

        $new_width = $width;
        $new_height = $height;
        if ($width > self::$maxSize and $width > $height) {
            $new_width = min($width, self::$maxSize);
            $new_height = $new_width / $aspect_ratio;
        }
        else if ($height > self::$maxSize) {
            $new_height = min($height, self::$maxSize);
            $new_width = $new_height * $aspect_ratio;
        }

        // Resample
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromstring($string);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagejpeg($image_p, $destination, 75);
    }
}
