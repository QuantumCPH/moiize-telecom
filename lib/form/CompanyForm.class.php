<?php

/**
 * Company form.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: CompanyForm.class.php,v 1.1 2010-05-25 13:15:34 orehman Exp $
 */
class CompanyForm extends BaseCompanyForm
{
  public function configure()
  {
      // build city criteria
   	//$cityC = new Criteria();
  	//$cityC->add(CityPeer::COUNTRY_ID, $this->getObject()->getCountryId());

        $this->widgetSchema['created_at']               = new sfWidgetFormInputHidden();
        $this->widgetSchema['confirmed_at']             = new sfWidgetFormInputHidden();
        $this->widgetSchema['sim_card_dispatch_date']   = new sfWidgetFormInputHidden();
        $this->widgetSchema['agent_company_id']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['account_manager_id']       = new sfWidgetFormInputHidden();

   /*  	$this->widgetSchema['country_id']               = new sfWidgetFormPropelSelect(array('model'=>'Country','add_empty'=>'Select Country','order_by'=>array('Name','asc')));
  	$this->widgetSchema['city_id']                  = new sfWidgetFormPropelSelect(array('model'=>'City','add_empty'=>'Select City','order_by'=>array('Name','asc')));

       $this->validatorSchema['country_id'] = new sfValidatorPropelChoice(array(
    								'model'		=> 'Country',
    								'column'	=> 'id',
    							),array(
    								'required'	=> 'Please choose country',
    								'invalid'	=> 'Invalid country',
    							));
        $this->validatorSchema['city_id'] =  new sfValidatorPropelChoice(array(
                                                                'model'		=> 'City',
                                                                'column'	=> 'id',
                                                               
                                                        ),array(
                                                                'required'	=> 'Please choose city',
                                                                'invalid'	=> 'Invalid city',
                                                        ));

     
      $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(new sfValidatorPropelUnique(
    							array(
    								'model' => 'company',
    								'column' => 'cvr_number'
    							),array(
    								'required' => 'Please enter valid e-mail address',
    								'invalid' => 'CVR Number already existing'
    							))
    							))
    							);*/
        $this->widgetSchema->setLabel('apartment_form_id', 'Apartment form');
	$this->widgetSchema->setLabel('invoice_method_id', 'Invoice method');
	$this->widgetSchema->setLabel('customer_type_id', 'Customer type');
        $this->widgetSchema->setLabel('company_type_id', 'Company type');
        $this->widgetSchema->setLabel('company_size_id', 'Company size');
        $this->widgetSchema->setLabel('status_id', 'Status');
        $this->widgetSchema->setLabel('company_size_id', 'Company size');
        $this->widgetSchema->setLabel('country_id', 'Country');
        $this->widgetSchema->setLabel('city_id', 'City');

        $this->mergeForm(new CompanyBankForm());
        $this->mergeForm(new ProductOrderForm());
  }
}
