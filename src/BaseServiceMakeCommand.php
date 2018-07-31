<?php

namespace DeepSpace9\Scaffolding;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class BaseServiceMakeCommand
 * @package DeepSpace9\Scaffolding
 */
class BaseServiceMakeCommand extends ScaffoldingGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:baseService';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a base service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Base Service';


    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/baseService.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Base Service'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the Base Service already exists.']
        ];
    }
}
