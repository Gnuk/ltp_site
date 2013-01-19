<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/
	use \gnk\config\Page;
?>
<!DOCTYPE html>
<html>
	<head>
<?php $this->show('head');?>
	</head>
	<body>
		<h1>
			<a href="<?php echo Page::defaultPageLink();?>"><?php
				if(isset($global['title'])){
					echo Page::htmlEncode($global['title']);
				}
				else{
					echo Page::htmlEncode(T_('Thème standard'));
				}
			?></a>
		</h1>
		<div id="corps">
			<header>
	<?php $this->show('header');?>
			</header>