<?php
/*
Loads assets for backend settings of extension.

Usage:
<field name="assetsbe" type="plgSystemVenoboxGhsvs.assetsbe" hidden="true"
	loadjs="false" loadJQuery="false" loadcss="true" />

If attributs loadjs or loadcss or loadJQuery are missing their default value is TRUE => Assets will be loaded. Use explicit "false" to not load!

Expects backend.css and/or backend.js in relative media path of $basepath
*/

namespace Joomla\Module\ChangelogCreatorGhsvs\Administrator\Field;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

class OutputField extends FormField
{
	protected $type = 'Output';

	// Path inside /media/.
	protected $basePath = 'mod_changelogcreatorghsvs';

	protected function getInput()
	{
		$jinput = Factory::getApplication()->getInput();
		$file   = JPATH_SITE . '/media/' . $this->basePath . '/' . $jinput->get('id') . '.txt';

		if (file_exists($file))
		{
			return '<pre>' . htmlentities(file_get_contents($file)) . '</pre>';
		}
	}

	protected function getLabel()
	{
		return '';
	}
}
