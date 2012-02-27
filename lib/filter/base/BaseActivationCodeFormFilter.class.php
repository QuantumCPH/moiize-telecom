<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ActivationCode filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseActivationCodeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id' => new sfWidgetFormPropelChoice(array('model' => 'Company', 'add_empty' => true)),
      'code'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'company_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Company', 'column' => 'id')),
      'code'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('activation_code_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ActivationCode';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'company_id' => 'ForeignKey',
      'code'       => 'Text',
    );
  }
}
