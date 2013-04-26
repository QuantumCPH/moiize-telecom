<?php

class RtServices extends BaseRtServices
{
    public function __toString(){
		return $this->getTitle();
	}
}
