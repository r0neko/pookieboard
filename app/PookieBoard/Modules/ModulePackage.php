<?php

namespace App\PookieBoard\Modules;

use Composer\Autoload\ClassLoader;
use function Illuminate\Filesystem\join_paths;

class ModulePackage
{
    protected $name;
    protected $metadata;
    protected $packagePath;
    protected $active;
    protected $module;
    protected $autoloader;

    /**
     * @param $name
     * @param $metadata
     * @param $packagePath
     * @param $active
     */
    public function __construct($name, $metadata, $packagePath, $active = false)
    {
        $this->name = $name;
        $this->metadata = $metadata;
        $this->packagePath = $packagePath;
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        if($this->module == null) {
            $this->module = new ($this->getMetadata()->extra["module-class"])($this->active, $this->getPackagePath());
        }

        return $this->module;
    }

    /**
     * @return mixed
     */
    public function getAutoloader()
    {
        if($this->autoloader == null) {
            $this->autoloader = new ClassLoader();

            // autoload the package and add PSR-4 autoload mapping
            foreach($this->getMetadata()->autoload['psr-4'] as $psr4 => $psr4_path) {
                $this->autoloader->addPsr4($psr4, $this->getRelativePackagePath($psr4_path));
            }
        }

        return $this->autoloader;
    }

    public function isActive(): mixed
    {
        return $this->active;
    }

    public function getDescription(): string|null {
        return $this->metadata->description ?: null;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getPackagePath()
    {
        return $this->packagePath;
    }

    /**
     * @return string
     */
    public function getRelativePackagePath(string $path) {
        return join_paths($this->getPackagePath(), $path);
    }
}
