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
	use \gnk\config\Template;
	$template = new Template();
	$template->addTitle(T_('Droit d\'auteur'));
	$template->show('header_full');
?>
			<article>
				<h1><?php echo T_('Droit d\'auteur'); ?></h1>
				<header>
					<p>
						<?php echo T_('LocalizeTeaPot comporte de nombreuses licences sur son contenu et sur ses sources, vous trouverez dans cette partie du site toutes les informations relatives à ces licences');?>
					</p>
				</header>
				<section>
					<h1><?php echo T_('Serveur'); ?></h1>
					<ul>
						<li><a href="http://www.gnu.org/licenses/agpl.html"><?php echo T_('Utilisation de la licence AGPL v3 pour les sources');?></a></li>
						<li><a href="http://creativecommons.org/licenses/by-sa/3.0/"><?php echo T_('Utilisation de la licence Creative Commons BY SA 3.0 pour les ressources graphiques et le contenu des pages');?></a></li>
					</ul>
					<footer>
						<p>
							<?php echo T_('Vous trouverez les sources du serveur à l\'adresse suivante :');?><br />
							<a href="https://github.com/Gnuk/ltp_site" title="<?php echo T_('Code source du site') ;?>">https://github.com/Gnuk/ltp_site</a>
						</p>
					</footer>
				</section>
				<section>
					<h1><?php echo T_('Client'); ?></h1>
					<ul>
						<li><a href="http://www.cecill.info/licences/Licence_CeCILL_V2-en.html"><?php echo T_('Utilisation de la licence CeCILL v2 pour les sources');?></a></li>
					</ul>
					<footer>
						<p>
							<?php echo T_('Vous trouverez les sources du client Android à l\'adresse suivante :');?><br />
							<a href="https://github.com/Gnuk/ltp_client_osm" title="<?php echo T_('Code source du client Android') ;?>">https://github.com/Gnuk/ltp_client_osm</a>
						</p>
					</footer>
				</section>
			</article>
<?php
	$template->show('footer_full');
?>