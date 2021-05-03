<?php

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class DateTimeLastArticle
{
    public static function getlatestarticle()
	{
		$db = JFactory::getDBO();

		$articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
				
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$articles->setState('params', $appParams); 
		
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$articles->setState('filter.access', $access);
		
		$articles->setState('filter.language',$app->getLanguageFilter());
		$articles->setState('list.limit', 1);
		$articles->setState('filter.published', 1);
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
		$ordering = JArrayHelper::getValue($order_map, $appParams->get('ordering_articles'), 'a.publish_up');
		$articles->setState('list.ordering', $ordering);
		$articles->setState('list.direction', 'DESC');
		$article = $articles->getItems()[0];

        return $article;
    }
	
	public static function getURL($item)
	{
		$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
		return $item->link;
	}
}