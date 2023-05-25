<?php
/**
 * @version     %VERSION%
 * @package     %PACKAGE%
 *
 * @copyright   Copyright (C) %COPYRIGHT_YEARS% %COPYRIGHT_HOLDER% All rights reserved.
 * @license     %LICENSE_TYPE%; see LICENSE.txt
 * @author      %AUTHOR_NAME% <%AUTHOR_EMAIL%> - %AUTHOR_URL%
*/
defined('_JEXEC') or die;

JLoader::import('sellacious.loader');

if (!class_exists('SellaciousHelper'))
{
	throw new Exception('The sellacious library is either missing or is not installed.');
}

if (!defined('S_VERSION_CORE'))
{
	throw new Exception('This version of sellacious is not supported.');
}

$app        = JFactory::getApplication();
$helper     = SellaciousHelper::getInstance();
$controller = JControllerLegacy::getInstance('%COMPONENT_NAME_CC%');
$task       = $app->input->getCmd('task');

$language = JFactory::getLanguage();
$current  = $language->getTag();

$language->load('%COMPONENT_NAME_LONG%', JPATH_SELLACIOUS . '/components/%COMPONENT_NAME_LONG%', 'en-GB');
$language->load('%COMPONENT_NAME_LONG%', JPATH_SELLACIOUS, 'en-GB');
$language->load('%COMPONENT_NAME_LONG%', JPATH_SELLACIOUS . '/components/%COMPONENT_NAME_LONG%', $current);
$language->load('%COMPONENT_NAME_LONG%', JPATH_SELLACIOUS, $current);

JTable::addIncludePath(__DIR__ . '/tables');
JFormHelper::addFieldPath(__DIR__ . '/models/fields');

$controller->execute($task);
$controller->redirect();

// Meta Redirect check will occur only if not redirected by the controller above
$helper->core->metaRedirect();
