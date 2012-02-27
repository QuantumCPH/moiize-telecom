<?php

class CommissionPeriod extends BaseCommissionPeriod
{
     public function __toString(){
        return $this->getNumberMonths(). ' Months';
    }
}
