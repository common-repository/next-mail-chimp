<?php
$active_tab = isset($_GET["tab"]) ? $_GET["tab"] : 'general';
?>
 <ul class="nav-tab-wrapper">
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-mailto&tab=general');?>" class="nav-tab <?php if($active_tab == 'general'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('General', 'next-mailchimp');?></a></li>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-mailto&tab=global');?>" class="nav-tab <?php if($active_tab == 'global'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('Global', 'next-mailchimp');?></a></li>
</ul>