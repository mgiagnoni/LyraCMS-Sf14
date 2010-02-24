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
 * LyraMetatagsForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
 class LyraMetatagsForm extends BaseForm
 {
   static public $meta_robots_choices = array(
     '' => 'OPTION_NONE',
     'index, follow' => 'OPTION_INDEX_FOLLOW',
     'noindex, nofollow' => 'OPTION_NOINDEX_NOFOLLOW',
     'noindex, follow' => 'OPTION_NOINDEX_FOLLOW',
     'index, nofollow' => 'OPTION_INDEX_NOFOLLOW'
   );
   public function configure()
   {

      $this->widgetSchema   ['meta_title'] = new sfWidgetFormInputText();
      $this->validatorSchema['meta_title'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

      $this->widgetSchema   ['meta_descr'] = new sfWidgetFormTextarea();
      $this->validatorSchema['meta_descr'] = new sfValidatorString(array('max_length' => 500, 'required' => false));

      $this->widgetSchema   ['meta_keys'] = new sfWidgetFormTextarea();
      $this->validatorSchema['meta_keys'] = new sfValidatorString(array('max_length' => 500, 'required' => false));

      $this->widgetSchema   ['meta_robots'] = new sfWidgetFormChoice(array('choices' => self::$meta_robots_choices));
      $this->validatorSchema['meta_robots'] = new sfValidatorChoice(array('choices' => array_keys(self::$meta_robots_choices), 'required' => false));

      $this->widgetSchema['meta_title']->setLabel('META_TITLE');
      $this->widgetSchema['meta_descr']->setLabel('META_DESCR');
      $this->widgetSchema['meta_keys']->setLabel('META_KEYS');
      $this->widgetSchema['meta_robots']->setLabel('META_ROBOTS');
   }
 }
