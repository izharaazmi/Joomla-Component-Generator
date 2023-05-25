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

jimport('sellacious.loader');

/**
 * Create an empty class to meet the situation where sellacious backoffice is not installed yet.
 * In this case however, the backoffice part of the component will not be processed and
 * only the joomla frontend and backend files, and the database will be installed.
 */
if (!class_exists('SellaciousInstallerComponent'))
{
    class SellaciousInstallerComponent
    {
    }
}

/**
 * Script file of test component.
 *
 * The name of this class is dependent on the component being installed.
 * The class name should have the component's name, directly followed by
 * the text InstallerScript (ex:. com_testInstallerScript).
 *
 * This class will be called by Joomla!'s installer, if specified in your component's
 * manifest file, and is used for custom automation actions in its installation process.
 *
 * In order to use this automation script, you should reference it in your component's
 * manifest file as follows:
 * <scriptfile>script.php</scriptfile>
 *
 * @since   %VERSION%
 */
class Com_%COMPONENT_NAME_SHORT%InstallerScript extends SellaciousInstallerComponent
{
}
