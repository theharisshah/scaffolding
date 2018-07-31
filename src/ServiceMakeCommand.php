<?php

namespace DeepSpace9\Scaffolding;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ServiceMakeCommand
 * @package DeepSpace9\Scaffolding
 */
class ServiceMakeCommand extends ScaffoldingGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $modelCreate=true;
        if(!empty($this->hasOption('no_model_create')))
           $modelCreate=false;
        $replace=$this->buildModelReplacements([],$modelCreate);
        $replace=$this->buildServiceExceptionReplacements($replace);
        $replace=$this->buildBaseServiceReplacements($replace);
        $this->replace=$replace;
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/service.stub';
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
            ['name', InputArgument::REQUIRED, 'The name of the Service'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Generate a Service for the given model.'],
            ['no_model_create', 'm_c', InputOption::VALUE_OPTIONAL, 'Generate a Service for the given model.'],
        ];
    }
}
