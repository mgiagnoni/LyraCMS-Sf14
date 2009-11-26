<?php

/**
 * article module configuration.
 *
 * @package    lyra
 * @subpackage article
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class articleGeneratorConfiguration extends BaseArticleGeneratorConfiguration
{
  public function getFormOptions()
  {
    return array(
      'user' => sfContext::getInstance()->getUser()
      );
  }

}
