<?php
	use \gnk\config\Page;
	use \gnk\config\Config;
?>
			<h1>
				<a href="<?php echo Page::getLink(array('p' => Page::getDefaultPage()), false);?>">
					<?php
						$global = Config::getWebsiteConfig();
						if(isset($global['title'])){
							echo Page::htmlEncode($global['title']);
						}
						else{
							echo Page::htmlEncode(T_('Mon site'));
						}?>
				</a>
			</h1>