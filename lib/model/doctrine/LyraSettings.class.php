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
 * LyraSettings
 *
 * @package lyra
 * @subpackage model
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraSettings extends BaseLyraSettings
{
  public function postUpdate($event)
  {
    $cache = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . sfConfig::get('sf_environment') . DIRECTORY_SEPARATOR . 'lyra' . DIRECTORY_SEPARATOR . 'settings.cache.php';
    if(file_exists($cache))
    {
      @unlink($cache);
    }
  }
  public function getParamDefinitionsPath()
  {
    return sfConfig::get('sf_config_dir') . '/lyra_params.yml';
  }
}
