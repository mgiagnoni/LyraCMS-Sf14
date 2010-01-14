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
      <div id="header">
        <h1>
          <?php include_slot('page_title') ?>
        </h1>
      </div>
      <?php if ($sf_user->isAuthenticated()):
        $module = $sf_request->getParameter('module');?>
      <div id="menu">
        <ul>
          <li>
            <?php echo link_to(__('MENU_HOME'), '@homepage') ?>
          </li>
          <li <?php echo ($module == 'content' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_CONTENT'), '@lyra_content_type') ?>
          </li>
          <li <?php echo ($module == 'article' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_ARTICLES'), '@lyra_article_article?id=1') ?>
          </li>
          <li <?php echo ($module == 'comment' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_COMMENTS'), '@lyra_comment_comment') ?>
          </li>
          <li <?php echo ($module == 'catalog' || $module == 'label' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_CATALOGS'), '@lyra_catalog_catalog') ?>
          </li>
          <li <?php echo ($module == 'sfGuardUser' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_USERS'), '@sf_guard_user') ?>
          </li>
          <li <?php echo ($module == 'sfGuardGroup' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_GROUPS'), '@sf_guard_group') ?>
          </li>
          <li <?php echo ($module == 'sfGuardPermission' ? 'class="active"' : ''); ?>>
            <?php //echo link_to('Permissions', '@sf_guard_permission') ?>
          </li>
          <li <?php echo ($module == '' ? 'class="active"' : ''); ?>>
            <?php echo link_to(__('MENU_LOGOUT'), '@sf_guard_signout') ?>
          </li>
        </ul>
      </div>
      <?php endif; ?>
      <div id="content">
        <?php echo $sf_content ?>
        <div class="clear">&nbsp;</div>
      </div>
      <div class="clear">&nbsp;</div>
    </div>
  </body>
</html>
