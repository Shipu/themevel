<?php

if (!function_exists('themes')) {
    /**
     * Generate an asset path for the theme.
     *
     * @param string $path
     * @param bool   $secure
     *
     * @return string
     */
    function themes($path, $secure = null)
    {
        return Theme::assets($path, $secure);
    }
}

if (!function_exists('theme_mix')) {
    /**
     * Get the current theme path to a versioned Mix file.
     *
     * @param string $path
     * @param  string  $manifestDirectory
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    function theme_mix($path, $manifestDirectory = '')
    {
        return Theme::themeMix($path, $manifestDirectory);
    }
}

if (!function_exists('theme_path')) {
    /**
     * Get the current theme path to a versioned Mix file.
     *
     * @param string $path
     *
     * @return string
     */
    function theme_path($path)
    {
        return Theme::getFullPath($path);
    }
}

if (!function_exists('lang')) {
    /**
     * Get lang content from current theme.
     *
     * @param $fallback
     *
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    function lang($fallback)
    {
        return Theme::lang($fallback);
    }
}

if (!function_exists('current_theme_name')) {
    /**
     * Get current active theme name only or themeinfo collection.
     *
     * @param bool $collection
     *
     * @return null|ThemeInfo
     */
    function current_theme_name()
    {
        return Theme::current();
    }
}

if (!function_exists('current_theme')) {
    /**
     * Get current active theme name only or themeinfo collection.
     *
     * @param bool $collection
     *
     * @return null|ThemeInfo
     */
    function current_theme($collection = false)
    {
        return Theme::current($collection);
    }
}
