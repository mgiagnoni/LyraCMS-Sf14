<?php

/*
 * this class is based on 
 * sfWidgetFormTextareaTinyMCE
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * adapted to FCKEditor by Christoph Singer <singer@webagentur72.de>
 * 
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// we need helper function javascript_path()
sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
sfContext::getInstance()->getResponse()->addJavascript(sfConfig::get('sf_rich_text_fck_js_dir') ? '/'.sfConfig::get('sf_rich_text_fck_js_dir').'/fckeditor.js' : '/js/fckeditor/fckeditor.js');

/**
 * sfWidgetFormTextareaFCKEditor represents a FCKEditor widget.
 *
 * You must include the FCKEditor JavaScript file by yourself.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Christoph Singer <singer@webagentur72.de>
 */
class sfWidgetFormTextareaFCKEditor extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * width:  Width
   *  * height: Height
   *  * tool: FCKEditor toolbar name
   *  * config: The javascript configuration file
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('width', 500);
    $this->addOption('height', 300);
    $this->addOption('config', '');
    $this->addOption('tool', 'Default');
    $this->addOption('FCKBasePath', sfContext::getInstance()->getRequest()->getRelativeUrlRoot().'/'.sfConfig::get('sf_rich_text_fck_js_dir', 'js/fckeditor').'/');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes = array_merge($this->attributes, $attributes);

    $textarea = parent::render($name, $value, $attributes, $errors);

    // get ID attribute
    $id = $this->generateId($name);
    

    $js = sprintf(<<<EOF
<script type="text/javascript">
var ed$id = new FCKeditor('$name');
ed$id.BasePath = "%s";
ed$id.Width = %d;
ed$id.Height = %d;
ed$id.Config["CustomConfigurationsPath"] = "%s";
ed$id.ToolbarSet = "%s";
ed$id.ReplaceTextarea() ;
</script>
EOF
    ,
      $this->getOption('FCKBasePath'),
      $this->getOption('width'),
      $this->getOption('height'),
      $this->getOption('config') ? javascript_path($this->getOption('config')) : '',
      $this->getOption('tool')
    );

    return $textarea.$js;
  }
}
