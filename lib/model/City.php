<?php

class City extends BaseCity
{
	public function __toString(){
		return $this->getName();
	}
}
