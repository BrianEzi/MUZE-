<?php

class Set implements IteratorAggregate {
	private array $array;

	public function __construct(array $array = null) {
		$this->array = $array ?? [];
	}

	public function add($item) {
		if (in_array($item, $this->array)) return;
		$this->array[] = $item;
	}

	public function getIterator(): ArrayIterator {
		return new ArrayIterator($this->array);
	}

	public function toArray(): array {
		return $this->array;
	}
}
