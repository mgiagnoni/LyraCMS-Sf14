<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 */

/**
 * LyraArticleForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraArticleForm extends BaseLyraArticleForm
{
  public
    $panels = null,
    $break_at = null;
    
  protected
    $show_params = false;

  public function configure()
  {
    
    parent::configure();
    //remove fields that must never be displayed in form
    unset(
      $this['status'],
      $this['params'],
      $this['created_by'],
      $this['updated_by'],
      $this['locked_by'],
      $this['created_at'],
      $this['updated_at'],
      $this['article_labels_list'],
      $this['num_comments'],
      $this['num_active_comments']
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

    $user = $this->getOption('user');
    $this->widgetSchema['publish_start'] = new sfWidgetFormI18nDateTime(array(
      'culture' => $user->getCulture(),
    ));

    $this->widgetSchema['publish_end'] = new sfWidgetFormI18nDateTime(array(
      'culture' => $user->getCulture()
    ));

    $this->validatorSchema->setPostValidator(new LyraValidatorPublishDate());

    //change default labels
    $this->widgetSchema['title']->setLabel('TITLE');
    $this->widgetSchema['slug']->setLabel('SLUG');
    $this->widgetSchema['subtitle']->setLabel('SUBTITLE');
    $this->widgetSchema['summary']->setLabel(false);
    $this->widgetSchema['content']->setLabel(false);
    $this->widgetSchema['is_active']->setLabel('IS_ACTIVE');
    $this->widgetSchema['is_featured']->setLabel('IS_FEATURED');
    $this->widgetSchema['is_sticky']->setLabel('IS_STICKY');
    $this->widgetSchema['is_archived']->setLabel('IS_ARCHIVED');
    $this->widgetSchema['is_feeded']->setLabel('IS_FEEDED');
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
      'PANEL_PUBLISH' => array('is_active', 'is_featured', 'is_sticky', 'is_archived','publish_start', 'publish_end'),
      'PANEL_LABELS' => array('labels'),
      'PANEL_METATAGS' => array('meta_title', 'meta_descr', 'meta_keys', 'meta_robots')
    );
    $this->break_at = 'PANEL_PUBLISH';

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
    return $item;
  }
}