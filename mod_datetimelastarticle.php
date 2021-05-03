<?php
defined('_JEXEC') or die;

$doc			= JFactory::getDocument();
$modulebase		= ''.JURI::base(true).'/modules/mod_datetimelastarticle/';

require_once dirname(__FILE__).'/helper.php';

$config = JFactory::getConfig();
$offset = $config->get('config.offset');

$doc->addStyleSheet($modulebase.'assets/style.css');
$article = DateTimeLastArticle::getlatestarticle();

require JModuleHelper::getLayoutPath('mod_datetimelastarticle', $params->get('layout', 'default'));


