<?php
namespace DeepSpace9\Scaffolding;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Class ScaffoldingGeneratorCommand
 * @package DeepSpace9\Scaffolding
 */
abstract class ScaffoldingGeneratorCommand extends GeneratorCommand
{
    /**
     * @var array
     */
    protected $contents=[];
    /**
     * @var array
     */
    protected $replace=[];

    /**
     * @param string $name
     * @return mixed
     */
    protected function buildClass($name)
    {
        return str_replace(
            array_keys($this->replace), array_values($this->replace), parent::buildClass($name)
        );
    }

    /**
     * @param array $replace
     * @param bool $createModel
     * @return array
     */
    protected function buildModelReplacements(array $replace, $createModel = true)
    {
        $modelClass = $this->parseModel($this->option('model'));
        if (!class_exists($modelClass) && $createModel) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return array_merge($replace, [
            'FullModelClass' => $modelClass,
            'ModelClass' => class_basename($modelClass),
            'ModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * @param $model
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (!Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }

    /**
     * @param $replace
     * @return array
     */
    protected function buildServiceExceptionReplacements($replace)
    {
        $serviceException = $this->parseServiceException();
        if (!class_exists($serviceException)) {
            $this->call('make:serviceException', ['name' => $serviceException]);
        }

        return array_merge($replace, [
            'FullServiceExceptionClass' => $serviceException,
            'ServiceExceptionClass' => class_basename($serviceException),
            'ServiceExceptionVariable' => lcfirst(class_basename($serviceException)),
        ]);
    }

    /**
     * @param $replace
     * @return array
     */
    protected function buildBaseServiceReplacements($replace)
    {
        $baseService = $this->parseBaseService();
        if (!class_exists($baseService)) {
            $this->call('make:baseService', ['name' => $baseService]);
        }

        return array_merge($replace, [
            'FullBaseServiceClass' => $baseService,
            'BaseServiceClass' => class_basename($baseService)
        ]);
    }

    /**
     * @return string
     */
    protected function parseServiceException()
    {
        $serviceException = 'Exceptions\ServiceException';
        if (!Str::startsWith($serviceException, $rootNamespace = $this->laravel->getNamespace())) {
            $serviceException = $rootNamespace . $serviceException;
        }
        return $serviceException;
    }

    /**
     * @return string
     */
    protected function parseBaseService()
    {
        $serviceException = 'Services\Service';
        if (!Str::startsWith($serviceException, $rootNamespace = $this->laravel->getNamespace())) {
            $serviceException = $rootNamespace . $serviceException;
        }
        return $serviceException;
    }
}