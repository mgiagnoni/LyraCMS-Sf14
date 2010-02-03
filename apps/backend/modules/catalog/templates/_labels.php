<?php
    echo link_to($lyra_catalog->countLabels()-1,'@lyra_label?catalog_id='.$lyra_catalog->getId());
?>&nbsp;(<?php echo link_to(__('LINK_SHOW_LABELS'),'@lyra_label?catalog_id='.$lyra_catalog->getId());?>)
