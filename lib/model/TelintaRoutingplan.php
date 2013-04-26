<?php

class TelintaRoutingplan extends BaseTelintaRoutingplan
{
    function __toString()
	{
		return $this->getTitle();
	}
}
