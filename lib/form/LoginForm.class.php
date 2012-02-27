<?php
class LoginForm extends sfForm {
    public function configure() {

        $this->setWidgets(array(
            'email' => new sfWidgetFormInput(),
            'password' => new sfWidgetFormInputPassword()));

        $this->setValidators(
            //new sfValidatorAnd(
                array('email' => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'email', 'required' => true),
                          array('required' => 'Invalid email','invalid' => 'Invalid email')),
                      'password' => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'password', 'required' => true),
                          array('required' => 'Invalid password','invalid' => 'Invalid password'))
                     )
              //  )
            );

        //$this->sfWidget->setLabel('email',__('email'));
        //$this->sfWidget->setLabel('password',__('password'));
        //$this->widgetSchema->setFormFormatterName('table');
        $this->widgetSchema->setNameFormat('login[%s]');

    }
}
?>