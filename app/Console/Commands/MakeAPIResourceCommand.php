<?php

namespace App\Console\Commands;

use Alibori\LaravelApiResourceGenerator\Console\GenerateApiResourceCommand;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * laravel-api-resource-generatorの生成ファイルをカスタムするためのコマンド
 */
class MakeAPIResourceCommand extends GenerateApiResourceCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-resource {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api resource';

    /**
     * @var string
     */
    protected string $stub = __DIR__ . '/stubs/api-resource.php.stub';

    /**
     * @throws BindingResolutionException
     * @throws \Doctrine\DBAL\Exception
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $this->dir = $this->defaultResourcesDir();

        $model = $this->loadModel($this->argument('model'));

        $arguments = explode('/', $this->argument('model'));
        array_pop($arguments);
        $dir = implode('\\', $arguments);
        if ($dir !== '') {
            $dir = '\\' . $dir;
        }
        $this->namespace = config('apiresourcegenerator.resources.namespace') . $dir;

        $this->getPropertiesFromTable($model);

        $this->generateResource($model);
    }

    protected function defaultResourcesDir(): string
    {
        $arguments = explode('/', $this->argument('model'));
        array_pop($arguments);
        $dir = implode('/', $arguments);
        return config('apiresourcegenerator.resources.dir') . '/' . $dir;
    }

    /**
     * @throws BindingResolutionException
     */
    protected function loadModel(string $model): Model
    {
        $arguments = explode('/', $model);
        $model = array_pop($arguments);
        return $this->laravel->make(config('apiresourcegenerator.models.namespace') . '\\' . $model);
    }

    /**
     * @throws FileNotFoundException
     */
    protected function buildResource(string $name): string
    {
        $properties = $this->properties;
        $doc_block = $this->generatePHPDocs();
        $fields = '';
        $arguments = explode('/', $this->argument('model'));
        $model = array_pop($arguments);

        $properties_length = count($properties);
        $count = 0;
        foreach ($properties as $property) {
            $array_key = $property;

            if ('camelCase' === $this->return_case) {
                $array_key = Str::camel($property);
            }

            if ($count < 1) {
                $fields .= "'{$array_key}' => \$this->{$property},\n";
            } elseif ($count < $properties_length - 1) {
                $fields .= "\t\t\t'{$array_key}' => \$this->{$property},\n";
            } else {
                $fields .= "\t\t\t'{$array_key}' => \$this->{$property}";
            }

            ++$count;
        }

        $stub = $this->files->get($this->stub);

        $stub = str_replace('{{ docblock }}', $doc_block, $stub);
        $stub = str_replace('{{ class }}', $name . 'Resource', $stub);
        $stub = str_replace('{{ namespace }}', $this->namespace, $stub);
        $stub = str_replace('{{ model }}', $model, $stub);
        return str_replace('{{ fields }}', $fields, $stub);
    }
}
