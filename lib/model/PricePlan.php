<?php

class PricePlan extends BasePricePlan
{
    function __toString()
    {
            return $this->getTitle();
    }
}
