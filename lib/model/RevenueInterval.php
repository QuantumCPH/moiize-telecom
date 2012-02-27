<?php

class RevenueInterval extends BaseRevenueInterval
{
    public function __toString(){
        return $this->getMinRevenue(). ' - '. $this->getMaxRevenue(). ' kr';
    }
}
