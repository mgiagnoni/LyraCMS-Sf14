<?php
$node = $lyra_label->getNode();

if($node->hasNextSibling()) {
  echo link_to(image_tag('backend/arrow-down.png', array('alt' => __('LINK_T_MOVE_DOWN'))),'label/move?id='.$lyra_label->getId().'&dir=0',array('title' => __('LINK_T_MOVE_DOWN')));
}
if($node->hasPrevSibling()) {
  echo link_to(image_tag('backend/arrow-up.png', array('alt' => __('LINK_T_MOVE_UP'))),'label/move?id='.$lyra_label->getId().'&dir=1',array('title' => __('LINK_T_MOVE_UP')));
}