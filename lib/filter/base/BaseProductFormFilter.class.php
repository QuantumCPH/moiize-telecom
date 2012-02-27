<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Product filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(),
      'price'                 => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'initial_balance'       => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'is_extra_fill_applied' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'include_in_zerocall'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_in_store'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'sms_code'              => new sfWidgetFormFilterInput(),
      'country'               => new sfWidgetFormFilterInput(),
      'refill'                => new sfWidgetFormFilterInput(),
      'country_id'            => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'refill_options'        => new sfWidgetFormFilterInput(),
      'product_order'         => new sfWidgetFormFilterInput(),
      'product_type_package'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'product_country_us'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'registration_fee'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'price'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description'           => new sfValidatorPass(array('required' => false)),
      'initial_balance'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'is_extra_fill_applied' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'include_in_zerocall'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_in_store'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'sms_code'              => new sfValidatorPass(array('required' => false)),
      'country'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'refill'                => new sfValidatorPass(array('required' => false)),
      'country_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EnableCountry', 'column' => 'id')),
      'refill_options'        => new sfValidatorPass(array('required' => false)),
      'product_order'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'product_type_package'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'product_country_us'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'registration_fee'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'price'                 => 'Number',
      'description'           => 'Text',
      'initial_balance'       => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'is_extra_fill_applied' => 'Boolean',
      'include_in_zerocall'   => 'Boolean',
      'is_in_store'           => 'Boolean',
      'sms_code'              => 'Text',
      'country'               => 'Number',
      'refill'                => 'Text',
      'country_id'            => 'ForeignKey',
      'refill_options'        => 'Text',
      'product_order'         => 'Number',
      'product_type_package'  => 'Boolean',
      'product_country_us'    => 'Boolean',
      'registration_fee'      => 'Number',
    );
  }
}
