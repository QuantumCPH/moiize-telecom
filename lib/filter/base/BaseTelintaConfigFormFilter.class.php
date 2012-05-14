<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * TelintaConfig filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTelintaConfigFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'session' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'session' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('telinta_config_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelintaConfig';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'session' => 'Text',
    );
  }
}
