<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @author		Paul Thickett
 */
class Plugin_Social extends Plugin
{
	public $version = '1.0.0';
	
	public $name = 
	[
		'en' => 'Social Plugin',
	];
	
	public $description = 
	[
		'en' => 'Social Sharing Plugin',
	];

	function twitter() 
	{

		$button = ($this->attribute('button')!='') ? $this->attribute('button') : '';
		$text = ($this->attribute('text')!='') ? $this->attribute('text') : '';
		$url = ($this->attribute('url')!='') ? $this->attribute('url') : '';
		$via = ($this->attribute('via')!='') ? $this->attribute('via') : 'DescargasMagnet';
		$lang = ($this->attribute('size')!='') ? $this->attribute('lang') : 'en';
		$size = ($this->attribute('size')=='large') ? $this->attribute('size') : '';
		$count = ($this->attribute('count')=='none') ? $this->attribute('count') : '';

		switch($button) {
			case 'share':
				$plugin = '
					<a
						href="https://twitter.com/share"
						class="twitter-share-button"
						data-url="'.$url.'"
						data-text="'.$text.'"
						data-via="'.$via.'"
						data-lang="'.$lang.'"
						data-size="'.$size.'"
						data-count="'.$count.'"
						>
						Twittear
					</a>
					';
				break;
			case 'follow':
				$plugin = '
					<a
						href="https://twitter.com/'.$via.'"
						class="twitter-follow-button"
						data-show-count="false"
						data-lang="'.$lang.'"
						data-size="'.$size.'"
						>
						Twittear
					</a>
					';
				break;
			case 'mention':
				$plugin ='
					<a
						href="https://twitter.com/intent/tweet?screen_name='.$via.'"
						class="twitter-mention-button"
						data-lang="'.$lang.'"
						data-size="'.$size.'"
						data-related="'.$via.'"
						>
						Tweet to @'.$via.'
					</a>
					';
					break;
		}
		$plugin .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			return $plugin;
	}

	function facebook() 
	{
		$appId = ($this->attribute('appId')!='') ? $this->attribute('appId') : '492870934064069';

		$href = ($this->attribute('href')!='') ? $this->attribute('href') : '';
		$send = ($this->attribute('send')!='') ? $this->attribute('send') : 'true';
		$width = ($this->attribute('width')!='') ? $this->attribute('width') : '450';
		$faces = ($this->attribute('faces')!='') ? $this->attribute('faces') : 'false';

		$plugin ='<div id="fb-root"></div>
			<script>(function(d, s, id) {
			    var js, fjs = d.getElementsByTagName(s)[0];
			    if (d.getElementById(id)) return;
			    js = d.createElement(s); js.id = id;
			    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$appId.'";
			    fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));</script>
			<div
				class="fb-like"
				data-href="'.$href.'"
				data-send="'.$send.'"
				data-width="'.$width.'"
				data-show-faces="'.$faces.'"
				>
			</div>';

		return $plugin;
	}

}
