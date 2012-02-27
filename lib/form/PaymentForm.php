<?php

class PaymentForm extends sfForm
{
	public function configure() 
	{
		//set months
		$months = array();
		
		for ($i=1; $i<=12; $i++)
		{
			$months[$i] = $i;
		}
					
		//set years
		//TODO: remove previous years
		$years = array();
		
		$starting_year = intval(date('y'))-10;
		$ending_year = intval(date('y'))+10;
		
		for ($i=$ending_year; $i>=$starting_year; $i--)
		{
			$years[$i] = $i;
		}
		
		//setting widgets
		
		$this->setWidgets(array(
			'quantity'=>new sfWidgetFormInput(),
			'cardno'=>new sfWidgetFormInput(array(), array('autocomplete' => 'off')),
			'expmonth'=>new sfWidgetFormChoice(array('choices'=>$months)),
			'expyear'=> new sfWidgetFormChoice(array('choices'=>$years)),
			'cvc'=>new sfWidgetFormInput(array(), array('autocomplete' => 'off')),
			/*
			'extra_refill' => new sfWidgetFormChoice(array(
								'choices'=>ProductPeer::getRefillHashChoices(),
								'expanded'=>true,
							)),
			*/
			'cardtype' => new sfWidgetFormChoice(array(
								'choices'=>TransactionPeer::$credit_card_types,
							)),
			'user_attr_1' => new sfWidgetFormInputCheckbox(
								array('value_attribute_value'=>1)
							),
			'user_attr_2' => new sfWidgetFormChoice(array(
								'choices'=>ProductPeer::getRefillHashChoices(),
								'expanded'=>false,
							)),
			'user_attr_3'=> new sfWidgetFormChoice(array(
								'choices'=>ProductPeer::getAutoRefillLowerLimitHashChoices(),
								'expanded'=>false,
							)),
		));
		
		$this->getWidget('quantity')->setAttribute('readonly','readonly');
  		
		
		//setting validators
		
		$this->setValidators(array(
			'quantity'=> new sfValidatorNumber(array('min'=>1)),
			'cardno' => new sfValidatorString(array('max_length'=>14)),
			/*
			'extra_refill' => new sfValidatorChoice( array(
								'choices'=>array_keys(ProductPeer::getRefillHashChoices())
							)),
			*/
			'cardtype' => new sfValidatorChoice( array(
				'choices' => array_keys(TransactionPeer::$credit_card_types)				
			))
		));
		
		//setting labels
		
		$this->widgetSchema->setLabels(array(
			'cardno'=>'Enter credit card no.',
			'expmonth'=>'Enter expire month:',
			'expyear'=>'Enter expire year:',
			'cvc'=>'CVC',
			/*
			'extra_refill'=>'Select extra talk time',
			*/
			'cardtype'=>'Card Type',
		));
		
		$this->setDefaults( array(
			'quantity'=> 1,
			/*
			'extra_refill',ProductPeer::$autorefill_choices[0],
			*/
		));
	}
}