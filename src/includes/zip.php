<?php
/**
 * @version     1.5.2
 * @package     sellacious
 *
 * @copyright   Copyright (C) 2012-2017 Codeacious Technologies Pvt Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Izhar Aazmi <hello@codeacious.tech> - https://www.codeacious.tech
 */

namespace Sellacious\Archive;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class Zip
{
	/**
	 * @throws \Exception
	 */
	public static function create($folderPath, $zipPath)
	{
		$zip = new ZipArchive();

		if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true)
		{
			throw new Exception("Failed to create zip file");
		}

		$iterator = new RecursiveDirectoryIterator($folderPath);
		$files    = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::LEAVES_ONLY);

		foreach ($files as $file)
		{
			if (!$file->isDir())
			{
				$relativePath = substr($file->getPathname(), strlen($folderPath) + 1);

				$zip->addFile($file->getPathname(), $relativePath);
			}
		}

		if ($zip->close() !== true)
		{
			throw new Exception("Failed to compress zip file");
		}
	}
}
