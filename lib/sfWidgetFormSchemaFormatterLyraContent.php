<?php
class sfWidgetFormSchemaFormatterLyraContent extends sfWidgetFormSchemaFormatter
{
  protected
      $rowFormat = '<div class="row">%label%%field%%error%%help%%hidden_fields%</div>',
      $helpFormat = '<div class="field-help">%help%</div>';

  public function generateLabel($name, $attributes = array())
  {
    $labelName = $this->generateLabelName($name);

    if (false === $labelName)
    {
      return '';
    }
    //set a special class for boolean fields (is_active, is_featured, is_sticky) labels
    if(strpos($name, 'is_') === 0)
    {
      $attributes['class'] = 'field-bool';
    }
    
    if (!isset($attributes['for']))
    {
      $attributes['for'] = $this->widgetSchema->generateId($this->widgetSchema->generateName($name));
    }

    return $this->widgetSchema->renderContentTag('label', $labelName, $attributes);
  }
}
