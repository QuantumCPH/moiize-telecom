<?php

class ProductPeer extends BaseProductPeer
{
	public static $autorefill_choices = array(100, 200, 300);
	public static function getRefillChoices(){
		return array(100, 200, 300);
	}
	public static function getRefillHashChoices(){
		return array('100' => 100, '200' => 200, '500'=> 500);
	}
	
	public static function getAutoRefillLowerLimitHashChoices()
	{
		$limits = array(25, 50);
		 
		return array_combine($limits, $limits);
	}
}
