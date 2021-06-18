<?php

namespace Nwidart\Modules\Commands;

use Nwidart\Modules\Support\Stub;


class ThemeControllerMakeCommand extends ControllerMakeCommand {
    protected $name = 'module:make-theme-controller';

    protected function getControllerName() {
        return 'Theme' . parent::getControllerName();
    }

    public function handle(): int {
        return GeneratorCommand::handle();
    }

    protected function getTemplateContents() {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getControllerNameWithoutNamespace(),
            'PARENT_CLASS'      => class_basename(parent::getControllerName()),
        ]))->render();
    }

    protected function getStubName() {
        return '/theme/controller.stub';
    }
}
