<?php

class ApartmentForm extends BaseApartmentForm
{
    public function __toString(){
        return $this->getName();
    }
}
