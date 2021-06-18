<?php

namespace Nwidart\Modules\Commands;

use Nwidart\Modules\Support\Stub;


class ThemeModelMakeCommand extends ModelMakeCommand {
    protected $name = 'module:make-theme-model';

    public function handle($create_theme_model = false): int {
        return parent::handle($create_theme_model);
    }

    protected function getTemplateContents() {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => 'Theme' . $this->getClass(),
            'PARENT_CLASS'      => $this->getClass(),
        ]))->render();
    }

    protected function getStubName() {
        return '/theme/model.stub';
    }
}
