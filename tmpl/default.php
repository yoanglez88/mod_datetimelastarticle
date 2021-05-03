<?php

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
$lang = JFactory::getLanguage();

function getRangeDateString($timestamp, $time_published) {
    if ($timestamp) {
        $currentTime=strtotime('today');
        // Reset time to 00:00:00
        $timestamp=strtotime(date('Y-m-d 00:00:00',$timestamp));
        $days=round(($timestamp-$currentTime)/86400);
        switch($days) {
            case '0';
				$text = Text::_('COM_DATETIMELASTARTICLE_APP_TODAY');
                return $text." ".$time_published;
                break;
            case '-1';
				$text = Text::_('COM_DATETIMELASTARTICLE_APP_YESTERDAY');
                return $text." ".$time_published;
                break;
            case '-2';
				$text = Text::_('COM_DATETIMELASTARTICLE_APP_DAYBEFOREYESTERDAY');
                return $text." ".$time_published;
                break;
            case '1';
				$text = Text::_('COM_DATETIMELASTARTICLE_APP_TOMORROW');
                return $text." ".$time_published;
                break;
            case '2';
				$text = Text::_('COM_DATETIMELASTARTICLE_APP_DAYAFTERTOMORROW');
                return $text." ".$time_published;
                break;
            default:
                if ($days > 0) {
                    return 'EN '.$days.' DIAS';
                } else {
                    return ($days*-1).' DIAS ATRAS';
                }
                break;
        }
    }
}

$config = JFactory::getConfig();
$offset = $config->get('config.offset');

$show_currentdate	= $params->get( 'show_currentdate', 1 );
$show_lastarticledate	= $params->get( 'show_lastarticledate', 1 );
$formatdatetime	= $params->get( 'formatdatetime', 1 );

if($lang->getTag() == "es-ES"){
	$fecha = JHTML::_('date', htmlspecialchars( $article->publish_up ),"\A\R\T\E\M\I\S\A, d \D\E F \D\E Y", $offset);
} else if($lang->getTag() == "en-GB") {
	$fecha = JHTML::_('date', htmlspecialchars( $article->publish_up ),"\A\R\T\E\M\I\S\A, F d, Y", $offset);
}
$tag = JHTML::_('date', htmlspecialchars( $article->publish_up ),"d-m-Y H:i:s", $offset);
$time_published = JHTML::_('date', htmlspecialchars( $article->publish_up ),'H:i:s', $offset);

?>
<div class="datetimelastarticle">
	<p class="datetime-header"><?php echo $fecha ?></p>
	<p class="datetime-title"><?= Text::_('COM_DATETIMELASTARTICLE_APP_LASTUPDATE'); ?></p>
	<p class="datetime-value">
		<?php echo '<time datetime="'.$tag.'">'.getRangeDateString(strtotime($tag), $time_published).'</time>'; ?>
	</p>
</div>
