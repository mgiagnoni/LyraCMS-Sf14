<?php
class LyraBackendListener
{
  static public function listenToAdminSaveObject(sfEvent $event)
  {
    if($event['object'] instanceof LyraLabel)
    {
      if($event->getSubject()->getRequest()->hasParameter('_save_and_add'))
      {
        $event->getSubject()->getUser()->setAttribute('default_data', array(
          'parent_id' => $event['object']->getNode()->getParent()->getId()
        ), 'LyraLabelForm');
      }
      else
      {
        $event->getSubject()->getUser()->setAttribute('default_data', array(), 'LyraLabelForm');
      }
    }
    if($event['object'] instanceof LyraMenu)
    {
      if($event->getSubject()->getRequest()->hasParameter('_save_and_add'))
      {
        if($event['object']->getParentId())
        {
          $defaults = $event->getSubject()->getUser()->getAttribute('default_data', array(), 'LyraMenuForm');
          $defaults['parent_id'] = $event['object']->getParentId();
          $event->getSubject()->getUser()->setAttribute('default_data', $defaults, 'LyraMenuForm');
        }
      }
      else
      {
        $event->getSubject()->getUser()->setAttribute('default_data', array(), 'LyraMenuForm');
      }
    }
    if($event['object'] instanceof LyraRegion)
    {
      $rows = Doctrine_Query::create()
      ->from('LyraRegionComponent')
      ->where('region_id = ?', array($event['object']->getId()))
      ->orderBy('position')
      ->execute();
      
      $p = 1;
      foreach($rows as $row)
      {
        if($row->getPosition() != $p)
        {
          $row->position = $p;
          $row->save();
        }
        $p++;
      }
    }
  }
}
