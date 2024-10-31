<section class="<?php echo esc_attr('themeDev-ebay-body');?>">
	<h3><?php echo esc_html__('Label', 'themedev-ebay-advanced-search');?></h3>
	
	<form action="" name="setting_ebay_form" method="post" >
		
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<label for="ebay_label_name">
				<?php echo esc_html__('Label Name: ', 'themedev-ebay-advanced-search');?>
			</label>
			<?php
			$getLabel = isset($getLabelData->label_name) ? $getLabelData->label_name : '';
			?>
			<input class="regular-text code themedev-input-text " type="text" id="ebay_label_name" name="themedevebay[label_name]" value="<?php echo esc_html($getLabel);?>">
		</div>
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<label for="ebay_type_list">
				 <?php echo esc_html__('Display Type:', 'themedev-ebay-advanced-search');?>
			</label>
			<?php
			$typeData = ['Text' => 'Text' , 'Checkbox' => 'Checkbox', 'Radio' => 'Radio', 'Select' => 'Select'];
			$getlabel_type  = isset($getLabelData->label_type) ? $getLabelData->label_type : '';
			?>
			<select name="themedevebay[label_type]" class="regular-text code themeDev-select" id="ebay_type_list">
				<?php 
				if(is_array($typeData) AND sizeof($typeData) > 1):
					foreach($typeData AS $k=>$v):	
					?>
					<option value="<?php echo esc_html($k);?>" <?php echo ($getlabel_type === $k) ? 'selected' : ''?>> <?php echo esc_html($v) ;?> </option>
					<?php
					endforeach;
				endif;
				?>
			</select>
			
		</div>
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<button type="submit" name="themedev-ebay-label-submit" class="themedev-ebay-submit"> <?php echo esc_html__('Save ', 'themedev-ebay-advanced-search');?></button>
		</div>
	</form>
</section>	
<section class="<?php echo esc_attr('themeDev-ebay-body');?>">
	<h2><?php echo esc_html__('Label List', 'themedev-ebay-advanced-search');?></h2>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th style="width:20px;"> <strong> <?php echo esc_html__('SL.', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Label ', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Display Type ', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Action', 'themedev-ebay-advanced-search');?></strong></th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		if(is_array($outputDataLabel) && sizeof($outputDataLabel) > 0):
			$m = 1;
			foreach($outputDataLabel as $v):
			?>
				<tr valign="middle"> 
					<td ><strong><?php echo $m; ?>. </strong></td>
					<td ><?php echo isset($v->label_name) ? esc_html( $v->label_name ) : ''; ?></td>
					<td ><?php echo isset($v->label_type) ? esc_html( $v->label_type ) : ''; ?></td>
					<td >
						<div class="row-actions" style="left: 0px;">
							<span><a href="<?php echo esc_url(admin_url().'admin.php?page=themedev-ebay-search-advanced&tab=label&labelid='.$v->label_id.'&type=edit');?>"><?php echo esc_html__('Edit', 'themedev-ebay-advanced-search');?></a> |</span>
							<span><a href="<?php echo esc_url(admin_url().'admin.php?page=themedev-ebay-search-advanced&tab=label&labelid='.$v->label_id.'&type=delete');?>"><?php echo esc_html__('Delete', 'themedev-ebay-advanced-search');?></a></span>
						</div>
					</td>
				</tr>
			<?php
			$m++;	
			endforeach;
		endif;
		?>
		</tbody>
	</table>
</section>	