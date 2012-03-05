<?php
class CompanyLoginForm extends sfForm {
    public function configure() {

        $this->setWidgets(array(
            'vat_no' => new sfWidgetFormInput(),
            'password' => new sfWidgetFormInputPassword()));

        $this->setValidators(
            //new sfValidatorAnd(
                array('vat_no' => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'vat_no', 'required' => true),
                          array('required' => 'Invalid vat_no','invalid' => 'Invalid vat_no')),
                      'password' => new sfValidatorPropelChoice(array('model' => 'Company', 'column' => 'password', 'required' => true),
                          array('required' => 'Invalid password','invalid' => 'Invalid password'))
                     )
              //  )
            );

      
        $this->widgetSchema->setNameFormat('login[%s]');

    }
}
?>