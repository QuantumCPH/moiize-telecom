<?php

class SaleActivityStatus extends BaseSaleActivityStatus
{
	public function __toString()
	{
		return $this->getName();
	}
}
