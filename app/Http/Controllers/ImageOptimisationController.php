<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ImageOptimisationController extends Controller {
    public function resize($image_path, $filename) : string {
        $e = pathinfo($filename)["extension"];
        // make my own randomized name because default looooong strings from Storage facade are pissing me off
        $n = hash("adler32", pathinfo($filename)["filename"]);
        $destination = storage_path('app/public/note_images/' . time() . "_" . $n . "." . $e);

        $mgr = new ImageManager(new Driver());

        $img = $mgr::imagick()->read($image_path);

        try {
            // optimize/resize down/slightly bump up contrast
            $img->scaleDown(768, 768)->contrast(7)->save($destination);
        } catch (Exception $e) {
            return null;
        }
        return $destination;
    }
}