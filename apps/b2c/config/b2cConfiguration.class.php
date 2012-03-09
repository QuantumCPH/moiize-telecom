<?php

class b2cConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  	//default error messages
  	sfValidatorBase::setRequiredMessage(('Please complete the fields'));
  }
}
