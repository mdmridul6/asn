<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function uploadAndResizeImage($image, string $publicPath = 'uploads/', int $height = null, int  $width = null)
{
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $uploadPath = 'uploads/' . $publicPath;

    $destinationPathThumbnail = public_path($uploadPath);
    if (!File::exists($destinationPathThumbnail)) {
        File::makeDirectory($destinationPathThumbnail, 0755, true, true); // Create directory recursively
    }

    $img = Image::make($image->path());

    if ($height && $width) {
        $img->resize($width, $height);
    } elseif ($height) {
        $img->heighten($height);
    } elseif ($width) {
        $img->widen($width);
    }

    $img->save($destinationPathThumbnail . '/' . $imageName);

    $destinationPath = $uploadPath; // Adjust as needed

    if (!File::isWritable(public_path($destinationPath))) {
        File::chmod(public_path($destinationPath), 0755); // Change permissions as needed
    }

    $image->move(public_path($destinationPath), $imageName);

    return 'public/' . $destinationPath . '/' . $imageName;
}
