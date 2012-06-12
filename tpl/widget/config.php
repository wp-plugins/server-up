<?php 
/**
 * This file is part of Server-Up for Wordpress.
 * Copyright (C) 2012  Arnaud Grousset
 *
 * Server-Up  for Wordpress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Server-Up is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Server-Up for Wordpress. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Arnaud Grousset
 * @since 1.0
 *
 */
?>

<label for="<?php echo self::SERVERUP_WIDGET_ID ; ?>-title">
	<?php _e('Title :', ServerUp::TEXT_DOMAIN) ; ?>
</label>
<input class="widefat" type="text" name="<?php echo self::SERVERUP_WIDGET_ID ; ?>[title]" id="<?php echo self::SERVERUP_WIDGET_ID ; ?>-title" value="<?php echo $title ; ?>" />

<!-- 
<label for="<?php echo self::SERVERUP_WIDGET_ID ; ?>-uptime">
	<?php _e('Time between 2 automatic refresh (in second) :', ServerUp::TEXT_DOMAIN) ; ?>
</label>
<input class="widefat" type="text" name="<?php echo self::SERVERUP_WIDGET_ID ; ?>[uptime]" id="<?php echo self::SERVERUP_WIDGET_ID ; ?>-uptime" value="<?php echo $uptime ; ?>" />
<p>
	<?php _e("If you left it blank, automatic refresh will be deactivated", ServerUp::TEXT_DOMAIN) ; ?>
</p>
 -->

<input type="hidden" name="<?php echo self::SERVERUP_WIDGET_ID; ?>[submit]" value="1" />