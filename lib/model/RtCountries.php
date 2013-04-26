<?php

class RtCountries extends BaseRtCountries
{
    public function __toString(){
		return $this->getTitle();
	}
}
