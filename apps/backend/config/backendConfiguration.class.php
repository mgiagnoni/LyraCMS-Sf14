<?php

class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $this->dispatcher->connect('admin.save_object', array('LyraBackendListener', 'listenToAdminSaveObject'));
  }
}
