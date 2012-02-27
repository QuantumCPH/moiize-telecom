<?php

/**
 * RevenueInterval form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class BaseRevenueIntervalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'min_revenue' => new sfWidgetFormInput(),
      'max_revenue' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'RevenueInterval', 'column' => 'id', 'required' => false)),
      'min_revenue' => new sfValidatorInteger(),
      'max_revenue' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('revenue_interval[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RevenueInterval';
  }


}
