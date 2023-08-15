<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Helper extends Controller
{
    /**
     * @param Request $request
     * @return string|void
     */
    public static function imageUploader(Request $request)
    {

        if ($request->has('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $path = $request->file('image')->storeAs('public/uploads/images', $filename);
            return 'storage/uploads/images/'  . $filename;
        }
    }


    /**
     * Upload And Resize Image
     *
     * @param  mixed $image
     * @param  string $publicPath
     * @param  int $height
     * @param  int $width
     * @return void
     */
    function uploadAndResizeImage($image, string $publicPath = 'uploads/', int $height, int  $width)
    {
        $imagePath = $image->getPathname();
        // Check if the given image path exists and is readable
        if (!File::isReadable($imagePath)) {
            return null; // Or handle the error as needed
        }

        // Get the image file extension
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

        // Generate a unique filename for the resized image
        $resizedFilename = uniqid() . '_resized.' . $extension;

        // Create a new instance of the Intervention Image class
        $image = Image::make($imagePath);

        // Resize the image
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Get the public storage disk
        $disk = Storage::disk('public');

        // Check if the public path exists, if not, create it
        if (!$disk->exists($publicPath)) {
            $disk->makeDirectory($publicPath);
        }

        // Upload the resized image to the public path
        $resizedImagePath = $publicPath . $resizedFilename;
        $disk->put($resizedImagePath, $image->encode());

        // Grant permissions to the uploaded file if needed
        $publicFilePath = storage_path('app/public/' . $resizedImagePath);
        if (!File::isWritable($publicFilePath)) {
            File::chmod($publicFilePath, 0775); // Change permissions as needed
        }

        return $resizedImagePath;
    }
}
