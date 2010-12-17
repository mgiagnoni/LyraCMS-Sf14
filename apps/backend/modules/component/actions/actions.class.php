<?php

/**
 * component actions.
 *
 * @package    lyra
 * @subpackage component
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class componentActions extends sfActions
{
  public function executeMove(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();

    if($request->getParameter('dir') == 'up')
    {
      $object->promote();
    }
    else
    {
      $object->demote();
    }
    $this->redirect('@lyra_region');
  }
  public function executeParams(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $this->form_params = new LyraRegionComponentForm($object);
  }
  public function executeUpdateparams(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $this->form_params = new LyraRegionComponentForm($object);

    $this->form_params->bind($request->getParameter($this->form_params->getName()), $request->getFiles($this->form_params->getName()));
    if($this->form_params->isValid())
    {
       $this->form_params->save();
       $this->getUser()->setFlash('notice', 'Component parameters successfully updated.');
       $this->redirect('@lyra_region');
       $this->setTemplate('params');
    }
  }
}
