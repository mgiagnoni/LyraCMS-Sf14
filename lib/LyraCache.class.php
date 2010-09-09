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
 * LyraCache
 *
 * @package lyra
 * @subpackage lib
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraCache
{
  protected $file;

  public function __construct($file)
  {
    $this->file = $file;
  }
  public function save($data)
  {
    $out = "<?php\n\$data=" . $this->build($data) . ";";
    file_put_contents($this->file, $out);
  }
  protected function build($data)
  {
    $out = "array(";
    foreach($data as $k => $v)
    {
      $out .= "'$k'=>";
      if(is_int($v))
      {
        $out .= $v;
      }
      else if(is_string($v))
      {
        $out .= "'" . addslashes($v) . "'";
      }
      else if (is_bool($v))
      {
        $out .= $v ? 'true' : 'false';
      }
      $out .= ',';
    }
    $out .= ")";
    return $out;
  }
}