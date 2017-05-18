<?php

namespace Shipu\Themevel\Managers;

use Illuminate\Container\Container;
use Illuminate\View\ViewFinderInterface;
use Noodlehaus\Config;
use Shipu\Themevel\Contracts\ThemeContract;
use Shipu\Themevel\Exceptions\ThemeNotFoundException;

class Theme implements ThemeContract
{
    /**
     * Theme Root Path
     *
     * @var string
     */
    protected $basePath;
    
    /**
     * All Theme Information
     *
     * @var collection
     */
    protected $themes;
    
    /**
     * Blade View Finder
     *
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;
    
    /**
     * Application Container
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;
    
    /**
     * Translator
     *
     * @var \Illuminate\Contracts\Translation\Translator
     */
    protected $lang;
    
    /**
     * Current Active Theme
     *
     * @var string|collection
     */
    private $activeTheme = null;
    
    /**
     * Theme constructor.
     *
     * @param Container $app
     * @param ViewFinderInterface $finder
     * @param Translator $lang
     */
    public function __construct( Container $app, ViewFinderInterface $finder, $lang )
    {
        $this->basePath = config('theme.theme_path');
        
        $this->app = $app;
        
        $this->finder = $finder;
        
        $this->lang = $lang;
        
        $this->scanThemes();
    }
    
    /**
     * Set current theme
     *
     * @param $theme
     */
    public function set( $theme )
    {
        if ( !$this->has($theme) ) {
            throw new ThemeNotFoundException($theme);
        }
        
        $this->loadTheme($theme);
        $this->activeTheme = $theme;
    }
    
    /**
     * Check if theme exists
     *
     * @param $theme
     *
     * @return bool
     */
    public function has( $theme )
    {
        return array_key_exists($theme, $this->themes);
    }
    
    /**
     * Get particular theme all information
     *
     * @param $themeName
     *
     * @return null|ThemeInfo
     */
    public function getThemeInfo( $themeName )
    {
        return isset( $this->themes[ $themeName ] ) ? $this->themes[ $themeName ] : null;
    }
    
    /**
     * Returns current theme or particular theme information.
     *
     * @param string Theme namespace
     *
     * @return null|array|ThemeInfo
     */
    public function get( $theme = null, $collection = false )
    {
        if ( is_null($theme) || !$this->has($theme) ) {
            return !$collection ? $this->themes[ $this->activeTheme ]->all() : $this->themes[ $this->activeTheme ];
        }
        
        return !$collection ? $this->themes[ $theme ]->all() : $this->themes[ $theme ];
    }
    
    /**
     * Get current active theme name only or themeinfo collection
     *
     * @param bool $collection
     *
     * @return null|ThemeInfo
     */
    public function current( $collection = false )
    {
        return !$collection ? $this->activeTheme : $this->getThemeInfo($this->activeTheme);
    }
    
    /**
     * Get all theme information
     *
     * @return array
     */
    public function all()
    {
        return $this->themes;
    }
    
    /**
     * Find asset file for theme asset
     *
     * @param $path
     * @param null $secure
     *
     * @return string
     */
    public function assets( $path, $secure = null )
    {
        $splitThemeAndPath = explode(':', $path);
        
        if ( count($splitThemeAndPath) > 1 ) {
            if ( is_null($splitThemeAndPath[ 0 ]) ) {
                return;
            }
            $themeName = $splitThemeAndPath[ 0 ];
            $path      = $splitThemeAndPath[ 1 ];
        } else {
            $themeName = $this->activeTheme;
            $path      = $splitThemeAndPath[ 0 ];
        }
        
        $themeInfo = $this->getThemeInfo($themeName);
        
        $themePath = ltrim($themeInfo->get('path'), base_path()) . '/';
        $assetPath = config('theme.folders.assets') . '/';
        $fullPath  = $themePath . $assetPath . $path;
        
        if ( !file_exists($fullPath) && $themeInfo->has('parent') ) {
            $themePath = ltrim($this->getThemeInfo($themeInfo->get('parent'))->get('path'), base_path()) . '/';
            $fullPath  = $themePath . $assetPath . $path;
            
            return $this->app[ 'url' ]->asset($fullPath, $secure);
        }
        
        return $this->app[ 'url' ]->asset($fullPath, $secure);
        
    }
    
    /**
     * Scan for all available themes
     *
     * @return void
     */
    private function scanThemes()
    {
        $themeDirectories = glob($this->basePath . '/*', GLOB_ONLYDIR);
        $themes           = [];
        foreach ( $themeDirectories as $themePath ) {
            $themeConfigPath    = $themePath . '/' . config('theme.config.name');
            $themeChangelogPath = $themePath . '/' . config('theme.config.changelog');
            
            if ( file_exists($themeConfigPath) ) {
                $themeConfig                = Config::load($themeConfigPath);
                $themeConfig[ 'changelog' ] = Config::load($themeChangelogPath)->all();
                $themeConfig[ 'path' ]      = $themePath;
                
                if ( $themeConfig->has('name') ) {
                    $themes[ $themeConfig->get('name') ] = $themeConfig;
                }
            }
        }
        $this->themes = $themes;
    }
    
    /**
     * Map view map for particular theme
     *
     * @param $theme
     */
    private function loadTheme( $theme )
    {
        if ( is_null($theme) ) {
            return;
        }
        
        $themeInfo = $this->getThemeInfo($theme);
        
        if ( is_null($themeInfo) ) {
            return;
        }
        
        $this->loadTheme($themeInfo->get('parent'));
        
        $viewPath = $themeInfo->get('path') . '/' . config('theme.folders.views');
        $langPath = $themeInfo->get('path') . '/' . config('theme.folders.lang');
        
        $this->finder->prependLocation($themeInfo->get('path'));
        $this->finder->prependLocation($viewPath);
        $this->finder->prependNamespace($themeInfo->get('name'), $viewPath);
        $this->lang->addNamespace($themeInfo->get('name'), $langPath);
    }
}