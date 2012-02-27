<?php

class CustomerType extends BaseCustomerType
{
	public function __toString(){
		return $this->getName();
	}
}
