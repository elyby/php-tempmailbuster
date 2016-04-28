<?php
namespace Ely\TempMailBuster;

interface LoaderInterface
{
    /**
     * Load data from some source and return array with strings
     *
     * @return array
     */
    public function load();
}
