<?php

namespace Nwidart\Modules\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;

class ThemeModelSubcomponentMakeCommand extends ModelSubcomponentMakeCommand {
    protected $name = 'module:make-theme-subcomponent-model';

    public function handle($create_theme_model = false): int {
        return parent::handle($create_theme_model);
    }

    protected function getTemplateContents() {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => 'Theme' . $this->getClass(),
            'PARENT_CLASS'      => $this->getClass(),
            'TABLE_NAME'        => Str::snake(Str::pluralStudly($this->getClass())),
        ]))->render();
    }

    protected function getStubName() {
        return '/theme/subcomponent-model.stub';
    }

    protected function getModelName() {
        return 'Theme' . Str::studly($this->argument('model'));
    }
}
