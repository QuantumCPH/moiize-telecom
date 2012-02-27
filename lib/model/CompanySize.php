<?php

class CompanySize extends BaseCompanySize
{
     public function __toString(){
        return $this->getName();
    }
}
