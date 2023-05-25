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

use Joomla\Event\AbstractEvent;
use Joomla\Event\Dispatcher;
use Joomla\Event\Event;
use Joomla\Event\Priority;
use Sellacious\Event\Observer\AbstractObserver;

/**
 * %COMPONENT_NAME_COMMON% event observer
 *
 * @since  %VERSION%
 */
class Com%COMPONENT_NAME_CC%Observer extends AbstractObserver
{
	/**
	 * Constructor
	 *
	 * @since   %VERSION%
	 */
	public function __construct(Dispatcher $dispatcher)
	{
		// Preload or set autoloader for any library, language etc. as may be required

		parent::__construct($dispatcher);
	}

	/**
	 * Method to return events to be observed by this observer
	 *
	 * @return  array  An array of events with method name as key and priority as value
	 *
	 * @since   %VERSION%
	 */
	protected function getEventsMap()
	{
		return [
			'onLoadMenu' => Priority::NORMAL,
		];
	}

	/**
	 * Handler for the menu setup event
	 *
	 * @param   AbstractEvent  $event  The event object
	 *
	 * @return  void
	 *
	 * @since   %VERSION%
	 */
	public function onLoadMenu(AbstractEvent $event)
	{
		if (file_exists(__DIR__ . '/menu.xml'))
		{
			/** @var  Event $event */
			$menu = simplexml_load_string(file_get_contents(__DIR__ . '/menu.xml'));

			if ($menu instanceof SimpleXMLElement)
			{
				$menus   = $event->getArgument('menus', array());
				$menus[] = $menu;

				$event->setArgument('menus', $menus);
			}
		}
	}
}
