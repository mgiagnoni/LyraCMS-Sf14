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

    $ctype = $component->getComponentContentType();
    if($component->getModule())
    {
      $module = $component->getModule();
    }
    else
    {
      $module = $ctype->getModule();
    }
    $def_file = sfConfig::get('sf_apps_dir') . '/backend/modules/' . $module . '/config/components.yml';
    
    if(!file_exists($def_file) && $ctype->getPlugin())
    {
      $def_file = sfConfig::get('sf_plugins_dir') . '/' . $ctype->getPlugin() . '/modules/' . $ctype->getModule() . '/config/components.yml';
    }
    $this->config = new LyraParams($obj, $def_file);
    $this->config->setCatalog(sfInflector::underscore($module) . '_' . $component->getAction());
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
