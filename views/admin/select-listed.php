<div class="next_mail_custom_post_type" >
	<div class="themeDev-form" style="">
        <?php if( $post_id > 0):?>
        <div class="setting-section" style=" ">
        <label class="inline-label" for="next_mail_listed_id">
				<?php echo esc_html__('Short-Code ', 'next-mailchimp');?>			
			</label>
            <div class="short-code-section" style="cursor: copy;" onclick="themedevmail_copy_link(this)" themedev-link='[next-mail form-id="<?php echo $post_id;?>" class="" btn-style="form1"]'>
                <pre style="cursor: copy;">[next-mail form-id="<?php echo ($post_id)?>" class="" btn-style="form1"]</pre>
            </div>
        </div>
        <?php endif;?>
		<div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_listed_id">
				<?php echo esc_html__('Select List Id ', 'next-mailchimp');?>			
			</label>    
            <select class="themedev-text-input inline-block" name="themedev_mail[listed_id]" id="next_mail_listed_id">
                <?php 
                if( is_array($listed) && sizeof($listed) > 0){
                    foreach( $listed as $v):
                ?>
                <option value="<?php echo $v['id'];?>" <?php echo ($v['id'] == $listed_id) ? 'selected' : '';?>> <?php echo esc_html__($v['name'], 'next-mailchimp');?> </option>
				<?php endforeach;
                }
                ?>
			</select>
        </div>

        <div class="setting-section" style=" ">
            <label class="block-label" for="next_mail_filed_option">
				<?php echo esc_html__('Custom Filed ', 'next-mailchimp');?>			
            </label>  
                <div class="next-providers">
                    <div class="next-social-block-wraper">
                        <ul class="next-social-block next-sharing ui-sortable" id="themedev-social-sortable" >  
                    <?php
                        
                        if(is_array($options_view) && sizeof($options_view) > 0){
                            foreach($options_view as $k=>$v):
                                $name = isset($options['provider'][$k]['label']) ? $options['provider'][$k]['label'] : ''; 
                                $nameText = !empty(trim($name)) ? $name : $core_option[$k];
                              ?>
                            <li class="ui-state-default">
                                <div class="next-single-social-block <?php echo $k;?>" title="<?php echo esc_html($nameText, 'next-mailchimp');?>">
                                   <div class="nextmail-header">
                                        <div class="next-block-header " >
                                            <h6 class="next_section-title <?php echo isset($options['provider'][$k]['enable']) ? 'enable-ser' : ''; ?> "><?php echo esc_html__($nameText, 'next-mailchimp');?></h6>
                                        </div>
                                        <div class="next-block-footer">
                                            <input onclick="nx_mail_ser_add(this);" nx-target=".nextmail-options__<?php echo $k ;?>" nx-target-common=".nextmail-options"  type="checkbox" name="themedev_mail[provider][<?php echo $k ;?>][enable]" <?php echo isset($options['provider'][$k]['enable']) ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-provider-<?php echo $k ;?>-enable"/>
                                            <label class="themedev-checkbox-switch" for="themedev-provider-<?php echo $k ;?>-enable">
                                                <span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="nextmail-options nextmail-options__<?php echo $k ;?> <?php echo isset($options['provider'][$k]['enable']) ? 'nx-show-target' : ''; ?> ">
                                         <div class="setting-section-option" style=" ">
                                            <label class="inline-label" for="next_mail_label_name__<?php echo $k;?>">
                                                <?php echo esc_html__('Label ', 'next-mailchimp');?>			
                                            </label>    
                                            
                                            <input class="themedev-text-input inline-block" name="themedev_mail[provider][<?php echo $k ;?>][label]" id="next_mail_label_name__<?php echo $k;?>" type="text" value="<?php echo isset($options['provider'][$k]['label']) ? $options['provider'][$k]['label'] : '';?>" >
                                        </div>
                                        <div class="setting-section-option" style=" ">
                                            <?php if($k == 'country'){
                                                $countrySelect = isset($options['provider'][$k]['placeholder']) ? $options['provider'][$k]['placeholder'] : '';

                                                ?>
                                                <label class="inline-label" for="next_mail_placeholder_name__<?php echo $k;?>">
                                                    <?php echo esc_html__('Default ', 'next-mailchimp');?>			
                                                </label>    
                                                <select class="themedev-text-input inline-block nextmail-select2-country" name="themedev_mail[provider][<?php echo $k ;?>][placeholder]" id="next_mail_placeholder_name__<?php echo $k;?>">
                                                <?php 
                                                    if( is_array($countryList) && sizeof($countryList) > 0){
                                                        foreach( $countryList as $k=>$v):
                                                            $nameCou = isset($v['info']['name']) ? $v['info']['name'] : '';
                                                    ?>
                                                    <option value="<?php echo $k;?>" <?php echo ($k == $countrySelect) ? 'selected' : '';?>> <?php echo esc_html__($nameCou, 'next-mailchimp');?> </option>
                                                    <?php endforeach;
                                                    }
                                                 ?>
                                                </select>
                                            <?php }else{?>
                                                <label class="inline-label" for="next_mail_placeholder_name__<?php echo $k;?>">
                                                    <?php echo esc_html__('Placeholder ', 'next-mailchimp');?>			
                                                </label>    
                                                <input class="themedev-text-input inline-block" name="themedev_mail[provider][<?php echo $k ;?>][placeholder]" id="next_mail_placeholder_name__<?php echo $k;?>" type="text" value="<?php echo isset($options['provider'][$k]['placeholder']) ? $options['provider'][$k]['placeholder'] : $core_option[$k];?>" >
                                            <?php }?>  
                                        </div>
                                        <div class="setting-section-option" style=" display: inline-block; ">
                                            <label class="inline-label" style="width: auto;" for="next_mail_require__<?php echo $k;?>">
                                                <?php echo esc_html__('Required ', 'next-mailchimp');?>			
                                            </label>    
                                            
                                            <input class="inline-block" name="themedev_mail[provider][<?php echo $k ;?>][require]" id="next_mail_require__<?php echo $k;?>" type="checkbox" value="Yes" <?php echo isset($options['provider'][$k]['require']) ? 'checked' : '';?> >
                                        </div>
                                    </div>
                                 </div>
                            </li>
                        <?php endforeach;
                            }
                        ?>
                     </ul>
                    </div>
                </div>
		</div>

        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_class_custom">
				<?php echo esc_html__('Custom Class ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[custom_class]" id="next_mail_class_custom" type="text" value="<?php echo isset($options['custom_class']) ? $options['custom_class'] : '';?>" >

        </div>
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_id_custom">
				<?php echo esc_html__('Custom Id ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[custom_id]" id="next_mail_id_custom" type="text" value="<?php echo isset($options['custom_id']) ? $options['custom_id'] : '';?>" >

        </div>
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_button_text">
				<?php echo esc_html__('Button Text ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[button_text]" id="next_mail_button_text" type="text" value="<?php echo isset($options['button_text']) ? $options['button_text'] : 'Subscribe';?>" >

        </div> 
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_icon">
				<?php echo esc_html__('Select Icon ', 'next-mailchimp');?>			
			</label>    
            <select class="themedev-text-input inline-block" name="themedev_mail[button_icon]" id="next_mail_icon">
                <option value=""><?php echo esc_html__('None ', 'next-mailchimp');?> </option>
                <?php 
                if( is_array($icons) && sizeof($icons) > 0){
                    foreach($icons as $k=>$v):
                ?>
                <option value="nx-subscribe <?php echo $k;?>" <?php echo ($k == $icon_id) ? 'selected' : '';?>> <?php echo esc_html__($v, 'next-mailchimp');?> </option>
				<?php endforeach;
                }
                ?>
			</select>
        </div> 
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_icon">
				<?php echo esc_html__('Icon Position ', 'next-mailchimp');?>			
			</label>    
            <select class="themedev-text-input inline-block" name="themedev_mail[button_position]" id="next_mail_icon">
                <option value="left"  <?php echo ('left' == $icon_position) ? 'selected' : '';?>><?php echo esc_html__('Left ', 'next-mailchimp');?> </option>
                <option value="right"  <?php echo ('right' == $icon_position) ? 'selected' : '';?>><?php echo esc_html__('Right ', 'next-mailchimp');?> </option>
                <option value="top"  <?php echo ('top' == $icon_position) ? 'selected' : '';?>><?php echo esc_html__('Top ', 'next-mailchimp');?> </option>
                <option value="bottom"  <?php echo ('bottom' == $icon_position) ? 'selected' : '';?>><?php echo esc_html__('Bottom ', 'next-mailchimp');?> </option>
                <option value="none"  <?php echo ('none' == $icon_position) ? 'selected' : '';?>><?php echo esc_html__('None ', 'next-mailchimp');?> </option>
			</select>
        </div>                      
	</div>
    <div class="themeDev-form" style="">
        <h3><?php echo esc_html__('Message Settings', 'next-mailchimp');?></h3>
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_success_send">
				<?php echo esc_html__('Suceess Send ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[success_send]" id="next_mail_success_send" type="text" value="<?php echo isset($options['success_send']) ? $options['success_send'] : 'Successfully mail listed';?>" >

        </div> 
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_already_send">
				<?php echo esc_html__('Already Send ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[already_send]" id="next_mail_already_send" type="text" value="<?php echo isset($options['already_send']) ? $options['already_send'] : 'Already mail listed';?>" >

        </div> 
        <div class="setting-section" style=" ">
            <label class="inline-label" for="next_mail_alert_send">
				<?php echo esc_html__('Alert Notofication ', 'next-mailchimp');?>			
			</label>    
            
            <input class="themedev-text-input inline-block" name="themedev_mail[alert_send]" id="next_mail_alert_send" type="text" value="<?php echo isset($options['alert_send']) ? $options['alert_send'] : 'Please fill up all information?';?>" >

        </div>   
    </div>
    <div class="themeDev-form" style="">
        <h3><?php echo esc_html__('Display Form', 'next-mailchimp');?></h3>
        <div class="disply-login-div">
            <h4><?php echo esc_html__('Choose Form Style', 'next-mailchimp');?></h4>
            
            <?php if(is_array($buttonstyle)){
                foreach($buttonstyle as $k=>$v){
                    $proclass = 'style-counter-pro';
                ?>
                <div class="<?php echo esc_attr('themeDev-form');?> style-sec-next <?php echo ($button_style == $k ) ? 'style-active' : ''; ?>">
                    <?php if( in_array($k, ['form1', 'form2', 'form3', 'form4', 'form5', 'form6', 'form7', 'form8']) ):
                        $proclass = '';
                        ?>
                        <input type="radio" name="themedev_mail[button_style]" <?php echo ($button_style == $k ) ? 'checked' : ''; ?> class="hidden-checkbox" value="<?php echo esc_html($k);?>" id="themedev-style-<?php echo esc_html($k);?>"/>
                    <?php endif;?>
                    <label class="next-display-label <?php echo esc_attr($proclass);?>" for="themedev-style-<?php echo esc_html($k);?>">
                        <span><?php echo esc_html($v['text']);?></span>
                        <figure class="image-figure">
                            <img src="<?php echo esc_url( NEXT_MAIL_PLUGIN_URL.'assets/images/styles/'.esc_html($k).'.png' ); ?>" alt="<?php echo esc_html($k);?>">
                        </figure>
                    </label>
                </div>
                
            <?php }
            }
            ?>
        </div>
    </div>
 </div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
        $( "#themedev-social-sortable" ).sortable();
	    $( "#themedev-social-sortable" ).disableSelection();
		$('.nextmail-select2-country').select2();
	});
</script>