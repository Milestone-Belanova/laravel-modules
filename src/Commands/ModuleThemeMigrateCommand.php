<?php

namespace Nwidart\Modules\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\Generators\ModuleThemeGenerator;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleThemeMigrateCommand extends Command {

    protected $argumentName = 'module';

    protected $name = 'module:migrate-theme';

    protected $description = 'Migrates modules to use new theme elements.';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $names = $this->argument('names');
        $success = true;

        foreach ($names as $name) {
            $code = with(new ModuleThemeGenerator($name))
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['modules'])
                ->setConfig($this->laravel['config'])
                ->setActivator($this->laravel[ActivatorInterface::class])
                ->setConsole($this)
                ->setType($this->getModuleType($name))
                ->generate();

            if ($code === E_ERROR) {
                $success = false;
            }
        }

        return $success ? 0 : E_ERROR;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['names', InputArgument::IS_ARRAY, 'The names of module to be migrated.'],
        ];
    }

    /**
     * Get module type .
     *
     * @return string
     */
    private function getModuleType($name): string {
        if (Str::startsWith(strtolower($name), 'component')) {
            return 'component';
        }
        return 'web';
    }
}
