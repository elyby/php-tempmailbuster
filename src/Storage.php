<?php
namespace Ely\TempMailBuster;

class Storage
{
    /**
     * @var array of string, which contains masks for temp mail services
     */
    private $blacklist;

    /**
     * @param array $blacklist
     */
    public function __construct(array $blacklist = [])
    {
        $this->blacklist = $blacklist;
    }

    /**
     * @return array with current blacklist
     */
    public function getBlacklist()
    {
        return $this->blacklist;
    }

    /**
     * @param string|array $items item or items, that will be merged to blacklist
     * @return static
     */
    public function appendToBlacklist($items)
    {
        $items = (array)$items;
        $this->blacklist = array_merge($this->blacklist, $items);

        return $this;
    }

    /**
     * @param array $items override current blacklist with passed values
     * @return static
     */
    public function setBlacklist(array $items)
    {
        $this->blacklist = $items;
        return $this;
    }
}
