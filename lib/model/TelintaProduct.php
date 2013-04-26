<?php

class TelintaProduct extends BaseTelintaProduct
{
    function __toString()
	{
		return $this->getTitle();
	}
}
