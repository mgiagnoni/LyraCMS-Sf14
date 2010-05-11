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
 * LyraValidatorPublishDate
 *
 * @package lyra
 * @subpackage validator
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraValidatorPublishDate extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'ERROR_PUBLISH_DATE_INVALID');
  }
  protected function doClean($values)
  {
    
    if(null !== $values['publish_start'] && null !== $values['publish_end'] && $values['publish_start'] > $values['publish_end'])
    {
      throw new sfValidatorError($this, 'invalid', array(
        'publish_start' => $values['publish_start'],
        'publish_end' => $values['publish_end']
      ));
    }
    return $values;
  }
}