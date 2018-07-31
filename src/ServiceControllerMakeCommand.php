<?php

namespace DeepSpace9\Scaffolding;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ServiceControllerMakeCommand
 * @package DeepSpace9\Scaffolding
 */
class ServiceControllerMakeCommand extends ScaffoldingGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:serviceController';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    /**
     *
     */
    public function handle()
    {
        $replace=$this->buildModelReplacements([]);
        $replace=$this->buildServiceReplacements($replace);
        $replace=$this->buildServiceExceptionReplacements($replace);
        $this->replace=$replace;
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }
    }

    /**
     * @param array $replace
     * @return array
     */
    protected function buildServiceReplacements(array $replace)
    {
        $serviceClass = $this->parseService($this->option('service'));
        if (!class_exists($serviceClass)) {
            if ($this->confirm("A {$serviceClass} service does not exist. Do you want to generate it?", true)) {
                $this->call('make:service', ['name' => $serviceClass,'--model'=>$this->option('model'),
                    '--no_model_create'=>false]);
            }
        }

        return array_merge($replace, [
            'FullServiceClass' => $serviceClass,
            'ServiceClass' => class_basename($serviceClass),
            'ServiceVariable' => lcfirst(class_basename($serviceClass)),
        ]);
    }

    /**
     * @param $service
     * @return string
     */
    protected function parseService($service)
    {
        $service = trim(str_replace('/', '\\', $service), '\\');
        if (!Str::startsWith($service, $this->laravel->getNamespace()) && !Str::startsWith($service, $serviceNameSpace = 'Services')) {
            $service = $serviceNameSpace .'\\'. $service;
        }
        if (!Str::startsWith($service, $rootNamespace = $this->laravel->getNamespace())) {
            $service = $rootNamespace . $service;
        }
        return $service;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Generate a resource controller for the given model.'],
            ['service', 's', InputOption::VALUE_REQUIRED, 'Generate a resource controller for the given Service.'],
        ];
    }
}
