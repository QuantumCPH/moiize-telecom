<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * TelintaAccounts filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTelintaAccountsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_table'  => new sfWidgetFormFilterInput(),
      'parent_id'     => new sfWidgetFormFilterInput(),
      'i_account'     => new sfWidgetFormFilterInput(),
      'account_title' => new sfWidgetFormFilterInput(),
      'i_customer'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'parent_table'  => new sfValidatorPass(array('required' => false)),
      'parent_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'i_account'     => new sfValidatorPass(array('required' => false)),
      'account_title' => new sfValidatorPass(array('required' => false)),
      'i_customer'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('telinta_accounts_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TelintaAccounts';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'parent_table'  => 'Text',
      'parent_id'     => 'Number',
      'i_account'     => 'Text',
      'account_title' => 'Text',
      'i_customer'    => 'Text',
    );
  }
}
