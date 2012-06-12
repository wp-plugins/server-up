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
	<h2><?php _e('Server-Up - List server', ServerUp::TEXT_DOMAIN) ?></h2>
	
	<?php if (count($configs) == 0) { ?>
		<div class="error settings-error">
			<p><?php _e("You didn't add any servers yet. Please create ones", ServerUp::TEXT_DOMAIN) ?></p>
		</div>
	<?php } ?>
	
	<?php if ($configDeleted) { ?>
		<div class="updated settings-error">
			<p><?php _e("Server(s) successfully deleted.", ServerUp::TEXT_DOMAIN) ?></p>
		</div>
	<?php } ?>
	
	<h3><?php _e('Servers', ServerUp::TEXT_DOMAIN) ?></h3>
	
	<form action method="POST">
		<div class="tablenav">
			<input type="submit" class="button-secondary" value="<?php _e('Delete', ServerUp::TEXT_DOMAIN) ?>">
		</div>
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" /></th>
					<th scope="col"><?php _e('ID', ServerUp::TEXT_DOMAIN) ?></th>
					<th scope="col"><?php _e('Name', ServerUp::TEXT_DOMAIN) ?></th>
					<th scope="col"><?php _e('Host', ServerUp::TEXT_DOMAIN) ?></th>
					<th scope="col"><?php _e('Port', ServerUp::TEXT_DOMAIN) ?></th>
					<th scope="col"><?php _e('Icon', ServerUp::TEXT_DOMAIN)?></th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php foreach ($configs as $config) { ?>
					<tr>
						<th class="check-column">
							<input type="checkbox" name="delete[]" value="<?php echo($config['id']) ; ?>" />
						</th>
						<td><?php echo $config['id'] ?></td>
						<td>
							<a href="<?php echo ($adminURL . 'admin.php?page=' . $menuName . '&id=' . $config['id']) ?>" title="<?php _e('Edit', ServerUp::TEXT_DOMAIN) ?>">
								<?php echo $config['servername'] ?>
							</a>
						</td>
						<td><?php echo $config['serveradress'] ?></td>
						<td><?php echo $config['serverport'] ?></td>
						<td><?php ($config['servericon'] ? _e('Yes', ServerUp::TEXT_DOMAIN) : _e('No' , ServerUp::TEXT_DOMAIN)); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>
</div>