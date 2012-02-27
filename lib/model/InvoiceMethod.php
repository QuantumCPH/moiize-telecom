<?php

class InvoiceMethod extends BaseInvoiceMethod
{
	public function __toString(){
		return $this->getName();
	}
}
