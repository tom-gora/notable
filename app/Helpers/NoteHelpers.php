<?php

namespace App\Helpers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class NoteHelpers {
    /**
     * @param \\App\\Models\\Note $n The note object being deleted.
     */
    protected static function noteImageCleanupHook(Note $n) : bool {
        $img = basename($n->img_url);

        if (!$img || !Storage::disk('public')->exists('note_images/' . $img)) {
            return false;
        }
        return Storage::disk('public')->delete('note_images/' . $img);
    }

    public static function toggleNoteFavourite(int $id) : void {
        $note = auth()->user()->notes()->find($id);
        if (!$note) {
            return;
        }
        $note->is_favourite = !$note->is_favourite;
        $note->save();
    }

    public static function archiveNote(int $id) : void {
        $note = auth()->user()->notes()->find($id);
        if (!$note) {
            return;
        }
        $note->is_archived = true;
        $note->save();
    }

    public static function unarchiveNote(int $id) : void {
        $note = auth()->user()->notes()->find($id);
        if (!$note) {
            return;
        }
        $note->is_archived = false;
        $note->save();
    }

    /**
     * @param  mixed  $id
     */
    public static function deleteNote($id) : bool {
        $n = auth()->user()->notes()->find($id);
        if (!$n) {
            return false;
        }
        $deleted = $n->delete();
        if (!$deleted) {
            return false;
        }
        $cleaned = self::noteImageCleanupHook($n);
        if (!$cleaned) {
            return false;
        }
        return true;
    }
}
