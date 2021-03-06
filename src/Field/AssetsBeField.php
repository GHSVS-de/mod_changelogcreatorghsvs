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

class AssetsBeField extends FormField
{
	protected $type = 'AssetsBe';

	// Path inside /media/.
	protected $basePath = 'mod_changelogcreatorghsvs';

	protected function getInput()
	{
		// Only explicit "false" will be respected.
		$loadjs     = isset($this->element['loadjs'])
			? (string) $this->element['loadjs'] : true;
		$loadcss    = isset($this->element['loadcss'])
			? (string) $this->element['loadcss'] : true;
		$loadJQuery = isset($this->element['loadJQuery'])
			? (string) $this->element['loadJQuery'] : true;

		$file = $this->basePath . '/backend';

		if ($loadcss !== 'false')
		{
			HTMLHelper::_('stylesheet',
				$file . '.css',
				array(
					'relative' => true,
					'version' => 'auto',
				)
			);
		}

		if ($loadJQuery !== 'false')
		{
			HTMLHelper::_('jquery.framework');
		}

		if ($loadjs !== 'false')
		{
			HTMLHelper::_('script',
				$file . '.js',
				array(
					'relative' => true,
					'version' => 'auto',
				)
			);
		}
		return '';
	}

	protected function getLabel()
	{
		return '';
	}
}
