<?php
class AgentLoginForm extends sfForm {
    public function configure() {

        $this->setWidgets(array(
            'username' => new sfWidgetFormInput(),
            'password' => new sfWidgetFormInputPassword()));

        $this->setValidators(
            //new sfValidatorAnd(
                array('username' => new sfValidatorPropelChoice(array('model' => 'AgentUser', 'column' => 'username', 'required' => true),
                          array('required' => 'Invalid username','invalid' => 'Invalid username')),
                      'password' => new sfValidatorPropelChoice(array('model' => 'AgentUser', 'column' => 'password', 'required' => true),
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