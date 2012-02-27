<?php
	class ManualRefillForm extends PaymentForm
	{

		public function __construct($customer_id)
		{
			$this->customer_id = $customer_id;
			parent::configure();
			self::configure();
		}

		public function configure()
		{

                    //------------------- Section For Get The Refill Options as per Country Base -----
                    $customer = new Criteria();
                    $customer->add(CustomerPeer::ID, $this->customer_id);
                    $customer = CustomerPeer::doSelectOne($customer);//->getId();
                    $country_id = $customer->getCountryId();
//echo $country_id;
                    //-----------------------------------
                    $countrylng = new Criteria();
                    $countrylng->add(EnableCountryPeer::ID, $country_id);
                    $countrylng = EnableCountryPeer::doSelectOne($countrylng);
                    $countryRefill = $countrylng->getRefill();
                    $countryRefill  = $countryRefill;
                    $countryRefill = explode(",", $countryRefill);

                    //----------------------------       End Code -----------------------------------
                        //$countryRefills[] = array();
                        foreach ($countryRefill as &$value) {
                           $countryRefills[$value] =  $value;
                        }

			$this->widgetSchema['extra_refill'] =
				new sfWidgetFormSelect(array(
					'choices'=>$countryRefills
				)
			);


			$c = new Criteria();
		  	$c->add(CustomerProductPeer::CUSTOMER_ID, $this->customer_id);
		  	$c->addJoin(ProductPeer::ID, CustomerProductPeer::PRODUCT_ID);

		  	$this->widgetSchema['customer_product'] = new sfWidgetFormPropelSelect(array('model'=>'Product', 'add_empty'=>false,'order_by'=>array('Name','asc'), 'criteria'=>$c));
		  	$this->validatorSchema['customer_product'] =  new sfValidatorPropelChoice(array(
    								'model'		=> 'Product',
    								'column'	=> 'id',
    								'criteria'	=> clone $c,
    							),array(
    								'required'	=> 'Please choose product',
    								'invalid'	=> 'Invalid product',
    							));

    		$this->validatorSchema['extra_refill'] = new sfValidatorChoice(array('choices'=>ProductPeer::getRefillChoices()));

    		$this->widgetSchema->setLabels(array(
    			'customer_product'=>'Product',
    			'extra_refill'=>'Select refill amount',
    		));


		}
	}
?>