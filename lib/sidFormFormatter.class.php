<?php
 
class sidFormFormatter extends sfWidgetFormSchemaFormatter {
 
  protected 
    $rowFormat = "\n%error%\n<div class=\"formRow\">\n<div class=\"formLabel\">%label%</div>\n<div class=\"formField\">%field%\n%help%</div></div>\n%hidden_fields%",
    $helpFormat = '<div class="fieldHelp">%help%</div>', 
    $errorRowFormat = "<div>\n%errors%<br /></div>\n", 
    $errorListFormatInARow = "%errors%\n", 
    $errorRowFormatInARow =  "%error%\n", 
    $namedErrorRowFormatInARow = "%error%\n", 
    $decoratorFormat = "%content%";
 
  /**
   * @var sfValidatorSchema
   */
  protected $validatorSchema = null;
 
  /**
   * @var array
   */
  protected $params = array();
 
  /**
   * Constructor
   *
   * Params:
   *  - "required_label_class_name" css class name for label tag when the field is required field, the default is 'required'.
   *  - "required_label_format" default is '%label% <em class="required">*</em>'.
   *
   * @param sfWidgetFormSchema $widgetSchema
   * @param sfValidatorSchema $validatorSchema
   * @param array $params
   */
  public function __construct(sfWidgetFormSchema $widgetSchema, sfValidatorSchema $validatorSchema, $params = array())
  {
    $this->validatorSchema = $validatorSchema;
    $this->params = $params;
    parent::__construct($widgetSchema);
  }
 
  /**
   * Returns parameter identified with $name or if does not exist, returns $default.
   *
   * @param string $name
   * @param mixed $default
   * @return mixed
   */
  public function getParameter($name, $default=null)
  {
    if (!isset($this->params[$name]))
    {
      return $default;
    }
 
    return $this->params[$name];
  }
 
  /**
   * Generates a label for the given field name.
   *
   * @param  string $name        The field name
   * @param  array  $attributes  Optional html attributes for the label tag
   *
   * @return string The label tag
   */
  public function generateLabel($name, $attributes = array())
  {
    $is_required = false;
    if ( $this->validatorSchema and isset($this->validatorSchema[$name]) )
    {
      $validator = $this->validatorSchema[$name];
      /* @var $validator sfValidatorBase */
 
      if ( $validator->getOption('required') )
      {
        $class_name = $this->getParameter('required_label_class_name', 'required');
        if (isset($attributes['class'])) $attributes['class'] .= ' '.$class_name; else $attributes['class'] = $class_name;
        $is_required = true;
      }
    }
 
    $s = parent::generateLabel($name, $attributes);
 
    if ($is_required)
    {
      $format = $this->getParameter('required_label_format', '%label% <em class="required">*</em>');
      $s = str_replace('%label%', $s, $format);
    }
 
    return $s;
  }
}