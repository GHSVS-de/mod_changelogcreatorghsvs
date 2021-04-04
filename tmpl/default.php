<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$list = $params->get('changelog');
$html = [];

// Subtag <entry> instead of <item> to keep away from Joomla 4 display.
$ownTags = array(
	'requirement',
);

$collector = [];

$translates = [
	'download' => 'Direct download',
	'release' => 'Release page, more infos',
	'changelogs' => 'Changelogs',
	'lastTests' => 'Last tests'
];
$nl2br = [
	'note_lastTests'
];
$replaceWhat = [
	'<',
	'>',
];
$replaceWhith = [
	'&lt;',
	'&gt;',
];

$nl = "\n";

if (is_object($list) && count(get_object_vars($list)))
{
	#echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r($params, true) . '</pre>';
	
	$html[] = '<changelog>';
	
	$html[] = '<element>' . $params->get('element') . '</element>';
	$html[] = '<type>' . $params->get('type') . '</type>';
	$html[] = '<folder>' . $params->get('folder') . '</folder>';
	$html[] = '<version>' . $params->get('version') . '</version>';
	$html[] = '<docDE>' . $params->get('docDE') . '</docDE>';
	$html[] = '<docEN>' . $params->get('docEN') . '</docEN>';

	foreach ($list as $entry)
	{
		if (!($entry->text = trim($entry->text)))
		{
			continue;
		}
		
		if ($entry->replaceWhatWith === 1)
		{
			$entry->text = str_replace($replaceWhat, $replaceWhith, $entry->text);
		}
		
		if (in_array($entry->changeType, $nl2br))
		{
			$entry->text = nl2br($entry->text);
		}

		$changeType = explode('_', $entry->changeType);
		
		$mainTag = $changeType[0];
		
		// e.g. 'note_link_download'
		if (@$changeType[1] === 'link')
		{
			// e.g. target=>_blank
			$attributes = [];

			$entry->text = HTMLHelper::_('link', $entry->text, $translates[$changeType[2]]);
		}
		// e.g. note_lastTests or 'requirement_minimumJoomla'
		elseif (!empty($changeType[1]))
		{
			$pre = empty($translates[$changeType[1]]) ? $changeType[1] : $translates[$changeType[1]];
			
			$entry->text = $pre . ': ' . $entry->text;
		}
		
		$collector[$mainTag][] = $entry->text;
	}
	
	foreach ($collector as $tag => $entries)
	{
		$html[] = '<' . $tag . '>';

		if (\in_array($tag, $ownTags))
		{
			$html[] = '<entry><![CDATA[' . $nl
				. implode(
					$nl . ']]></entry>' . $nl . '<entry><![CDATA[' . $nl,
					$entries
				) . $nl
				. ']]></entry>';
		}
		else
		{
			$html[] = '<item><![CDATA[' . $nl
				. implode(
					$nl . ']]></item>' . $nl . '<item><![CDATA[' . $nl,
					$entries
				) . $nl
				. ']]></item>';
		}

		$html[] = '</' . $tag . '>';
	}
	$html[] = '</changelog>';
}
if ($html)
{
	$html   = implode($nl, $html);
	$file   = JPATH_SITE . '/media/mod_changelogcreatorghsvs/' . $module->id;
	file_put_contents($file . '.txt', $html);
	file_put_contents($file . '_' . $params->get('element'), '');
	# echo '<br><br><pre style="background-color:white">' .$nl . htmlentities($html) . '</pre>';#exit;
}
