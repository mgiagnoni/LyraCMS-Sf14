<?php

/**
 * LyraArticle form.
 *
 * @package    form
 * @subpackage LyraArticle
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class LyraArticleForm extends BaseLyraArticleForm
{
  public
    $panels = null,
    $break_at = null;
    
  public function configure()
  {
    //remove fields that must never be displayed in form
    unset(
      $this['status'],
      $this['options'],
      $this['created_by'],
      $this['updated_by'],
      $this['locked_by'],
      $this['created_at'],
      $this['updated_at'],
      $this['article_labels_list']
    );

    //FCKeditor
    $this->widgetSchema['summary'] =  new sfWidgetFormTextareaFCKEditor(
      array(
        'width' => 430,
        'height' => 250,
        'tool' => 'lyra',
        'config'=> 'myfckconfig'
      )
    );

    $this->widgetSchema['content'] =  new sfWidgetFormTextareaFCKEditor(
      array(
        'width' => 430,
        'height' => 450,
        'tool' => 'lyra',
        'config'=> 'myfckconfig'
      )
    );

    $this->widgetSchema['ctype_id'] = new sfWidgetFormInputHidden();

    //change default labels
    $this->widgetSchema['title']->setLabel('TITLE');
    $this->widgetSchema['slug']->setLabel('SLUG');
    $this->widgetSchema['subtitle']->setLabel('SUBTITLE');
    $this->widgetSchema['summary']->setLabel(false);
    $this->widgetSchema['content']->setLabel(false);
    $this->widgetSchema['meta_title']->setLabel('META_TITLE');
    $this->widgetSchema['meta_descr']->setLabel('META_DESCR');
    $this->widgetSchema['meta_keys']->setLabel('META_KEYS');
    $this->widgetSchema['meta_robots']->setLabel('META_ROBOTS');
    $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');
    $this->widgetSchema['is_featured']->setLabel('IS_FEATURED');
    $this->widgetSchema['is_sticky']->setLabel('IS_STICKY');
    $this->widgetSchema['publish_start']->setLabel('PUBLISH_START');
    $this->widgetSchema['publish_end']->setLabel('PUBLISH_END');

    $this->widgetSchema['content']->setAttribute('rows',20);
    $this->widgetSchema['content']->setAttribute('cols',50);
    $this->widgetSchema['summary']->setAttribute('rows',15);
    $this->widgetSchema['summary']->setAttribute('cols',50);

    $this->panels = array(
      'NONE' => array('title', 'slug', 'subtitle'),
      'PANEL_CONTENT' => array('content'),
      'PANEL_SUMMARY' => array('summary'),
      'PANEL_PUBLISH' => array('is_active', 'is_featured', 'is_sticky', 'publish_start', 'publish_end'),
      'PANEL_LABELS' => array('labels'),
      'PANEL_METATAGS' => array('meta_title', 'meta_descr', 'meta_keys', 'meta_robots')
    );
    $this->break_at = 'PANEL_PUBLISH';

    if($this->isNew()) {
      $user = $this->getOption('user');
      $ctype_id = $user->getAttribute('lyra_ctype_id');
      $this->setDefault('ctype_id', $ctype_id);
      $selected = array();
    } else {
      $ctype_id = $this->getObject()->getCtypeId();
      $selected= $this->getObject()
        ->getArticleLabels()
        ->getPrimaryKeys();
    }
    
    $label_lists_form = new LyraLabelListsForm(array(), array('ctype_id' => $ctype_id, 'selected' => $selected));
    $this->embedForm('labels', $label_lists_form);
    //$this->widgetSchema->moveField('labels', sfWidgetFormSchema::AFTER, 'subtitle');
    $this->widgetSchema['labels']->setLabel(false);
    $this->widgetSchema->setFormFormatterName('LyraContent');
    $this->widgetSchema->setNameFormat('article[%s]');
  }

  public function updateObject($values = null)
  {
    $item = parent::updateObject($values);
    $user = $this->getOption('user');
    if(isset($user)) {
      $uid = $user->getGuardUser()->getId();
      if($this->isNew()) {
        $item->setCreatedBy($uid);
        $item->setUpdatedBy($uid);
      } elseif($item->isModified()) {
        $item->setUpdatedBy($uid);
      }
    }
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);
    $this->saveLabels($con);
  }

  protected function saveLabels($con = null)
  {
    if (!$this->isValid()) {
        throw $this->getErrorSchema();
    }

    if (is_null($con)) {
        $con = $this->getConnection();
    }

    $existing = $this->getObject()
      ->getArticleLabels()
      ->getPrimaryKeys();

    $ctype = Doctrine::getTable('LyraContentType')
        ->find($this->getValue('ctype_id'));
        
    $values = array();
    $lists_values = $this->getValue('labels');

    foreach ($ctype->ContentTypeCatalogs as $cg) {
      //get selected values of each list
      $v = $lists_values['label_'.$cg->getId()];
      if (!is_array($v)) {
          $v = array();
      }
      $values = array_merge($v, $values);
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink)) {
        $this->getObject()
          ->unlink('ArticleLabels', array_values($unlink), true);
    }

    $link = array_diff($values, $existing);
    if (count($link)) {
        $this->getObject()
          ->link('ArticleLabels', array_values($link), true);
    }
  }
}