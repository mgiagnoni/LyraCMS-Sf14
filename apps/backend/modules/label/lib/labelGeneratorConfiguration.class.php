<?php

/**
 * label module configuration.
 *
 * @package    lyra
 * @subpackage label
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class labelGeneratorConfiguration extends BaseLabelGeneratorConfiguration
{
  public function getFormOptions()
  {
    return array(
      'user' => sfContext::getInstance()->getUser(),
      'catalog_id' => sfContext::getInstance()->getRequest()->getParameter('catalog_id'),
      'break_at' => 'PANEL_METATAGS'
    );
  }
}
