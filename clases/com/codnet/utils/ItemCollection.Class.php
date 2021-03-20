<?php

class ItemCollection implements Iterator {

	private $_items = null;

	public function __construct() {
		$this->_items = array();
	}

	public function addItem($value, $index=null){
		if(empty( $index ))
		$this->_items[] = $value;
		else
		$this->_items[$index] = $value;
	}

	public function push($value){
		array_push($this->_items, $value);
	}

	public function removeItem($i){
		unset($this->_items[array_search($i, $this->_items)]);
	}

	public function removeItemByKey($key){
		unset($this->_items[$key]);
	}

	public function rewind() {
		reset($this->_items);
	}

	public function current() {
		return current($this->_items);
	}

	public function key() {
		return key($this->_items);
	}

	public function next() {
		return next($this->_items);
	}

	public function valid() {
		return $this->current() !== false;
	}

	public function isEmpty(){
		return empty( $this->_items );
	}

	public function existIndex($index){
		return array_key_exists( $index, $this->_items );
	}

	public function existObject($i){
		return in_array($i, $this->_items );
	}

	public function existObjectComparator($i, $comparator){
		foreach ($this->_items as $item){
			if ($comparator->equals($item,$i)) {
				return true;
			}
		}
		return false;
	}

	public function getObjectByIndex($index){
		return $this->_items[$index];
	}

	public function size(){
		return count($this->_items);
	}

}
