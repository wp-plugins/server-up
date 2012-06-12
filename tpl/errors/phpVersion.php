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
 * along with Server-Up for Wordpress.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Arnaud Grousset
 * @since 1.0
 *
 */
?>

<div class="error settings-error">
	<p><?php _e('The PHP-Version of your webspace is too low. You need at least version 5.3.2', ServerUp::TEXT_DOMAIN) ?></p>
	<p><strong><?php _e('Your version:', ServerUp::TEXT_DOMAIN)?></strong> <?php echo (phpversion()) ?></p>
	<p><?php _e('Please upgrade to a newer version and install the plugin again', ServerUp::TEXT_DOMAIN)?></p>
</div>