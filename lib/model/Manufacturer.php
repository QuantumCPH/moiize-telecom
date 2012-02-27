<?php

class Manufacturer extends BaseManufacturer
{
	public function __toString()
	{
		return $this->getName();
	}
}
