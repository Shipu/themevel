<?php

namespace Shipu\Themevel\Console;

use Illuminate\Console\Command;
use Shipu\Themevel\Contracts\ThemeContract;

class ThemeListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all available themes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $themes = $this->laravel[ThemeContract::class]->all();
        $headers = ['Name', 'Author', 'Version', 'Parent'];
        $output = [];
        foreach ($themes as $theme) {
            $output[] = [
                'Name'    => $theme->get('name'),
                'Author'  => $theme->get('author'),
                'version' => $theme->get('version'),
                'parent'  => $theme->get('parent'),
            ];
        }
        $this->table($headers, $output);
    }
}
