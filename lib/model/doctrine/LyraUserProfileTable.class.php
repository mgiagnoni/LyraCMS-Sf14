<?php


class LyraUserProfileTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LyraUserProfile');
    }
    public function emailVerify($email, $token)
    {
      $profile = $this->createQuery('p')
        ->where('p.email = ?')
        ->andWhere('p.vtoken = ?')
        ->fetchOne(array($email, $token));

      if(!$profile)
      {
        return false;
      }
      $params = new LyraConfig('settings');
      $profile->setIsVerified(true);
      if(false == $params->get('require_approval', 'users'))
      {
        $profile->setIsActive(true);
      }
      $profile->save();
      return true;
    }
}