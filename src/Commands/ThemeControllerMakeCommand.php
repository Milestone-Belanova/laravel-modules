<?php

namespace Nwidart\Modules\Commands;

use Illuminate\Support\Str;


class ThemeControllerMakeCommand extends ControllerMakeCommand {
    protected $name = 'module:make-theme-controller';

    protected function getControllerName() {
        $controller = Str::studly($this->argument('controller'));

        if (Str::contains(strtolower($controller), 'controller') === false) {
            $controller .= 'ThemeController';
        }

        return $controller;
    }

    protected function getStubName() {
        return '/theme-controller.stub';
    }
}
