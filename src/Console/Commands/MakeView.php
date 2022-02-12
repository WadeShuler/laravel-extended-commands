<?php

namespace WadeShuler\ExtendedCommands\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeView extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:view';

    //protected $help = 'what foo';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name} {--stub= : Specify a custom stub to use for generation}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim('/app/Console/stubs/' . $stub, '/')))
            ? $customPath
            : __DIR__ . '/../../../stubs/' . $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath(
            $this->option('stub') ? $this->option('stub') . '.stub' : 'make-view.stub'
        );
    }

    /**
     * Replace the view filename for the given stub.
     *
     * @param  string  $stub
     * @param  string  $view
     * @return string
     */
    protected function replaceViewPlaceholders($stub, $view)
    {
        return str_replace(['{{ view }}', '{{view}}'], $view, $stub);
    }

    /**
     * Get the view name relative to the components directory.
     *
     * @return string view
     */
    protected function getView()
    {
        $name = str_replace('.blade.php', '', $this->argument('name'));
        $path = collect(explode('/', str_replace('.', '/', $name)));
        $path->add(Str::kebab($path->pop()));

        return $path->implode('/');
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $path = $this->viewPath($this->getView() . '.blade.php');

        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        if ($this->files->exists($path) && !$this->option('force')) {
            $this->error($path . ' already exists!');
            return;
        }

        $content = $this->replaceViewPlaceholders($this->files->get($this->getStub()), $path);

        $this->files->put($path, $content);

        $this->info('Created: ' . $path);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the view'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the view even if it already exists'],
            ['stub', null, InputOption::VALUE_REQUIRED, 'Specify a custom stub to use for generation'],
        ];
    }
}
