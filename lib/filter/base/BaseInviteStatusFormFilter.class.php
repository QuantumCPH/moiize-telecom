<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * InviteStatus filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseInviteStatusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'status' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'status' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invite_status_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InviteStatus';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'status' => 'Text',
    );
  }
}
