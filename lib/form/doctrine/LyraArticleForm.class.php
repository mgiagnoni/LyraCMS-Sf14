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

    //change default labels
    $this->widgetSchema['title']->setLabel('TITLE');
    $this->widgetSchema['subtitle']->setLabel('SUBTITLE');
    $this->widgetSchema['summary']->setLabel('SUMMARY');
    $this->widgetSchema['content']->setLabel('CONTENT');
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

    $this->widgetSchema->moveField('slug', sfWidgetFormSchema::AFTER, 'title');

    //FCKeditor
    $this->widgetSchema['summary'] =  new sfWidgetFormTextareaFCKEditor(
      array(
        'width' => 380,
        'height' => 250,
        'tool' => 'lyra',
        'config'=> 'myfckconfig'
      )
    );

    $this->widgetSchema['content'] =  new sfWidgetFormTextareaFCKEditor(
      array(
        'width' => 380,
        'height' => 450,
        'tool' => 'lyra',
        'config'=> 'myfckconfig'
      )
    );
    
    //get content type managed by this module
    $ctype = Doctrine::getTable('LyraContentType')
      ->findOneByModule('article');

    $def = array();
    if(!$this->isNew()) {
      //retrieve primary keys of labels linked to the article we are saving
      $def = $this->getObject()
        ->getArticleLabels()
        ->getPrimaryKeys();
    }

    $after = 'subtitle';
    //create a selection list for each catalog linked to content type
    foreach ($ctype->ContentTypeCatalogs as $cg) {
        //query to select label records for list options
        $query = Doctrine_Query::create()
          ->from('LyraLabel l')
          ->where('l.catalog_id = ? AND l.level > 0', $cg->id);
        $k = 'label_'.$cg->getId();
        $this->widgetSchema[$k] = new sfWidgetFormDoctrineChoiceMany(array('model'=>'LyraLabel', 'query'=>$query, 'label'=>$cg->name, 'default'=>$def, 'method'=>'getIndentName'));
        $this->validatorSchema[$k] = new sfValidatorDoctrineChoiceMany(array('model'=>'LyraLabel', 'required'=>false));
        $this->widgetSchema->moveField($k, sfWidgetFormSchema::AFTER, $after);
        $after = $k;
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
      ->findOneByModule('article');

    $values = array();

    foreach ($ctype->ContentTypeCatalogs as $cg) {
        //get selected values of each list created in configure()
        $v = $this->getValue('label_'.$cg->getId());
        if (!is_array($v)) {
            $v = array();
        }
        $values = array_merge($v, $values);
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink)) {
        $this->getObject()
          ->unlink('ArticleLabels', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link)) {
        $this->getObject()
          ->link('ArticleLabels', array_values($link));
    }
  }
}