<?php
$action = $sf_request->getParameter('action');
$fw = ($action == 'edit' || $action == 'new' || $action == 'update' || $action == 'create') ? '-full-width' : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php use_stylesheet('main.css') ?>
  </head>
  <body>
    <div id="wrapper">
      <div id="content">
        <div id="top">
          <div id="logo">
            <h1>Logo</h1>
            <h4>Slogan</h4>
          </div>
          <div id="links">
            <ul>
              <li><?php echo link_to('Home','@homepage');?></li>
              <li><?php echo link_to('Pagina','@page_show?slug=pagina-di-esempio');?></li>
              <li><a href="#">Contattaci</a></li>
            </ul>
          </div>
        </div>
        <div id="header">
         <h3><?php include_slot('page_title'); ?></h3>
        </div>
        <div id="contentarea">
          <div id="leftbar<?php echo $fw ?>">
            <?php if ($sf_user->hasFlash('notice')): ?>
            <div class="flash_notice">
              <?php echo __($sf_user->getFlash('notice')) ?>
            </div>
            <?php endif; ?>

            <?php if ($sf_user->hasFlash('error')): ?>
            <div class="flash_error">
              <?php echo __($sf_user->getFlash('error')) ?>
            </div>
            <?php endif; ?>
            <?php echo $sf_content ?>
          </div>
          <?php if(!$fw): ?>
          <div id="rightbar">
            <?php include_component('article', 'labels', array('catalog'=>'Argomento')) ?>
            <?php include_component('article', 'archive') ?>
          </div>
          <?php endif; ?>
        </div>
        <div id="footer">
          <div id="lyra-powered">
            <a href="#">Powered by Lyra</a>
          </div>
          <div id="validator">
          <p>Valid <a href="http://validator.w3.org/check?uri=referer">XHTML</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>