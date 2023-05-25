<?php
/**
 * @version     1.5.2
 * @package     sellacious
 *
 * @copyright   Copyright (C) 2012-2017 Codeacious Technologies Pvt Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Izhar Aazmi <hello@codeacious.tech> - https://www.codeacious.tech
 */

namespace Sellacious\Builder;

use DateTime;
use Exception;
use FilesystemIterator;
use Joomla\Filesystem\Folder;
use Joomla\String\Normalise;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Sellacious\Archive\Zip;

require_once __DIR__ . '/builder.php';
require_once __DIR__ . '/zip.php';


class Component extends Builder
{
	protected $name;

	protected $commonName;

	protected $shortName;

	protected $longName;

	protected $package = 'Sellacious';

	protected $authorName = 'Izhar Aazmi';

	protected $authorEmail = 'hello@codeacious.tech';

	protected $authorUrl = 'https://codeacious.tech';

	protected $version = '__DEPLOY_VERSION__';

	protected $views = [];

	protected $sellacious = true;

	protected $files = [];

	protected $outputDir;

	protected $replacements = [];

	protected $copyrightYear;

	protected $copyrightHolder = 'Codeacious Technologies Pvt Ltd.';

	protected $creationDate;

	protected $licenseType = 'GNU General Public License version 2 or later';

	/**
	 * @throws \Exception
	 */
	public function __construct($name, $package, $sellacious = true)
	{
		if (!defined('SKELETON_DIR') || !is_dir(SKELETON_DIR))
		{
			throw new Exception('The skeleton directory is not defined or it does not exist.');
		}

		$this->setName($name);

		$this->setPackage($package);

		$this->setCopyright(date('Y'));

		$this->sellacious = $sellacious;
	}

	/**
	 * @throws \Exception
	 */
	public function setName($name, $commonName = null)
	{
		if (strtolower($name) === $name || false !== strpos($name, ' '))
		{
			throw new Exception('You must provide component name in CamelCase');
		}

		$this->name = $name;

		$parts = Normalise::fromCamelCase($this->name, true);
		$words = implode(' ', $parts);
		$slug  = Normalise::toUnderscoreSeparated(strtolower($words));

		$this->commonName = $commonName ?: $words;
		$this->shortName  = $slug;
		$this->longName   = 'com_' . $slug;

		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function setPackage($name)
	{
		if (strtolower($name) === $name)
		{
			throw new Exception('You must provide package name in CamelCase');
		}

		$this->package = $name;

		return $this;
	}

	public function setCopyright($yearRange, $company = null)
	{
		if ($company)
		{
			$this->copyrightHolder = $company;
		}

		$this->copyrightYear = $yearRange;

		return $this;
	}

	public function setVersion($version)
	{
		$this->version = $version;

		return $this;
	}

	public function setAuthor($name, $email, $url)
	{
		$this->authorName  = $name;
		$this->authorEmail = $email;
		$this->authorUrl   = $url;

		return $this;
	}

	public function setCreationDate($date)
	{
		$this->creationDate = $date instanceof DateTime ? $date->format('F d, Y') : $date;

		return $this;
	}

	public function setLicenseType($license)
	{
		$this->licenseType = $license;

		return $this;
	}

	public function addView($name, $client = 'sellacious')
	{
		$this->views[$client][] = $name;

		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function generate($folder)
	{
		$this->prepare($folder);

		$this->setupReplacements();

		$this->createInstallSql();

		$this->createInstallScript();

		$this->genSite();

		$this->genAdministrator();

		if ($this->sellacious)
		{
			$this->genSellacious();
		}

		$this->createManifest();

		return $this;
	}

	/**
	 * @throws \Exception
	 */
	protected function prepare($folder)
	{
		if (trim($folder) === '' || !is_dir($folder))
		{
			throw new Exception('The given output folder does not exist');
		}

		$this->outputDir = rtrim($folder, '/');

		$iterator = new RecursiveDirectoryIterator($this->outputDir, FilesystemIterator::SKIP_DOTS);
		$files    = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($files as $file)
		{
			if ($file->isDir())
			{
				rmdir($file->getRealPath());
			}
			else
			{
				unlink($file->getRealPath());
			}
		}
	}

	protected function setupReplacements()
	{
		$this->replacements = [
			'VERSION'               => $this->version,
			'PACKAGE'               => $this->package,
			'COPYRIGHT_YEAR'        => $this->copyrightYear,
			'COPYRIGHT_HOLDER'      => $this->copyrightHolder,
			'AUTHOR_NAME'           => $this->authorName,
			'AUTHOR_EMAIL'          => $this->authorEmail,
			'AUTHOR_URL'            => $this->authorUrl,
			'COMPONENT_NAME_CC'     => $this->name,
			'COMPONENT_NAME_COMMON' => $this->commonName,
			'COMPONENT_NAME_SHORT'  => $this->shortName,
			'COMPONENT_NAME_LONG'   => $this->longName,
			'COMPONENT_NAME_CAPS'   => strtoupper($this->longName),
			'CREATION_DATE'         => $this->creationDate,
			'LICENSE_TYPE'          => $this->licenseType,
		];
	}

	/**
	 * @throws \Exception
	 */
	protected function createInstallSql()
	{
		$filenames = [
			"/administrator/sql/$this->longName.install.mysqli.sql"   => 'install_sql',
			"/administrator/sql/$this->longName.uninstall.mysqli.sql" => 'uninstall_sql',
			"/administrator/sql/updates/mysqli/1.0.0.sql"             => 'update_sql',
		];

		foreach ($filenames as $filename => $tmpl)
		{
			$this->writeFromTemplate($filename, $tmpl);
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function writeFromTemplate($filename, $template, $arguments = [])
	{
		$tpl = SKELETON_DIR . '/component/' . $template . '.tpl';

		if (!file_exists($tpl))
		{
			throw new Exception("The file template '$template' does not exist");
		}

		$content = file_get_contents($tpl);

		foreach ($this->replacements as $key => $replacement)
		{
			$content = str_replace("%$key%", $replacement, $content);
		}

		foreach ($arguments as $key => $replacement)
		{
			$content = str_replace("%$key%", $replacement, $content);
		}

		$file   = $this->outputDir . $filename;
		$folder = dirname($file);

		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		if (!is_dir($folder))
		{
			if (!Folder::create($folder))
			{
				throw new Exception(sprintf('The output folder %s is not writable', $folder));
			}
		}

		if (false === file_put_contents($file, $content))
		{
			throw new Exception('The output file is not writable');
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function createInstallScript()
	{
		if ($this->sellacious)
		{
			$this->writeFromTemplate('/install.php', 'install_script');
		}

		// Todo: Native joomla install script
	}

	/**
	 * @throws \Exception
	 */
	protected function genSite()
	{
		$this->createMain('site');
		$this->createController('site');

		if (isset($this->views['site']))
		{
			foreach ($this->views['site'] as $view)
			{
				$this->createController($view);
				$this->createModel($view);
				$this->createView($view);
			}
		}

		$this->createLanguage('site');
	}

	/**
	 * @throws \Exception
	 */
	protected function createMain($client)
	{
		$template = file_exists(SKELETON_DIR . '/component/main_' . $client . '.tpl') ? 'main_' . $client : 'main';

		$this->writeFromTemplate("/$client/$this->shortName.php", $template);
	}

	/**
	 * @throws \Exception
	 */
	protected function createController($client, $name = null)
	{
		$template = 'controller';

		$arguments = [
			'BASE_CONTROLLER' => $this->sellacious ? 'SellaciousControllerBase' : 'JControllerLegacy',
			'CONTROLLER_NAME' => ucfirst($name),
		];

		$this->writeFromTemplate("/$client/controller.php", $template, $arguments);
	}

	protected function createModel($name)
	{
		// @Todo
	}

	protected function createView($name)
	{
		// @Todo
	}

	/**
	 * @throws \Exception
	 */
	protected function createLanguage($client)
	{
		$filenames = [
			"/$client/language/en-GB/en-GB.$this->longName.ini"     => 'language',
			"/$client/language/en-GB/en-GB.$this->longName.sys.ini" => 'language_sys',
		];

		foreach ($filenames as $filename => $tmpl)
		{
			$this->writeFromTemplate($filename, $tmpl);
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function genAdministrator()
	{
		$this->createMain('administrator');
		$this->createController('administrator');

		if (isset($this->views['administrator']))
		{
			foreach ($this->views['administrator'] as $view)
			{
				$this->createController($view);
				$this->createModel($view);
				$this->createView($view);
			}
		}

		$this->createLanguage('administrator');
	}

	/**
	 * @throws \Exception
	 */
	protected function genSellacious()
	{
		$this->createMain('sellacious');
		$this->createController('sellacious');
		$this->createObserver();

		if (isset($this->views['sellacious']))
		{
			foreach ($this->views['sellacious'] as $view)
			{
				$this->createController($view);
				$this->createModel($view);
				$this->createView($view);
			}
		}

		$this->createLanguage('sellacious');
		$this->createMenuXml();
		$this->createConfigXml();
		$this->createAccessXml();
	}

	/**
	 * @throws \Exception
	 */
	protected function createObserver()
	{
		$this->writeFromTemplate("/sellacious/observer.php", 'observer');
	}

	/**
	 * @throws \Exception
	 */
	protected function createManifest()
	{
		$template = $this->sellacious ? 'manifest_sellacious' : 'manifest';

		$this->writeFromTemplate("/$this->shortName.xml", $template);
	}

	/**
	 * @throws \Exception
	 */
	public function archive()
	{
		$path = $this->outputDir . "/$this->longName.zip";

		Zip::create($this->outputDir, $path);

		return $path;
	}

	/**
	 * @throws \Exception
	 */
	protected function createMenuXml()
	{
		$this->writeFromTemplate("/sellacious/menu.xml", 'menu_xml');
	}

	/**
	 * @throws \Exception
	 */
	protected function createConfigXml()
	{
		$this->writeFromTemplate("/sellacious/config.xml", 'config_xml');
	}

	/**
	 * @throws \Exception
	 */
	protected function createAccessXml()
	{
		$this->writeFromTemplate("/sellacious/access.xml", 'access_xml');
	}
}
