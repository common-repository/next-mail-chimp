<section class="<?php echo esc_attr('themeDev-mail-body');?>">
	<div class="header-settings">
		<figure>
			<img src="<?php echo NEXT_MAIL_PLUGIN_URL.'assets/images/icon-128x128.png'?>" alt="<?php esc_attr('Icon')?>">
		</figure>
		<h2 class="title"><?php echo esc_html__('Next Mail', 'next-mailchimp');?></h2>
	</div>
	<div class="nav-settings">
		<?php require ( NEXT_MAIL_PLUGIN_PATH.'views/admin/tab-menu-settings.php' );?>
	</div>
	<?php if($message_status == 'yes'){?>
    <div class="message-settings">
        <div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
            <p><?php echo esc_html__(''.$message_text.' ', 'next-mailchimp');?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'next-mailchimp');?></span></button>
        </div>
    </div>
    <?php }?>
	<div class="settings-content">
		 <?php
		 if($active_tab == 'settings'){ 
			include( __DIR__ .'/include/option-settings.php');
		 }else if($active_tab == 'general'){
			 include( __DIR__ .'/include/option-general.php');
		 }else if($active_tab == 'global'){
			 include( __DIR__ .'/include/option-global.php');
		 }else if($active_tab == 'providers'){
			 include( __DIR__ .'/include/option-providers.php');
		 }else if($active_tab == 'shotrcode'){
			 include( __DIR__ .'/include/option-shotrcode.php');
		 }
		 ?>
	 </div>
</section>
