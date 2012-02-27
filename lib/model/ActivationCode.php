<?php

class ActivationCode extends BaseActivationCode
{
    public function generateCode($company_name = null){
        $this->setCode(rand(1000, 99999).sha1($company_name));
    }
}
