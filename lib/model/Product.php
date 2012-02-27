<?php

class Product extends BaseProduct
{
	function __toString()
	{
		return $this->getName();
	}

         function getTotalAmount(){
            return $this->getPrice()+$this->getRegistrationFee();
        }
}
