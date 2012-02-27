<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * InviteBonus filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseInviteBonusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'invite_id'   => new sfWidgetFormFilterInput(),
      'customer_id' => new sfWidgetFormFilterInput(),
      'bonus_paid'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'invite_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'customer_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bonus_paid'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('invite_bonus_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InviteBonus';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'invite_id'   => 'Number',
      'customer_id' => 'Number',
      'bonus_paid'  => 'Number',
    );
  }
}
