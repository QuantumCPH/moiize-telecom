<?php

class CompanyType extends BaseCompanyType
{
    public function __toString(){
        return $this->getName();
    }
}
