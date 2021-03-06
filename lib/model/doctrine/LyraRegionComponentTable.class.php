<?php

/**
 * LyraRegionComponentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LyraRegionComponentTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object LyraRegionComponentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LyraRegionComponent');
    }
    public function findItem($params)
    {
      $q = $this->createQuery('a')
        ->where('component_id = ? AND region_id = ?', array($params['id'], $params['region_id']));

      return $q->fetchOne();
    }
}