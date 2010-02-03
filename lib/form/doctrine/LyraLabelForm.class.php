<?php

/**
 * LyraLabel form.
 *
 * @package    form
 * @subpackage LyraLabel
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LyraLabelForm extends BaseLyraLabelForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'],$this['label_articles_list'], $this['root_id'], $this['lft'], $this['rgt'], $this['level']);

    $this->widgetSchema['catalog_id'] = new sfWidgetFormInputHidden();

    $query = Doctrine_Query::create()->from('LyraLabel l');

    if($this->isNew()) {
        $catalog_id = $this->getOption('catalog_id');

        if($catalog_id) {
          $this->setDefault('catalog_id', $catalog_id);
          $query->where('l.catalog_id = ?', $catalog_id);
        }
    } else {
        $query->where('l.catalog_id = ? AND (l.lft < ? OR l.rgt > ?)', array($this->object->getCatalogId(), $this->object->getLft(), $this->object->getRgt()));
    }

    $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoice(array('model'=>'LyraLabel', 'order_by'=>array('root_id, lft', ''), 'method'=>'getIndentName', 'query'=>$query));
    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array('required'=>false, 'model'=>'LyraLabel'));
    if(!$this->isNew()) {
      $parent = $this->object->getNode()->getParent();
      $this->setDefault('parent_id', $parent->getId());
    }
    $this->widgetSchema->setLabel('name', 'NAME');
    $this->widgetSchema->setLabel('title', 'TITLE');
    $this->widgetSchema->setLabel('description', 'DESCRIPTION');
    $this->widgetSchema->setLabel('slug', 'SLUG');
    $this->widgetSchema->setLabel('meta_title','META_TITLE');
    $this->widgetSchema->setLabel('meta_descr','META_DESCR');
    $this->widgetSchema->setLabel('meta_keys','META_KEYS');
    $this->widgetSchema->setLabel('meta_robots','META_ROBOTS');
    $this->widgetSchema->setLabel('is_active','IS_ACTIVE');
    $this->widgetSchema->setLabel('parent_id', 'PARENT');

    $this->widgetSchema->setNameFormat('label[%s]');
  }
  protected function doSave($con = null)
  {
    $pparent_id = 0;
    if(!$this->isNew()) {
      $pparent_id = $this->getObject()->getNode()->getParent()->getId();
    }
    parent::doSave($con);
    if($pparent_id != $this->getValue('parent_id')) {
      $node = $this->object->getNode();
      $parent = $this->object->getTable()->find($this->getValue('parent_id'));
      $method = ($node->isValidNode() ? 'move' : 'insert').'AsFirstChildOf';
      $node->$method($parent);
    }
  }
}