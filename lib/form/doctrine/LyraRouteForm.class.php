<?php

/**
 * LyraRoute form.
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class LyraRouteForm extends BaseLyraRouteForm
{
  protected $config = null;

  public function configure()
  {
    unset(
      $this['ctype_id'],
      $this['action'],
      $this['params']
    );

    //Embed form displaying configuration options
    $obj = $this->getObject();
    $ctype = $obj->getRouteContentType();

    $this->config = new LyraParamHolder($obj, 'lists/' . $obj->getAction() . '/other');
    $this->config->setCatalog(sfInflector::underscore($ctype->getModule()) . '_' . $obj->getAction() . '_params');
    $params_form = new LyraParamsForm(array(), array('config' => $this->config));
    $this->embedForm('lyra_params', $params_form);
    $this->widgetSchema['lyra_params']->setLabel(false);
    $this->widgetSchema->setNameFormat('content_view[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    //Save configuration parameters
    $item->setParams($this->config->checkValues($this->getValue('lyra_params')));
  }
  
}
