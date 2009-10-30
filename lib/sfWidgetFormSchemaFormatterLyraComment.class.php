<?php
class sfWidgetFormSchemaFormatterLyraComment extends sfWidgetFormSchemaFormatter
{
  protected
      $rowFormat = '<div class="row">%error%%field%%label%%help%%hidden_fields%</div>',
      $helpFormat = '<div class="field-help">%help%</div>';
}
