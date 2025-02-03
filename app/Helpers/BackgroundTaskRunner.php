<?php

namespace App\Helpers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class BackgroundTaskRunner {
    /**
     * @param \\App\\Models\\Note $n The note object being deleted.
     */
    public function imageCleanupHook(Note $n) : bool {
        $img = basename($n->img_url);

        if (!$img || !Storage::disk('public')->exists('note_images/' . $img)) {
            return false;
        }
        return Storage::disk('public')->delete('note_images/' . $img);
    }
}
