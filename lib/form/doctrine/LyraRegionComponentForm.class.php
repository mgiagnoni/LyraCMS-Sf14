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

    $this->config = new LyraParamHolder($obj);
    $this->config->setCatalog(sfInflector::underscore($component->getModuleName()) . '_' . $component->getAction());
    $params_form = new LyraParamsForm(array(), array('config' => $this->config));
    $this->embedForm('lyra_params', $params_form);
    $this->widgetSchema['lyra_params']->setLabel(false);

    $choices = array(0 => 'Hide on selected', 1 => 'Show on selected');
    $this->widgetSchema['vis_flag'] = new sfWidgetFormChoice(array(
        'choices' => $choices,
        'expanded' => true,
        'multiple' => false
    ));
    $this->validatorSchema['vis_flag'] = new sfValidatorChoice(array(
        'choices' => array_keys($choices),
        'required' => false
    ));
    $this->setDefault('show', 0);
    
    $choices = array();
    $content = Doctrine_Query::create()
      ->from('LyraContentType ct')
      ->leftJoin('ct.ContentTypeRoutes')
      ->orderBy('ct.type')
      ->execute(array(), Doctrine::HYDRATE_ARRAY);

    foreach($content as $c)
    {
      $t = $c['type'];
      $choices[$t. '.all'] = $t . ' all contents';
      $choices[$t. '.show'] = $t . ' all items';

      foreach($c['ContentTypeRoutes'] as $r)
      {
        $choices[$t . '.' . $r['action']] = $t . ' ' . $r['action'];
      }
    }

    $defaults = array();
    if(!$this->isNew())
    {
      $rs = Doctrine_Query::create()
      ->from('LyraComponentVisibility cv')
      ->select('cv.content')
      ->where('cv.component_id = ?')
      ->andWhere('cv.region_id = ?')
      ->execute(array($component->getId(), $obj->getRegion()->getId()), Doctrine::HYDRATE_ARRAY);

      foreach($rs as $r)
      {
        $defaults[] = $r['content'];
      }
    }
    $this->widgetSchema['content'] = new sfWidgetFormChoice(array(
      'choices' => $choices,
      'multiple' => true
    ));
    $this->setDefault('content', $defaults);
    
    $this->validatorSchema['content'] = new sfValidatorChoice(array(
      'choices' => array_keys($choices),
      'multiple' => true,
      'required' => false
    ));

    $this->widgetSchema->setNameFormat('component[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    //Save configuration parameters
    $item->setParams($this->config->checkValues($this->getValue('lyra_params')));

    $values = $this->validateVisibilityChoices($this->getValue('content'));
    $this->saveVisibilityChoices($values, $item->getRegion(), $item->getComponent());
  }
  protected function validateVisibilityChoices($values)
  {
    $valid = array();
    $r = array();

    foreach($values as $v)
    {
      list($content, $action) = explode('.', $v);
      if('all' == $action)
      {
        $r[] = $content;
      }
    }
    
    foreach($values as $v)
    {
      list($content, $action) = explode('.', $v);
      if('all' != $action && in_array($content, $r))
      {
        continue;
      }
      $valid[] = $v;
    }

    return $valid;
  }
  protected function saveVisibilityChoices($values, $region, $component)
  {
    $component_id = $component->getId();
    $region_id = $region->getId();

    $rs = Doctrine_Query::create()
      ->from('LyraComponentVisibility cv')
      ->select('cv.content')
      ->where('cv.component_id = ?')
      ->andWhere('cv.region_id = ?')
      ->execute(array($component_id, $region_id), Doctrine::HYDRATE_ARRAY);

    $existing = array();
    foreach($rs as $r)
    {
      $existing[] = $r['content'];
    }

    $delete = array_diff($existing, $values);

    if(count($delete))
    {
      Doctrine_Query::create()
        ->delete('LyraComponentVisibility cv')
        ->where('cv.component_id = ?')
        ->andWhere('cv.region_id = ?')
        ->whereIn('cv.content', $delete)
        ->execute(array($component_id, $region_id));
    }

    $create = array_diff($values, $existing);
    foreach($create as $c)
    {
      $record = new LyraComponentVisibility();
      $record->component_id = $component_id;
      $record->region_id = $region_id;
      $record->content = $c;
      $record->save();
    }

    return count($delete) || count($create);
  }
}
