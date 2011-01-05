<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Lyra Backend</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('admin.css');
    include_javascripts();
    include_stylesheets();
    ?>
  </head>
  <body>
    <div id="container">
      <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('access_backend')):
        $module = $sf_request->getParameter('module');?>
      <div id="side-bar">
        
        <div id="menu">
          <ul>
            <li>
              <?php echo link_to(__('MENU_HOME'), '@homepage') ?>
            </li>
            <li <?php echo ($module == 'content' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_CONTENT'), '@lyra_content_type') ?>
            </li>
            <?php
            //TODO: hardcoded for now, this must be moved in a component
            $ctypes = LyraContentTypeTable::getInstance()
              ->findAll();?>
            <li>
              <ul class="content-types">
              <?php foreach($ctypes as $ctype):?>
                <li><?php echo $ctype->getName();?></li>
                <li>
                  <ul class="content-items">
                    <li <?php echo ($module == $ctype->getModule() && $sf_request->getParameter('ctype_id') == $ctype->getId() ? 'class="active"' : ''); ?>>
                      <?php echo link_to(__('MENU_ITEMS'), sfInflector::underscore($ctype->getModel()),array('ctype_id' => $ctype->getId())) ?>
                    </li>
                    <li <?php echo ($module == 'route' && $sf_request->getParameter('ctype_id') == $ctype->getId() ? 'class="active"' : ''); ?>>
                      <?php echo link_to(__('MENU_LISTS'), 'lyra_route',array('ctype_id' => $ctype->getId())) ?>
                    </li>
                  </ul>
                </li>
              <?php endforeach; ?>
              </ul>
            </li>
            <!-- end TODO -->
            <?php if($sf_user->hasCredential(array('comment_administer', 'comment_list'),false)):?>
              <li <?php echo ($module == 'comment' ? 'class="active"' : ''); ?>>
                <?php echo link_to(__('MENU_COMMENTS'), '@lyra_comment') ?>
              </li>
            <?php endif; ?>
            <li <?php echo ($module == 'catalog' || $module == 'label' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_CATALOGS'), '@lyra_catalog') ?>
            </li>
            <li <?php echo ($module == 'menu' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_MENU'), '@lyra_menu') ?>
            </li>
            <li <?php echo ($module == 'region' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_REGIONS'), '@lyra_region') ?>
            </li>
            <?php if($sf_user->hasCredential(array('user_administer', 'user_list'),false)):?>
            <li <?php echo ($module == 'sfGuardUser' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_USERS'), '@lyra_user') ?>
            </li>
            <?php endif; ?>
            <li <?php echo ($module == 'sfGuardGroup' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_GROUPS'), '@sf_guard_group') ?>
            </li>
            <li <?php echo ($module == 'settings' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_SETTINGS'), 'settings/edit?id=1') ?>
            </li>
            <li <?php echo ($module == 'sfGuardPermission' ? 'class="active"' : ''); ?>>
              <?php //echo link_to('Permissions', '@sf_guard_permission') ?>
            </li>
            <li <?php echo ($module == '' ? 'class="active"' : ''); ?>>
              <?php echo link_to(__('MENU_LOGOUT'), '@sf_guard_signout') ?>
            </li>
          </ul>
        </div>
        <?php if (has_slot('admin_filters')) { include_slot('admin_filters'); }?>
        <div class="user-info">
          <h3>User</h3>
            <span class="username">
              <?php echo $sf_user->getGuardUser()->getProfile()->getFirstName(); ?>
              <?php echo $sf_user->getGuardUser()->getProfile()->getLastName(); ?>
              (<?php echo $sf_user->getGuardUser()->getUsername(); ?>)
            </span>
            <span class="logout-link"><?php echo link_to(__('MENU_LOGOUT'), '@sf_guard_signout') ?></span>
        </div>
      </div>
      <?php endif; ?>
      <div id="content">
        <?php echo $sf_content ?>
        <div class="clear">&nbsp;</div>
      </div>
    </div>
  </body>
</html>
