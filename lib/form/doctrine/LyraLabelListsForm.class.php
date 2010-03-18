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

    $catalogs = Doctrine_Query::create()
      ->select('c.name, l.id, l.level, l.name')
      ->from('LyraCatalog c')
      ->innerJoin('c.CatalogContentTypes t')
      ->innerJoin('c.CatalogLabels l')
      ->where('t.id = ?')
      ->andWhere('l.level > 0')
      ->orderBy('c.id, l.root_id, l.lft')
      ->execute(array($this->getOption('ctype_id')), Doctrine::HYDRATE_ARRAY);

    //create a selection list for each catalog linked to content type
    foreach($catalogs as $catalog) {
      $choices = array();
      foreach($catalog['CatalogLabels'] as $label) {
        //Indent label name
        $choices[$label['id']] = str_repeat('-- ', $label['level'] -1) . $label['name'];
      }
      $k = 'label_'.$catalog['id'];
      $this->widgetSchema[$k] = new sfWidgetFormChoice(array(
        'choices' => $choices,
        'multiple' => true
      ),array('class' => 'labels'));

      $this->widgetSchema[$k]->setLabel($catalog['name']);
      $this->setDefault($k, $this->getOption('selected'));

      $this->validatorSchema[$k] = new sfValidatorChoice(array(
        'choices' => array_keys($choices),
        'multiple' => true,
        'required' => false
      ));
    }
    $this->widgetSchema->setFormFormatterName('list');
  }
}
