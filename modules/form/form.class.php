<?php
/*
*
* Copyright (c) 2012 GNKW
*
* This file is part of GNK Website.
*
* GNK Website is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNK Website is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNK Website.  If not, see <http://www.gnu.org/licenses/>.
*/
namespace gnk\modules\form;
use \gnk\config\Module;
use \gnk\config\Page;

require_once(LINK_LIB . 'zebra/Zebra_Form.php');

class Form extends \Zebra_Form{
	public function __construct($name, $method = 'POST', $action = '', $attributes = ''){
		parent::__construct($name, $method, $action, $attributes);
		$this->form_properties['assets_url'] = Page::rewriteLink(LINKR_LIB . 'zebra/');
        $this->language('francais');
		Page::setJS(array(
			LINKR_LIB . 'jquery/jquery.min.js',
			LINKR_LIB . 'zebra/public/javascript/zebra_form.js'
		));
		Page::addCSS(LINKR_LIB . 'zebra/public/css/zebra_form.css');
	}
}
?>