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
 * LyraMailer
 *
 * @package lyra
 * @subpackage mailer
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraMailer extends sfMailer
{
  public function __construct(sfEventDispatcher $dispatcher, $options)
  {
    $params = LyraSettingsTable::getParamHolder('mailer');
    if('smtp' === $params->get('send_with'))
    {
      $options['transport']['class'] = "Swift_SmtpTransport";
      $options['transport']['param']['host'] = $params->get('smtp_host');
      $options['transport']['param']['port'] = $params->get('smtp_port');
      if($enc = $params->get('smtp_encryption'))
      {
        $options['transport']['param']['encryption'] = $enc;
      }
      $options['transport']['param']['username'] = $params->get('smtp_username');
      $options['transport']['param']['password'] = $params->get('smtp_password');
    }
    else
    {
      $options['transport']['class'] = "Swift_MailTransport";
      $options['transport']['param'] = null;
    }
    parent::__construct($dispatcher, $options);
  }
}
