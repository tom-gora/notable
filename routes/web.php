<?php

use App\Models\Note;
use App\Notable as N;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as Rt;
use Illuminate\Support\Str;

Rt::get("/", N\Welcome::class)->name("welcome");
Rt::get("/home", N\Home::class)->name("home")->middleware(["auth", "verified"]);
Rt::get("/transcripts", N\Transcripts::class)->name("transcripts");
Rt::get("/archive", N\Archive::class)->name("archive");
Rt::get("/favourites", N\Favourites::class)->name("favourites");
Rt::get("/collections", N\Collections::class)->name("collections");
Rt::get("/settings", N\Settings::class)->name("settings");
Rt::get("/snapshots", N\Snapshots::class)->name("snapshots");

/*Rt::view("profile", "livewire.profile")*/
Rt::get("/profile", N\Profile::class)->name("profile")
    ->middleware(["auth"])
    ->name("profile");


Rt::post("/api/internal/md", function (Request $r) {
    // sleep to give the user a chance to see the spinner and be confident a work is being done
    $n = Note::find($r->getContent());
    return Str::of($n->markdown)->markdown();
})->middleware(["auth"]);

Rt::post("/api/internal/notes", function (Request $r) {
    // sleep to give the user a chance to see the spinner and be confident a work is being done
    $ns = Note::all()->where("user_id", auth()->user()->id);
    return $ns->toArray();
})->middleware(["auth"]);


require __DIR__ . "/auth.php";
