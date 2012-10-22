<?php
namespace gnk\modules\form;
use \gnk\config\Module;
use \gnk\config\Page;

require_once(LINK_LIB . 'zebra/Zebra_Form.php');

class Form extends \Zebra_Form{
	public function __construct($name, $method = 'POST', $action = '', $attributes = ''){
		parent::__construct($name, $method, $action, $attributes);
		$this->form_properties['assets_url'] = LINKR_LIB . 'zebra/';
        $this->language('francais');
		Page::setJS(array(
			LINKR_LIB . 'zebra/public/javascript/zebra_form.js',
			LINKR_LIB . 'jquery/jquery.min.js'
		));
		Page::addCSS(LINKR_LIB . 'zebra/public/css/zebra_form.css');
	}
}
?>