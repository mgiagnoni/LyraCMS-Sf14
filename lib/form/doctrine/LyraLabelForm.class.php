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
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['label_articles_list'],
      $this['root_id'],
      $this['lft'],
      $this['rgt'],
      $this['level'],
      $this['meta_title'],
      $this['meta_descr'],
      $this['meta_keys'],
      $this['meta_robots']
    );

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
    $this->widgetSchema->setLabel('is_active','IS_ACTIVE');
    $this->widgetSchema->setLabel('parent_id', 'PARENT');

    //Merge form to enter metatags informations
    $metatags_form = new LyraMetatagsForm();
    $this->mergeForm($metatags_form);
    $this->widgetSchema->setNameFormat('label[%s]');
  }
  protected function doSave($con = null)
  {
    parent::doSave($con);
    $node = $this->getObject()->getNode();
    $parent = $this->getObject()->getTable()
      ->find($this->getValue('parent_id'));
    if($parent)
    {
      if($this->isNew())
      {
        $node->insertAsFirstChildOf($parent);
      }
      elseif($node->getParent()->getId() != $parent->getId())
      {
        $node->moveAsFirstChildOf($parent);
      }
    }
  }
}