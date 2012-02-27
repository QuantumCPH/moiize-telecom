<?php

class InvoiceStatus extends BaseInvoiceStatus
{
	function __toString()
	{
		return $this->getName();
	}
}
