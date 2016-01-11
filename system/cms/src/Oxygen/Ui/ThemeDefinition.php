<?php namespace Oxygen\Ui;

class ThemeDefinition extends \SimpleXMLElement
{
	static public function speak()
	{
		
	}	

	/**
	 * Lets install all the areas for widgets.
	 *
	 */
	public function installWidgetAreas()
	{
		$areas = $this->Widgets->Areas->children();
		foreach($areas as $area)
		{
			$_name = $area['Name'];
			$_desc = $area;
			echo 'Speaking to ' . $_desc . '<br>';
		}	
	}

	/**
	 * Loop through all the required modules
	 * if there are, lets check to see if they are already installed.
	 * If not, install them
	 */
	public function installRequiredModules()
	{

	}

	/**
	 * Some modules are not compatible with the theme, we wont uninstall them,
	 * but we will disable them
	 */
	public function disabledRestrictedModules()
	{

	}	
}