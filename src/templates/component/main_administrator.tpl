<?php
/**
 * @version     %VERSION%
 * @package     %PACKAGE%
 *
 * @copyright   Copyright (C) %COPYRIGHT_YEAR% %COPYRIGHT_HOLDER% All rights reserved.
 * @license     %LICENSE_TYPE%; see LICENSE.txt
 * @author      %AUTHOR_NAME% <%AUTHOR_EMAIL%> - %AUTHOR_URL%
 */
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('%COMPONENT_NAME_CC%');
$task       = JFactory::getApplication()->input->get('task');

$controller->execute($task);
$controller->redirect();
