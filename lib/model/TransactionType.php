<?php

class TransactionType extends BaseTransactionType
{
    public function __toString(){
		return $this->getTitle();
	}
}
