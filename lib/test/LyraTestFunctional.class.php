<?php
class LyraTestFunctional extends sfTestFunctional
{
  public function loadData()
  {
    Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures');

    return $this;
  }
  public function signinOk($user_data)
  {
    return $this->
    info(sprintf('Connexion with login : "%s" and password "%s" should be ok OK.', $user_data['username'], $user_data['password']))->
    get('/login')->
    click('sign in',array('signin'=>$user_data))->

    with('form')->begin()->
      hasErrors(false)->
    end()->

    with('user')->begin()->
      isAuthenticated(true)->
    end()->

    with('request')->begin()->
      isParameter('module', 'sfGuardAuth')->
      isParameter('action', 'signin')->
    end()->

    with('response')->
      isRedirected();
  }
}
