<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ImageOptimisationController extends Controller {
    /**
     * @param  mixed  $image_path
     * @param  mixed  $filename
     */
    public function resize($image_path, $filename) : string {
        $e = pathinfo($filename)['extension'];
        $n = hash('adler32', pathinfo($filename)['filename']);
        $destination = storage_path('app/private/note_images/' . time() . '_' . $n . '.' . $e);

        File::ensureDirectoryExists(dirname($destination), 0755, true);

        $mgr = new ImageManager(new Driver);

        try {
            $img = $mgr::imagick()->read($image_path);
            $img->scaleDown(768, 768)->contrast(7)->save($destination);
        } catch (Exception $e) {
            return null;
        } catch (\Throwable $e) {
            return null;
        }
        return $destination;
    }
}
