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

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php _e('Server-Up - Edit or add server', ServerUp::TEXT_DOMAIN) ?></h2>

	<?php if ($configAdded) { ?>
		<div class="updated settings-error">
			<p><?php _e("Server successfully added.", ServerUp::TEXT_DOMAIN) ?></p>
		</div>
	<?php } ?>

	<?php if ($configUpdated) { ?>
		<div class="updated settings-error">
			<p><?php _e("Server successfully updated.", ServerUp::TEXT_DOMAIN) ?></p>
		</div>
	<?php } ?>
	
	<?php if (isset($upload_success) && $upload_success === true) { ?>
		<div class="updated settings-error">
			<p><?php _e("Server'icon successfully updated.", ServerUp::TEXT_DOMAIN) ?></p>
		</div>
	<?php } ?>
	
	<form name="<?php $formName ?>" method="POST" enctype="multipart/form-data" >
		<h3><?php _e('Settings', ServerUp::TEXT_DOMAIN) ?></h3>
		<input type="hidden" name="<?php echo $hiddenFieldName; ?>" value="Y">
		<input type="hidden" name="config-id" value="<?php echo ($config['id']) ?>">
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="servername" ><?php _e('Name', ServerUp::TEXT_DOMAIN) ?></label>
					</th>
					<td>
						<input type="text" name="servername" id="servername" value="<?php echo ($config['servername']) ?>" />
						<span class="description"><?php _e('Name of the server.', ServerUp::TEXT_DOMAIN) ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="serveradress" ><?php _e('Host', ServerUp::TEXT_DOMAIN) ?></label>
					</th>
					<td>
						<input type="text" name="serveradress" id="serveradress" value="<?php echo ($config['serveradress']) ?>" />
						<span class="description"><?php _e('Adress to the server. Can be an url or an ip adress.', ServerUp::TEXT_DOMAIN) ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="serverport" ><?php _e('Port', ServerUp::TEXT_DOMAIN) ?></label>
					</th>
					<td>
						<input type="text" name="serverport" id="serverport" value="<?php echo ($config['serverport']) ?>" />
						<span class="description"><?php _e('Port of the server', ServerUp::TEXT_DOMAIN) ?></span>
					</td>
				</tr>
				<!-- -->
				<tr>
					<th>
						<label for="servericon" ><?php _e('Visibility', ServerUp::TEXT_DOMAIN) ?></label>
					</th>
					<td>
						<input type="checkbox" name="servervisibility" id="servervisibility" value="1" <?php echo (($config['servervisibility']) ? 'checked="checked"' : '' ) ; ?> />
						<span class="description"><?php _e('Visibility of the server in widget and shortcode.', ServerUp::TEXT_DOMAIN) ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<label for="servericon" ><?php _e('Icon', ServerUp::TEXT_DOMAIN) ?></label>
					</th>
					<td>
						<input type="file" name="servericons" id="servericons" />
						<span class="description"><?php _e('Icon of the server.', ServerUp::TEXT_DOMAIN) ?></span>
					</td>
				</tr>
				<?php if ( !empty($config['servericons'])) { ?>
					<tr>
						<th>&nbsp;</th>
						<td>
							<img src="<?php echo $config['servericons'] ; ?>" alt="<?php echo $config['servericons'] ; ?>" title="<?php echo $config['servericons'] ; ?>" />
							<input type="hidden" name="servericons" id="servericons" value="<?php echo $config['servericons'] ; ?>" />
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save', ServerUp::TEXT_DOMAIN) ?>"/></p>
	</form>
</div>
