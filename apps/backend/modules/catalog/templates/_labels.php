<?php
    echo link_to($lyra_catalog->countLabels()-1,'@lyra_label_label?id='.$lyra_catalog->getId());
?>&nbsp;(<?php echo link_to(__('LINK_SHOW_LABELS'),'@lyra_label_label?id='.$lyra_catalog->getId());?>)
