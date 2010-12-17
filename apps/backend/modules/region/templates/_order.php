<?php
if($show_down)
{
  echo link_to(image_tag('backend/arrow-down.png', array('alt' => __('LINK_T_MOVE_DOWN'))),'lyra_component_move', array('id' => $lyra_component->getId(), 'region_id' => $lyra_region->getId(), 'dir' => 'down') ,array('title' => __('LINK_T_MOVE_DOWN')));
}
if($show_up)
{
  echo link_to(image_tag('backend/arrow-up.png', array('alt' => __('LINK_T_MOVE_UP'))),'lyra_component_move', array('id' => $lyra_component->getId(), 'region_id' => $lyra_region->getId(), 'dir' => 'up'), array('title' => __('LINK_T_MOVE_UP')));
}

