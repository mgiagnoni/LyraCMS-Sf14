<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LyraComment extends BaseLyraComment
{
  public function publish($on = true)
  {
    $this->setIsActive($on);
    $this->save();
  }
}