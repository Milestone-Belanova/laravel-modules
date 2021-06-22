<?php

namespace Nwidart\Modules\Commands;

use Nwidart\Modules\Support\Migrations\NameParser;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;

class MigrationSubcomponentMakeCommand extends MigrationMakeCommand {
    protected $name = 'module:make-subcomponent-migration';

    protected function getOptions() {
        return array_merge(
            parent::getOptions(),
            [
                ['parent', 'p', InputOption::VALUE_REQUIRED, 'The name of the parent table.'],
            ],
        );
    }

    protected function getTemplateContents() {
        $parser = new NameParser($this->argument('name'));

        return Stub::create('/migration/create-subcomponent.stub', [
            'CLASS' => $this->getClass(),
            'TABLE' => $parser->getTableName(),
            'PARENT_TABLE' => $this->option('parent'),
            'FIELDS' => $this->getSchemaParser()->render(),
        ]);
    }

    protected function getSchemaName() {
        return 'sub' . $this->argument('name');
    }
}
