<?php
namespace Ely\TempMailBuster;

use Exception;

class Loader
{
    public static function getPaths()
    {
        return [
            __DIR__ . '/../vendor/ely/anti-tempmail-repo/data.json',
            __DIR__ . '/../../anti-tempmail-repo/data.json',
        ];
    }

    public static function load()
    {
        $paths = static::getPaths();
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
}
