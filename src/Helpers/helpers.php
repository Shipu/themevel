<?php
    
    if (!function_exists('themes')) {
        /**
         * Generate an asset path for the theme.
         *
         * @param  string  $path
         * @param  bool    $secure
         * @return string
         */
        function themes($path, $secure = null)
        {
            return Theme::assets($path, $secure);
        }
    }