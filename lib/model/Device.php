<?php

class Device extends BaseDevice
{
	public function __toString()
	{
		return $this->getName();
	}
}
