<?php

namespace Nwidart\Modules\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Stub;


class ThemeControllerMakeCommand extends ControllerMakeCommand {
    protected $name = 'module:make-theme-controller';

    protected function getParentControllerName() {
        $controller = Str::studly($this->argument('controller'));

        if (Str::contains(strtolower($controller), 'controller') === false) {
            $controller .= 'Controller';
        }

        return $controller;
    }

    protected function getControllerName() {
        return 'Theme' . $this->getParentControllerName();
    }

    public function handle(): int {
        return GeneratorCommand::handle();
    }

    protected function getTemplateContents() {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getControllerNameWithoutNamespace(),
            'PARENT_CLASS'      => class_basename($this->getParentControllerName()),
        ]))->render();
    }

    protected function getStubName() {
        return '/theme-controller.stub';
    }
}
