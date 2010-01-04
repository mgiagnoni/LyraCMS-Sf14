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
 * LyraLabelListsForm
 *
 * @package lyra
 * @subpackage form
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraLabelListsForm extends BaseForm
{
  public function configure()
  {

    $ctype = Doctrine::getTable('LyraContentType')
      ->find($this->getOption('ctype_id'));

    //create a selection list for each catalog linked to content type
    foreach ($ctype->ContentTypeCatalogs as $cg) {
      //query to select label records for list options
      $query = Doctrine_Query::create()
        ->from('LyraLabel l')
        ->where('l.catalog_id = ? AND l.level > 0', $cg->id)
        ->addOrderBy('l.root_id, l.lft');
      $k = 'label_'.$cg->getId();
      $this->widgetSchema[$k] = new sfWidgetFormDoctrineChoiceMany(array('model'=>'LyraLabel', 'query'=>$query, 'label'=>$cg->name, 'default'=>$this->getOption('selected'), 'method'=>'getIndentName'), array('class' => 'labels'));
      $this->setDefault($k, $this->getOption('selected'));
      $this->validatorSchema[$k] = new sfValidatorDoctrineChoiceMany(array('model'=>'LyraLabel', 'required'=>false));
    }
    $this->widgetSchema->setFormFormatterName('list');
  }
}
