<?php

namespace Isolar\Collection;

abstract class AbstractCollection implements \Countable, \Iterator, \ArrayAccess
{
    /**
     * Stores all the entries.
     * 
     * @var array
     */
    protected $values = [];

    /**
     * Stores the current iteration.
     * 
     * @var int
     */
    protected $iterator = 0;

    /**
     * Creates a new collection.
     * 
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $value) {
            $this->offsetSet(null, $value);
        }
    }

    /**
     * Returns the amount of entries.
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->values);
    }

    /**
     * Resets the iterator.
     * 
     * @return void
     */
    public function rewind(): void
    {
        $this->iterator = 0;
    }

    /**
     * Returns the current iteration.
     * 
     * @return int
     */
    public function key(): int
    {
        return $this->iterator;
    }

    /**
     * Returns the current entry.
     * 
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->values[$this->iterator];
    }

    /**
     * Goes to the next entry.
     * 
     * @return void
     */
    public function next(): void
    {
        $this->iterator++;
    }

    /**
     * Checks if the current iteration is valid.
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return array_key_exists($this->iterator, $this->values);
    }

    /**
     * Checks if the given offset exists.
     * 
     * @param int $offset
     * 
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->values[$offset]);
    }

    /**
     * Returns the entry with the given offset.
     * 
     * @param int $offset
     * 
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->values[$offset];
    }

    /**
     * Adds new entries.
     * 
     * @param int $offset
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (empty($offset)) {
            $this->values[] = $value;

            return;
        }

        $this->values[$offset] = $value;
    }

    /**
     * Removes an entry.
     * 
     * @param int $offset
     * 
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }
}