<?php

namespace Shipu\Themevel\Console;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;

class ThemeGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Theme Folder Structure';

    /**
     * Filesystem.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Config.
     *
     * @var \Illuminate\Support\Facades\Config
     */
    protected $config;

    /**
     * Theme Folder Path.
     *
     * @var string
     */
    protected $themePath;

    /**
     * Create Theme Info.
     *
     * @var array
     */
    protected $theme;

    /**
     * Created Theme Structure.
     *
     * @var array
     */
    protected $themeFolders;

    /**
     * Theme Stubs.
     *
     * @var string
     */
    protected $themeStubPath;

    /**
     * ThemeGeneratorCommand constructor.
     *
     * @param Repository $config
     * @param File       $files
     */
    public function __construct(Repository $config, File $files)
    {
        $this->config = $config;

        $this->files = $files;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->themePath = $this->config->get('theme.theme_path');
        $this->theme['name'] = strtolower($this->argument('name'));

        $createdThemePath = $this->themePath.'/'.$this->theme['name'];

        if ($this->files->isDirectory($createdThemePath)) {
            return $this->error('Sorry Boss '.ucfirst($this->theme['name']).' Theme Folder Already Exist !!!');
        }

        $this->consoleAsk();

        $this->themeFolders = $this->config->get('theme.folders');
        $this->themeStubPath = $this->config->get('theme.stubs.path');

        $themeStubFiles = $this->config->get('theme.stubs.files');
        $themeStubFiles['theme'] = $this->config->get('theme.config.name');
        $themeStubFiles['changelog'] = $this->config->get('theme.config.changelog');

        $this->makeDir($createdThemePath);

        foreach ($this->themeFolders as $key => $folder) {
            $this->makeDir($createdThemePath.'/'.$folder);
        }

        $this->createStubs($themeStubFiles, $createdThemePath);

        $this->info(ucfirst($this->theme['name']).' Theme Folder Successfully Generated !!!');
    }

    /**
     * Console command ask questions.
     *
     * @return void
     */
    public function consoleAsk()
    {
        $this->theme['title'] = $this->ask('What is theme title?');

        $this->theme['description'] = $this->ask('What is theme description?', false);
        $this->theme['description'] = !$this->theme['description'] ? '' : title_case($this->theme['description']);

        $this->theme['author'] = $this->ask('What is theme author name?', false);
        $this->theme['author'] = !$this->theme['author'] ? 'Shipu Ahamed' : title_case($this->theme['author']);

        $this->theme['version'] = $this->ask('What is theme version?', false);
        $this->theme['version'] = !$this->theme['version'] ? '1.0.0' : $this->theme['version'];
        $this->theme['parent'] = '';
        $this->theme['css'] = '';
        $this->theme['js'] = '';

        if ($this->confirm('Any parent theme?')) {
            $this->theme['parent'] = $this->ask('What is parent theme name?');
            $this->theme['parent'] = strtolower($this->theme['parent']);
        }
    }

    /**
     * Create theme stubs.
     *
     * @param array  $themeStubFiles
     * @param string $createdThemePath
     */
    public function createStubs($themeStubFiles, $createdThemePath)
    {
        foreach ($themeStubFiles as $filename => $storePath) {
            if ($filename == 'changelog') {
                $filename = 'changelog'.pathinfo($storePath, PATHINFO_EXTENSION);
            } elseif ($filename == 'theme') {
                $filename = pathinfo($storePath, PATHINFO_EXTENSION);
            } elseif ($filename == 'css' || $filename == 'js') {
                $this->theme[$filename] = ltrim($storePath,
                    rtrim($this->config->get('theme.folders.assets'), '/').'/');
            }
            $themeStubFile = $this->themeStubPath.'/'.$filename.'.stub';
            $this->makeFile($themeStubFile, $createdThemePath.'/'.$storePath);
        }
    }

    /**
     * Make directory.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function makeDir($directory)
    {
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0777, true);
        }
    }

    /**
     * Make file.
     *
     * @param string $file
     * @param string $storePath
     *
     * @return void
     */
    protected function makeFile($file, $storePath)
    {
        if ($this->files->exists($file)) {
            $content = $this->replaceStubs($this->files->get($file));

            $this->files->put($storePath, $content);
        }
    }

    /**
     * Replace Stub string.
     *
     * @param string $contents
     *
     * @return string
     */
    protected function replaceStubs($contents)
    {
        $mainString = [
            '[NAME]',
            '[TITLE]',
            '[DESCRIPTION]',
            '[AUTHOR]',
            '[PARENT]',
            '[VERSION]',
            '[CSSNAME]',
            '[JSNAME]',
        ];
        $replaceString = [
            $this->theme['name'],
            $this->theme['title'],
            $this->theme['description'],
            $this->theme['author'],
            $this->theme['parent'],
            $this->theme['version'],
            $this->theme['css'],
            $this->theme['js'],
        ];

        $replaceContents = str_replace($mainString, $replaceString, $contents);

        return $replaceContents;
    }
}
