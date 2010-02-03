<?php
$node = $lyra_label->getNode();

if($node->hasNextSibling()) {
  echo link_to(image_tag('backend/arrow-down.png', array('alt' => __('LINK_T_MOVE_DOWN'))),'lyra_label_down', $lyra_label ,array('title' => __('LINK_T_MOVE_DOWN')));
}
if($node->hasPrevSibling()) {
  echo link_to(image_tag('backend/arrow-up.png', array('alt' => __('LINK_T_MOVE_UP'))),'lyra_label_up', $lyra_label, array('title' => __('LINK_T_MOVE_UP')));
}