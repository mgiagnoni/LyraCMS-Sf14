<?php
$node = $lyra_menu->getNode();

if($lyra_menu->getParentId() !== null && $node->hasNextSibling()) {
  echo link_to(image_tag('backend/arrow-down.png', array('alt' => __('LINK_T_MOVE_DOWN'))),'lyra_menu_down', $lyra_menu, array('title' => __('LINK_T_MOVE_DOWN')));
}
if($lyra_menu->getParentId() !== null && $node->hasPrevSibling()) {
  echo link_to(image_tag('backend/arrow-up.png', array('alt' => __('LINK_T_MOVE_UP'))),'lyra_menu_up', $lyra_menu, array('title' => __('LINK_T_MOVE_UP')));
}