<?php
namespace Joomla\Module\ChangelogCreatorGhsvs\Administrator\Field;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;

abstract class AbstractStatsField extends FormField
{
	/**
	 * Get the layouts paths
	 *
	 * @return  array
	 *
	 * @since   3.5
	 */
	protected function getLayoutPaths()
	{
		$template = Factory::getApplication()->getTemplate();

		return array(
			JPATH_ADMINISTRATOR . '/templates/' . $template . '/html/layouts/plugins/system/stats',
			JPATH_PLUGINS . '/system/stats/layouts',
			JPATH_SITE . '/layouts',
		);
	}
}
