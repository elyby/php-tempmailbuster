<?php
namespace Ely\TempMailBuster;

class Storage
{
    /**
     * @var array of strings, which contains masks for temp mail services
     */
    private $items;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array with current items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items override current items with passed values
     * @return static
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param string|array $items item or items, that will be merged to items
     * @return static
     */
    public function append($items)
    {
        $items = (array)$items;
        $this->items = array_merge($this->items, $items);

        return $this;
    }
}
