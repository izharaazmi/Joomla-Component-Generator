#!/Applications/XAMPP/bin/php
<?php
/**
 * @version     1.0.0
 * @package     sellacious
 *
 * @copyright   Copyright (C) 2012-2023 Codeacious Technologies Pvt Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Izhar Aazmi <hello@codeacious.tech> - https://www.codeacious.tech
 */

use Sellacious\Builder\Component;
use Sellacious\Cli\Prompt;

if (version_compare(PHP_VERSION, '5.6', '<'))
{
	echo "The builder script requires PHP 5.6.\n";

	exit(1);
}

setlocale(LC_ALL, 'en_GB');
date_default_timezone_set('Europe/London');

define('BUILD_CLI_COMMAND', $argv[0]);
const JPATH_ROOT = __DIR__;
const SKELETON_DIR = __DIR__ . '/src/templates';

/* ######### DO NOT EDIT BELOW THIS LINE ######### */
// require_once __DIR__ . '/includes/input.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/includes/prompt.php';
require_once __DIR__ . '/src/includes/component.php';

Prompt::say("\nWelcome to the sellacious component generator utility.\n\n");

try
{
	$component = new Component('SellaciousDataExchange', 'Sellacious');

	$path = $component->setName('SellaciousDataExchange', 'Data Exchange')
		->setCopyright('2022-23')
		->generate(__DIR__ . '/output')->archive();

	Prompt::say("Component generated at {$path}\n\n");
}
catch (Exception $e)
{
	Prompt::errorMessage($e->getMessage());
}

