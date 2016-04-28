<?php
namespace Ely\TempMailBuster;

class Storage implements StorageInterface
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
     * @inheritdoc
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function setItems($items)
    {
        $this->items = (array)$items;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function appendItems($items)
    {
        $items = (array)$items;
        $this->items = array_merge($this->items, $items);

        return $this;
    }
}
