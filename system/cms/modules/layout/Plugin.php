<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layout Plugin
 *
 * Brings Twig-like 'extends' functionality to the Lex language. See the module readme file
 * for documentation and examples
 *
 * @author		Lukas Anger
 * @copyright	Copyright (c) 2013, Lukas Angerer
 */
class Plugin_Layout extends Plugin
{
	public $version = '1.0.0';

	public $name = 
	[
		'en'	=> 'Layout'
	];

	public $description = 
	[
		'en'	=> 'The layout plugin brings Twig-like extends functionality to the Lex language.'
	];

	/**
	 * Returns a PluginDoc array that PyroCMS uses
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer
	 * to the Blog plugin for a larger example
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'extend' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Loads a base layout and injects layout partials into matching placeholder blocks'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'file',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(),
			),
			'placeholder' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Defines a placeholder block (with default content) where matching partials can override the default content'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'name',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(),
			),
			'partial' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Defines a partial layout that is injected into the placeholder of the same name'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'name',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(),
			),
		);

		return $info;
	}

	/**
	 * Gets the cached vars array store for partials (pretty annoing handling required due
	 * to PHP passing arrays by value and PyroCMS not working with references)
	 *
	 * @return Array
	 */
	private function &getStore()
	{
		$key = 'layout-module';
		if (!isset($this->load->_ci_cached_vars[$key]))
		{
			$this->load->_ci_cached_vars[$key] = array();
		}

		$store = &$this->load->_ci_cached_vars[$key];
		return $store;
	}

	/**
	 * placeholder
	 *
	 * Usage:
	 * {{ layout:placeholder name="placeholdername" }}
	 *   default content
	 * {{ /layout:placeholder }}
	 *
	 * @return string
	 */
	public function placeholder($blockName = 'placeholder')
	{
		$name = $this->attribute('name');
		$store = &$this->getStore();

		if (isset($store[$name]))
			return $store[$name];

		$content = $this->content();
		$content = is_string($content) ? $content : '';

		return  $this->parser->parse_string($content, array(), true, true);
	}

	/**
	 * partial
	 *
	 * Usage:
	 * {{ layout:partial name="placeholdername" }}
	 *   content
	 * {{ /layout:partial }}
	 *
	 * @return string
	 */
	public function partial($blockName = 'partial')
	{
		$name = $this->attribute('name');
		$store = &$this->getStore();

		$content = $this->content();
		$content = is_string($content) ? $content : '';

		$parsedContent = $this->parser->parse_string($content, array(), true, true);
		$store[$name] = $parsedContent;
	}

	/**
	 * extend
	 *
	 * Usage:
	 * {{ layout:extend file='layouts/base-layout.html' }}
	 *   {{ layout:content name='body' }}
	 *     my body
	 *   {{ /layout:content }}
	 * {{ /layout:extend }}
	 *
	 * @return string
	 */
	public function extend($name = 'extend')
	{
		$baseLayoutFile = $this->attribute('file', NULL);

		$path = $this->load->get_var('template_views');
		$string = $this->load->file($path . $baseLayoutFile, true);

		$content = $this->content();
		$content = is_string($content) ? $content : '';
		$this->parser->parse_string($content, [], true, true);

		return $this->parser->parse_string($string, [], true, true);
	}

	/**
	 * Allows nested extend blocks by mapping any plugin call that starts with the
	 * 'extends_' prefix to the default 'extends' function
	 */
	public function __call($name, $arguments)
    {
    	$matches = [];

    	if (preg_match('/^(extend_\w+)$/', $name, $matches))
    	{
    		return $this->extend($matches[1]);
    	}
    	elseif (preg_match('/^(placeholder_\w+)$/', $name, $matches))
    	{
    		return $this->placeholder($matches[1]);
    	}
    	elseif (preg_match('/^(partial_\w+)$/', $name, $matches))
    	{
    		return $this->partial($matches[1]);
    	}
    }
}
