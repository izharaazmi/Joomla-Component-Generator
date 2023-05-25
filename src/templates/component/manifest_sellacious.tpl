<?xml version="1.0" encoding="utf-8"?>
<extension type="component" version="3.0" method="upgrade">
	<name>%COMPONENT_NAME_LONG%</name>
	<author>%AUTHOR_NAME%</author>
	<creationDate>%CREATION_DATE%</creationDate>
	<copyright>Copyright (C) %COPYRIGHT_YEAR% %COPYRIGHT_HOLDER% All rights reserved.</copyright>
	<license>%LICENSE_TYPE%; see LICENSE.txt</license>
	<authorEmail>%AUTHOR_EMAIL%</authorEmail>
	<authorUrl>%AUTHOR_URL%</authorUrl>
	<version>%VERSION%</version>
	<description>%COMPONENT_NAME_CAPS%_XML_DESCRIPTION</description>
	<install>
		<sql>
			<file driver="mysqli" charset="utf8">sql/%COMPONENT_NAME_LONG%.install.mysqli.sql</file>
		</sql>
	</install>
	<uninstall>
		<sql>
			<file driver="mysqli" charset="utf8">sql/%COMPONENT_NAME_LONG%.uninstall.mysqli.sql</file>
		</sql>
	</uninstall>
	<update>
		<schemas>
			<schemapath type="mysql">sql/updates/mysqli</schemapath>
		</schemas>
	</update>
	<scriptfile>install.php</scriptfile>
	<files folder="site">
		<folder>language</folder>
		<filename>controller.php</filename>
		<filename>%COMPONENT_NAME_SHORT%.php</filename>
	</files>
	<administration>
		<files folder="administrator">
			<folder>language</folder>
			<folder>sql</folder>
			<filename>controller.php</filename>
			<filename>%COMPONENT_NAME_SHORT%.php</filename>
		</files>
	</administration>
	<sellacious>
		<files folder="sellacious">
			<folder>language</folder>
			<filename>access.xml</filename>
			<filename>config.xml</filename>
			<filename>menu.xml</filename>
			<filename>controller.php</filename>
			<filename>observer.php</filename>
			<filename>%COMPONENT_NAME_SHORT%.php</filename>
		</files>
	</sellacious>
	<updateservers>
		<server type="extension" name="%COMPONENT_NAME_COMMON% Updates">https://sellacious.com/release/updates/%COMPONENT_NAME_LONG%.xml</server>
	</updateservers>
</extension>
