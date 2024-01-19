<?php

namespace App\PookieBoard\Modules;

use Illuminate\Console\Concerns;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Abstract Module class which contains basic functions that will be called accordingly when the module is managed.
 */
abstract class AbstractModule {
    /*
     * Allow console interaction through this trait exposed by Illuminate.
     */
    use Concerns\InteractsWithIO;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var string
     */
    private $basePath;

    final public function __construct(bool $active, string $basePath) {
        $this->active = $active;
        $this->basePath = $basePath;

        $this->output = new ConsoleOutput();
    }

    final public function isActive() : bool {
        return $this->active;
    }

    public function update(): void
    {
    }

    public function postUpdate(): void
    {
    }

    public function activate(): void
    {
    }

    public function deactivate(): void
    {
    }
}
