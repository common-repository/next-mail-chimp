
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-mailto&tab=general');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('General Services', 'next-mailchimp');?></h3>
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<div class="flex-form">
			<div class="left-div">
				<label for="ebay_show_sold_product" class="inline-label">
					<?php echo esc_html__('Enable MailChimp ', 'next-mailchimp');?>
				</label>
			</div>
			<div class="right-div">
				<input type="checkbox" onclick="themedevmail_show(this);" nx-target=".next-custom-login-page" name="themedev[general][mail][ebable]" <?php echo isset($getGeneral['general']['mail']['ebable']) ? 'checked' : ''; ?>  class="themedev-switch-input" value="Yes" id="themedev-enable_feed">
				<label class="themedev-checkbox-switch" for="themedev-enable_feed">
					<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
				</label>
				<span class="themedev-document-info block"> <?php echo esc_html__('Enable mail service for collect subscriber email.', 'next-mailchimp');?></span>
			</div>
		</div>
	</div>
	<div class="<?php echo esc_attr('themeDev-form');?>  next-custom-login-page nx-hide-target <?php echo isset($getGeneral['general']['mail']['ebable']) ? 'nx-show-target' : ''?>" >
		<div class="flex-form">
			<div class="left-div">
				<label for="themedev-mail_api_key" class="inline-label">
					<?php echo esc_html__('API key : ', 'next-mailchimp');?>
				</label>
			</div>
			<div class="right-div">
				<input type="text" name="themedev[general][mail][api_key]" class="themedev-text-input inline-block" value="<?php echo isset($getGeneral['general']['mail']['api_key']) ? $getGeneral['general']['mail']['api_key'] : ''; ?>" id="themedev-mail_api_key"/>
				<span class="themedev-document-info block"> <?php echo esc_html__('Enter MailChimp API keys.', 'next-mailchimp');?></span>
				<a href="<?php echo esc_url('https://admin.mailchimp.com/account/api')?>" target="_blank"> <?php echo __('Get your API key here.', '');?> </a>
			</div>
		</div>
	</div>
	<div class="<?php echo esc_attr('themeDev-form');?>  next-custom-login-page nx-hide-target <?php echo isset($getGeneral['general']['mail']['ebable']) ? 'nx-show-target' : ''?>" >
		<div class="flex-form">
			<div class="left-div">
				<label for="themedev-mail_api_listed" class="inline-label">
					<?php echo esc_html__('Listed : ', 'next-mailchimp');?>
				</label>
			</div>
			<div class="right-div">
				<ul class="next-custom-post-ul">
					<?php 
					if( is_array($listed) && sizeof($listed) > 0){
						foreach( $listed as $v):
						?>
						<li>
							<label for="custom_post_content<?php echo $v['id'];?>"><?php echo esc_html__($v['id'] .' - '. $v['name'], 'next-mailchimp');?>	</label>
						</li>
						<?php endforeach;
					}
					?>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-mail-general" class="themedev-submit"> <?php echo esc_html__('Save ', 'next-mailchimp');?></button>
	</div>
</form>