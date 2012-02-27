<?php

class Country extends BaseCountry
{
	public function __toString(){
		return $this->getName();
	}
}
