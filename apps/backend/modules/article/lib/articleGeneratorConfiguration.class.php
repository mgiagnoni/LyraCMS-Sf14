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
 * articleGeneratorConfiguration
 *
 * @package lyra
 * @subpackage article
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class articleGeneratorConfiguration extends BaseArticleGeneratorConfiguration
{
  public function getFormOptions()
  {
    return array(
      'user' => sfContext::getInstance()->getUser(),
      'ctype_id' => sfContext::getInstance()->getUser()->getAttribute('lyra_ctype_id'),
      'break_at' => 'PANEL_PUBLISH'
    );
  }

}
