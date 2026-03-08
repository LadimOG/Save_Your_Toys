<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{

    public function imageCompression($file, string $folderName)
    {
        //destination et nom de l'image.
        $pathName = $folderName . '/' . uniqid("image") . '.webp';

        //compression de l'image.
        $compressedImage = Image::read($file)->scale(width: 1100)->toWebp(60);

        //enregistrement de l'image sur le disque dur du serveur.
        Storage::disk('public')->put($pathName, $compressedImage);

        return $pathName;
    }
}
