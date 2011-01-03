<?php echo link_to_if($sf_user->hasCredential(array('user_administer', 'user_edit'), false), $sf_guard_user->getUsername(), 'lyra_user_edit', $sf_guard_user) ?>
