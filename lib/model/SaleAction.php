<?php

class SaleAction extends BaseSaleAction
{
	public function __toString(){
		return $this->getName();
	}
}
