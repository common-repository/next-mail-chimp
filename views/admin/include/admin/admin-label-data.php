<section class="<?php echo esc_attr('themeDev-ebay-body');?>">
	<h3><?php echo esc_html__('Label Data', 'themedev-ebay-advanced-search');?></h3>
	
	<form action="" name="setting_ebay_form" method="post" >
		
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<label for="ebay_label_data_name">
				<?php echo esc_html__('Data: ', 'themedev-ebay-advanced-search');?>
			</label>
			<?php
			$getLabel = isset($getLabelData2->model_name) ? $getLabelData2->model_name : '';
			?>
			<input class="regular-text code themedev-input-text "  type="text" id="ebay_label_data_name" name="themedevebay[model_name]" value="<?php echo esc_html($getLabel);?>">
		</div>
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<label for="ebay_label_id_list">
				 <?php echo esc_html__('Label:', 'themedev-ebay-advanced-search');?>
			</label>
			<?php
			$getlabel_id  = isset($getLabelData2->label_id) ? $getLabelData2->label_id : '';
			?>
			<select name="themedevebay[label_id]" class="regular-text code themeDev-select" id="ebay_label_id_list">
				<?php 
				if(is_array($outputDataLabel) AND sizeof($outputDataLabel) > 0):
					foreach($outputDataLabel AS $v):	
					?>
					<option value="<?php echo esc_html($v->label_id);?>" <?php echo ($getlabel_id === $v->label_id) ? 'selected' : ''?>> <?php echo esc_html($v->label_name) ;?> </option>
					<?php
					endforeach;
				endif;
				?>
			</select>
			
		</div>
		<div class="<?php echo esc_attr('themeDev-ebay-form');?>">
			<button type="submit" name="themedev-ebay-label-data-submit" class="themedev-ebay-submit"> <?php echo esc_html__('Save ', 'themedev-ebay-advanced-search');?></button>
		</div>
	</form>
</section>	
<section class="<?php echo esc_attr('themeDev-ebay-body');?>">
	<h2><?php echo esc_html__('Label Data', 'themedev-ebay-advanced-search');?></h2>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th style="width:20px;"> <strong> <?php echo esc_html__('SL.', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Data ', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Label ', 'themedev-ebay-advanced-search');?></strong></th>
				<th > <strong><?php echo esc_html__('Action', 'themedev-ebay-advanced-search');?></strong></th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		if(is_array($outputDataNewLabel) && sizeof($outputDataNewLabel) > 0):
			$m = 1;
			foreach($outputDataNewLabel as $v):
			?>
				<tr valign="middle"> 
					<td ><strong><?php echo $m; ?>. </strong></td>
					<td ><?php echo isset($v->model_name) ? esc_html( $v->model_name ) : ''; ?></td>
					<td ><?php echo isset($v->label_name) ? esc_html( $v->label_name ) : ''; ?></td>
					<td >
						<div class="row-actions" style="left: 0px;">
							<span><a href="<?php echo esc_url(admin_url().'admin.php?page=themedev-ebay-search-advanced&tab=label-data&dataid='.$v->model_id.'&type=edit');?>"><?php echo esc_html__('Edit', 'themedev-ebay-advanced-search');?></a> |</span>
							<span><a href="<?php echo esc_url(admin_url().'admin.php?page=themedev-ebay-search-advanced&tab=label-data&dataid='.$v->model_id.'&type=delete');?>"><?php echo esc_html__('Delete', 'themedev-ebay-advanced-search');?></a></span>
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