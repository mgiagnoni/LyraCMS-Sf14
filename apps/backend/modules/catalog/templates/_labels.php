<?php
    echo link_to($lyra_catalog->countLabels(),'catalog/labels?id='.$lyra_catalog->getId());
?>&nbsp;(<?php echo link_to(__('LINK_SHOW_LABELS'),'catalog/labels?id='.$lyra_catalog->getId());?>)
