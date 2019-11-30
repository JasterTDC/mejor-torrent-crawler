<?php


namespace BestThor\ScrappingMaster\Domain;

/**
 * Class BaseCollection
 *
 * @package BestThor\ScrappingMaster\Domain
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
class BaseCollection implements \IteratorAggregate
{
    /**
     * @var array
     */
    protected $collection;

    /**
     * @var array
     */
    protected $collectionById;

    /**
     * BaseCollection constructor.
     */
    public function __construct()
    {
        $this->collection       = [];
        $this->collectionById   = [];
    }

    protected function addToCollection(
        $element,
        $elementId
    ) {
        $this->collection[] = $element;
        $this->collectionById[$elementId] = $element;
    }

    /**
     * Get element in position
     *
     * @param   int $position
     *
     * @return  mixed
     */
    public function getItemInPosition(int $position)
    {
        return $this->collection[$position];
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->collection);
    }
}
