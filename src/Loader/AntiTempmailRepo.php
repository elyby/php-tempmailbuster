<?php
namespace Ely\TempMailBuster\Loader;

use Ely\TempMailBuster\LoaderInterface;
use Exception;

/**
 * Class-wrapper for https://github.com/elyby/anti-tempmail-repo data file
 */
class AntiTempmailRepo implements LoaderInterface
{
    /**
     * @var array with custom paths to find data file
     */
    private $customPaths;

    /**
     * @param array $customPaths
     */
    public function __construct(array $customPaths = [])
    {
        $this->customPaths = $customPaths;
    }

    /**
     * @inheritdoc
     */
    public function load()
    {
        $paths = $this->getPaths();
        $dataPath = null;
        foreach($paths as $path) {
            if (file_exists($path)) {
                $dataPath = $path;
                break;
            }
        }

        if ($dataPath === null) {
            throw new Exception('Cannot find data file. Please check getPaths() implementation.');
        }

        $data = json_decode(file_get_contents($dataPath), true);
        if (!is_array($data)) {
            throw new Exception('Cannot decode json from data file.');
        }

        return $data;
    }

    /**
     * Generates file path array to data repository.
     *
     * Default paths are used in following cases:
     * 1. if this library and data repository are included in project as composer dependencies;
     * 2. if this library is deployed for development (data repository included as composer dependency to this library).
     *
     * @see Loader::customPath for custom data repository implementation
     *
     * @return array
     */
    protected function getPaths()
    {
        return array_merge($this->customPaths, [
            __DIR__ . '/../../../anti-tempmail-repo/data.json',
            __DIR__ . '/../../vendor/ely/anti-tempmail-repo/data.json',
        ]);
    }
}
