
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-mailto&tab=global');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Global Services', 'next-mailchimp');?></h3>
	<div class="custom-login-div">
		<div class="<?php echo esc_attr('themeDev-form');?>">
			<div class="flex-form">
				<div class="left-div">
					<label for="ebay_show_sold_product" class="inline-label">
						<?php echo esc_html__('Enable Popup ', 'next-mailchimp');?>
					</label>
				</div>
				<div class="right-div">
					<input type="checkbox" onclick="themedevmail_show(this);" nx-target=".next-custom-login-popup" name="themedev[global][popup][ebable]" <?php echo isset($getGlobal['global']['popup']['ebable']) ? 'checked' : ''; ?>  class="themedev-switch-input" value="Yes" id="themedev-enable_popup_feed">
					<label class="themedev-checkbox-switch" for="themedev-enable_popup_feed">
						<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
					</label>
					<span class="themedev-document-info block"> <?php echo esc_html__('Enable mail popup service for show popup box in body.', 'next-mailchimp');?></span>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr('themeDev-form');?>  next-custom-login-popup nx-hide-target <?php echo isset($getGlobal['global']['popup']['ebable']) ? 'nx-show-target' : ''?>" >
			<div class="flex-form">
				<div class="left-div">
					<label for="next_mail_listed_id" class="inline-label">
						<?php echo esc_html__('Select Form ', 'next-mailchimp');?>
					</label>
				</div>
				<div class="right-div">
					<select class="themedev-text-input inline-block" name="themedev[global][popup][listed_id]" id="next_mail_listed_id">
						<?php 
						$listed_id = isset($getGlobal['global']['popup']['listed_id']) ? $getGlobal['global']['popup']['listed_id'] : 0;
						if( is_array($forms) && sizeof($forms) > 0){
							foreach( $forms as $k=>$v):
						?>
						<option value="<?php echo $k;?>" <?php echo ($k == $listed_id) ? 'selected' : '';?>> <?php echo esc_html__($v, 'next-mailchimp');?> </option>
						<?php endforeach;
						}
						?>
					</select>
					<span class="themedev-document-info block"> <?php echo esc_html__('Select Listed name for show Display Mail Popup Box in Body. ', 'next-mailchimp');?></span>
				</div>
			</div>
		</div>
		<div class="themeDev-form next-custom-login-popup nx-hide-target <?php echo isset($getGlobal['global']['popup']['ebable']) ? 'nx-show-target' : ''?>" id="next-custom-login-page">
			<div class="flex-form">
				<div class="left-div">
					<label class="inline-label">
						<?php echo esc_html__('Popup Mail ', 'next-mailchimp');?>			
					</label>
					<span class="themedev-document-info block">  <?php echo esc_html__('Set Position for Mail Popup in Body', 'next-mailchimp');?></span>
				</div>
				<div class="right-div">
					<ul class="next-custom-post-ul">
						<?php 
						$body_position = isset($getGlobal['global']['popup']['body_position']) ? $getGlobal['global']['popup']['body_position'] : 'center_content';
						foreach( self::$body_position as $k=>$v):
						?>
							<li>
								<input type="radio" <?php echo ($body_position == $k) ? 'checked' : '';?> name="themedev[global][popup][body_position]" id="custom_post_<?php echo $k;?>" value="<?php echo $k;?>">
								<label for="custom_post_<?php echo $k;?>"><?php echo esc_html__($v, 'next-mailchimp');?>	</label>
								
						</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr('themeDev-form');?>  next-custom-login-popup nx-hide-target <?php echo isset($getGlobal['global']['popup']['ebable']) ? 'nx-show-target' : ''?>" >
			<div class="flex-form">
				<div class="left-div">
					<label for="themedev-mail_api_timing" class="inline-label">
						<?php echo esc_html__('Display Timing : ', 'next-mailchimp');?>
					</label>
				</div>
				<div class="right-div">
					<input type="text" name="themedev[global][popup][timing]" class="themedev-text-input inline-block" value="<?php echo isset($getGlobal['global']['popup']['timing']) ? $getGlobal['global']['popup']['timing'] : ''; ?>" id="themedev-mail_api_timing"/>
					<span class="themedev-document-info block"> <?php echo esc_html__('Set timing for show Display Mail Popup Box in Body. ', 'next-mailchimp');?></span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-mail-global" class="themedev-submit"> <?php echo esc_html__('Save ', 'next-mailchimp');?></button>
	</div>
</form>