<?php

namespace DeepSpace9\Scaffolding;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ServiceExceptionMakeCommand
 * @package DeepSpace9\Scaffolding
 */
class ServiceExceptionMakeCommand extends ScaffoldingGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:serviceException';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service Exception class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Exception';


    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/serviceException.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Exceptions';
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Service'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the Service Exception already exists.']
        ];
    }
}
