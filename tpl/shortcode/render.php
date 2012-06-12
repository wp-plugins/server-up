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

<?php if (sizeof($list_server) != 0) { ?>
	
	<table id="server-list">
		<tbody>
			
			<?php foreach ($list_server as $server) { ?>
				
				<tr>
					<td class="icon" >
						<?php if ( !empty($server['servericons'])) { ?>
							<img class="server-icon" src="<?php echo $server['servericons'] ; ?>" alt="default-icons" />
						<?php } else { ?>
							<img class="server-icon" src="<?php echo $this->serverup->pluginUrl . 'img/default_icon.png' ; ?>" alt="default-icons" />
						<?php } ?>
					</td>
					<td>
						<span class="server-name" ><?php echo $server['servername'] ; ?></span>
					</td>
					<td class="status" >
						
						<?php if ($server['serverstatus'] === true) { ?>
							
							<span class="server-status server-online" title="<?php _e('Server online.', ServerUp::TEXT_DOMAIN) ; ?>" >&nbsp;</span>
						<?php } else { ?>
							
							<span class="server-status server-offline" title="<?php _e('Server down.', ServerUp::TEXT_DOMAIN) ; ?>" />&nbsp;</span>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else { ?>
	
	<?php _e("No server to display.", ServerUp::TEXT_DOMAIN) ; ?>
<?php } ?>