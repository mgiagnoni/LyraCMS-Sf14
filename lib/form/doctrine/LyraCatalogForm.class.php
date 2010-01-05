<?php

/**
 * LyraCatalog form.
 *
 * @package    form
 * @subpackage LyraCatalog
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LyraCatalogForm extends BaseLyraCatalogForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['locked_by']);
    $this->widgetSchema['name']->setLabel('NAME');
    $this->widgetSchema['description']->setLabel('DESCRIPTION');
    $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');
    $this->widgetSchema['catalog_content_types_list']->setLabel(false);

    $this->widgetSchema['catalog_content_types_list']->setOption('expanded', true);
  }
  protected function doSave($con = null)
  {
    $savingnew = $this->isNew();
    parent::doSave($con);

    if ($savingnew) {
      $label = new LyraLabel();
      $label->setName($this->object->getName());

      $label->setCatalogId($this->object->getId());
      $label->save();
      $treeObject = Doctrine::getTable('LyraLabel')->getTree();
      $treeObject->createRoot($label);
    }
  }
}