<?php
namespace Ely\TempMailBuster;

interface StorageInterface
{
    /**
     * @return array with current items
     */
    public function getItems();

    /**
     * @param array $items replace current items with passed values
     * @return static
     */
    public function setItems($items);

    /**
     * @param string|array $items item or items, that will be merged to exists array of strings
     * @return static
     */
    public function appendItems($items);
}
