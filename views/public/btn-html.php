<div id="<?php echo  esc_attr($this->id_name );?>" class="next-mail-section next-<?php echo esc_attr($this->btn_style );?> <?php echo esc_attr($this->class_name );?> <?php echo esc_attr($this->content_position );?>" >
    <form method="post" class="next-mail-form next-form-<?php echo $post_id;?> " id="next-from-id-<?php echo $post_id;?>">
        <div class="next-mail-message"></div>
        <div class="next-inner-from">
            
            <?php
            if(is_array($custom_filed) && sizeof($custom_filed) > 0){
                foreach($custom_filed as $k=>$v):

                    if( isset($custom_filed[$k]['enable']) ){
                        $name = isset($custom_filed[$k]['label']) ? $custom_filed[$k]['label'] : ''; 
                        $placeholder = isset($custom_filed[$k]['placeholder']) ? $custom_filed[$k]['placeholder'] : ''; 
                        $require = isset($custom_filed[$k]['require']) ? 'required' : ''; 
                        $type = 'text';
                        if( $k == 'email'){
                            $type = 'email';
                        }                 
                ?>
                    <div class="next-mail-filed next-input next-<?php echo esc_attr($k);?> <?php echo ($require == 'required') ? 'next-required' : '';?>">
                        <?php if( !empty(trim($name)) ):?><label class="next-mail-label next-<?php echo esc_attr($k);?>" for="next-mail-<?php echo esc_attr($k);?>"> <?php echo __($name, 'next-mailchimp');?></label><?php endif;?>
                        <?php if($k == 'country'){?>
                            <select id="next-mail-<?php echo esc_attr($k);?>" class="next-input-filed next-filed-<?php echo esc_attr($k);?> nextmail-select2-country" name="nextmail[<?php echo esc_attr($k);?>]" <?php echo $require;?>>
                                <?php 
                                    if( is_array($countryList) && sizeof($countryList) > 0){
                                        foreach( $countryList as $k=>$v):
                                            $nameCou = isset($v['info']['name']) ? $v['info']['name'] : '';
                                    ?>
                                    <option value="<?php echo $k;?>" <?php echo ($k == $placeholder) ? 'selected' : '';?> > <?php echo esc_html__($nameCou, 'next-mailchimp');?> </option>
                                    <?php endforeach;
                                    }
                                    ?>
                                </select>
                        <?php }else{?> 
                            <input id="next-mail-<?php echo esc_attr($k);?>" class="next-input-filed next-filed-<?php echo esc_attr($k);?>" type="<?php echo $type;?>" name="nextmail[<?php echo esc_attr($k);?>]" placeholder="<?php echo esc_attr($placeholder);?>" <?php echo $require;?>>
                        <?php }?>
                    </div>
                <?php 
                    }
                endforeach;
            }
            ?>       
            <div class="next-mail-filed next-submit">
                <button class="next-mail-button " name="next-mail-send" type="submit">
                    <?php if( $this->icon_position == 'left' || $this->icon_position == 'top'):?>
                        <i class="<?php echo esc_attr($this->icon );?>"></i>
                    <?php endif;?>
                    <?php if( !empty(trim($this->btn_text)) ):?>
                        <span class="next-btn-text"><?php echo __($this->btn_text, 'next-mailchimp');?></span>
                    <?php endif;?>
                    <?php if( $this->icon_position == 'right' || $this->icon_position == 'bottom'):?>
                        <i class="<?php echo esc_attr($this->icon );?>"></i>
                    <?php endif;?>
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery('.nextmail-select2-country').select2();
	});
</script>