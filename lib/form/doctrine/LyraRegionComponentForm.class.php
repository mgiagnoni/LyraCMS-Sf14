<?php

/**
 * LyraRegionComponent form.
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LyraRegionComponentForm extends BaseLyraRegionComponentForm
{
  public function configure()
  {
    unset(
      $this['position'],
      $this['params']
    );

    //Embed form displaying configuration parameters
    $obj = $this->getObject();
    $component = $obj->getComponent();

    $this->config = new LyraParams($obj, $component->getParamDefinitionsPath());
    $this->config->setCatalog(sfInflector::underscore($component->getModuleName()) . '_' . $component->getAction());
    $params_form = new LyraParamsForm(array(), array('config' => $this->config, 'section' => $component->getAction()));
    $this->embedForm('lyra_params', $params_form);
    $this->widgetSchema['lyra_params']->setLabel(false);
    $this->widgetSchema->setNameFormat('component[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    //Save configuration parameters
    $item->setParams(serialize($this->config->checkValues($this->getValue('lyra_params'), $item->getComponent()->getAction())));

  }
}
