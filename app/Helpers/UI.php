<?php

namespace App\Helpers;

class UI {
    // CONST:
    // links to display in a sidebar menu (using iconify and to define an icon only a string to template in is enough)
    public static array $SIDEBAR_LINKS = [
        ['/', 'Home', 'solar--home-bold-duotone'],
        ['/transcripts', 'Transcripts', 'hugeicons--quill-write-02'],
        ['/snapshots', 'Snapshots', 'solar--eye-scan-bold-duotone'],
        ['/archive', 'Archive', 'solar--inbox-archive-line-duotone'],
        ['/collections', 'Collections', 'solar--widget-2-line-duotone'],
        ['/bookmarks', 'Bookmarks', 'solar--notebook-bookmark-bold-duotone'],
        ['/settings', 'Settings', 'solar--settings-line-duotone'],
    ];

    public static array $TOPBAR_LINKS = [
        "auth_true" => [
            ['/profile', 'Profile'],
        ],
        "auth_false" => [
            ['showLogin', 'Login'],
            ['showRegister', 'Register'],
        ]
    ];

    // determine if link in menu is to the currently displayed view to set as prop > style and and model behavior conditionally
    public static function isCurrent(string $link) : bool {
        return request()->is('/') ? request()->is($link) : request()->is(ltrim($link, '/'));
    }

    public static function getTheme() : string {
        if (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') {
            return 'dark';
        }

        return '';
    }

    public static function getSidebarState() : bool {
        if (isset($_COOKIE['sidebar']) && $_COOKIE['sidebar'] === 'expanded') {
            return true;
        }

        return false;
    }

    public static function getCurrentTitle() : string {
        $route = request()->route()->uri;
        if ($route === '/') {
            return 'Home';
        }

        $current = array_filter(UI::$SIDEBAR_LINKS, function ($link) use ($route) {
            $current = strpos($link[0], $route);

            return $current;
        });
        $current = reset($current);
        if (empty($current)) {
            return 'Home';
        }
        return $current[1];

    }
}