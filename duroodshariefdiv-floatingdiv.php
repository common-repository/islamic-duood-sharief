<?php 
/**
 * Plugin Name: Islamic Durood Sharief
 * Plugin URI: https://todaymsg.com/durood-sharief-floating-div.zip
 * Description: Now you can show durood sharief FD(Floating Durood Sharief Content) image,text or video on your website. Let people read durood sharief and your will get reward from ALLAH.
 * Version: 1.0
 * Author URI: https://todaymsg.com/
 * License: GPL2
 */


 add_action( 'wp_enqueue_scripts', 'duroodshariefdiv_add_script' );

function duroodshariefdiv_add_script() {
	wp_enqueue_style( 'duroodshariefdiv_css', plugins_url('css/duroodshariefdiv.css', __FILE__));
	wp_enqueue_script('jquery');	
	wp_enqueue_script('jquery-effects-fold');
	wp_enqueue_script('jquery-effects-slide');
	wp_enqueue_script('jquery-effects-fade');
	wp_enqueue_script('jquery-effects-explode');
	wp_enqueue_script('jquery-effects-clip');
}

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', 'duroodshariefdiv_add_admin_style' );
function duroodshariefdiv_add_admin_style() {
	wp_enqueue_style( 'duroodshariefdiv_admin_css', plugins_url('css/duroodshariefdiv_admin.css', __FILE__));
	wp_enqueue_script('jquery-effects-pulsate');
}

function duroodshariefdiv_create_type() {
  register_post_type( 'durood_sharief_fd',
    array(
      'labels' => array(
        'name' => 'Durood Sharief FD',
        'singular_name' => 'Durood Sharief FD'
      ),
      'public' => true,
      'has_archive' => false,
      'hierarchical' => false,
      'supports'           => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

add_action( 'init', 'duroodshariefdiv_create_type' );



function duroodshariefdiv_admin_css() {
    global $post_type;
    $post_types = array( 
                        'durood_sharief_fd',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#edit-slug-box, #post-preview, #view-post-btn{display: none;}</style>';
}

function duroodshariefdiv_remove_view_link( $action ) {

    unset ($action['view']);
    return $action;
}

add_filter( 'post_row_actions', 'duroodshariefdiv_remove_view_link' );
add_action( 'admin_head-post-new.php', 'duroodshariefdiv_admin_css' );
add_action( 'admin_head-post.php', 'duroodshariefdiv_admin_css' );

function duroodshariefdiv_check($cible,$test){
  if($test == $cible){return ' checked="checked" ';}
}

add_action('add_meta_boxes','duroodshariefdiv_init_settings_metabox');

function duroodshariefdiv_init_settings_metabox(){
  add_meta_box('duroodshariefdiv_settings_metabox', 'Settings', 'duroodshariefdiv_add_settings_metabox', 'durood_sharief_fd', 'side', 'high');
}

function duroodshariefdiv_add_settings_metabox($post){
	
	$prefix = '_floating_div_';
	
	$width = get_post_meta($post->ID, $prefix.'width',true);
	if($width == '')
		$width = "260px";

	$all_pages  = get_post_meta($post->ID, $prefix.'all_pages',true);		
	?>
	<table class="duroodshariefdiv_table_settings">
		<tr class="duroodshariefdiv_pro_features">
			<td colspan="2"><label for="collapsible">Do you want a collapsible content ? </label>
				<select name="collapsible" class="duroodshariefdiv_select_100" disabled >
					<option value="no">No</option>
					<option value="yes">Yes</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><label for="width">Width of content : </label>
				<select name="width" class="duroodshariefdiv_select_100">
					<option <?php selected( $width, "160px"); ?> value="160px">Tiny</option>
					<option <?php selected( $width, "210px");  ?> value="210px">Small</option>
					<option <?php selected( $width, "260px"); ?> value="260px">Medium</option>
					<option <?php selected( $width, "310px");  ?> value="310px">Large</option>
					<option <?php selected( $width, "360px");  ?> value="360px">Huge</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="all_pages">Show on all pages : </label></td>
			<td><input type="radio" id="all_pages_yes" name="all_pages" value="yes" <?php echo (empty($all_pages)) ? '' : duroodshariefdiv_check($all_pages,'yes'); ?>> Yes <input type="radio" id="all_pages_no" name="all_pages" value="no" <?php echo (empty($all_pages)) ? 'checked="checked"' : duroodshariefdiv_check($all_pages,'no'); ?>> No<br></td>
		</tr>
		<tr class="duroodshariefdiv_pro_features">
			<td><label for="force_font">Force original font : </label></td>
			<td><input type="radio" name="force_font" value="yes" disabled> Yes <input type="radio" name="force_font" value="no" disabled > No<br></td>
		</tr>
		<tr class="duroodshariefdiv_pro_features">
			<td><label for="">Device Restriction : </label></td>
			<td>
				<input type="checkbox" name="device_restrict_no_mobile" value="duroodshariefdiv_no_mobile" disabled /> Hide on Mobile 
				<br /><input type="checkbox" name="device_restrict_no_tablet" value="duroodshariefdiv_no_tablet" disabled /> Hide on Tablet
				<br /><input type="checkbox" name="device_restrict_no_desktop" value="duroodshariefdiv_no_desktop" disabled /> Hide on Desktop
			</td>
		</tr>
		<tr class="duroodshariefdiv_pro_features">
			<td colspan="2"><label for="user_restrict">User Restriction : </label>
				<select name="user_restrict" class="duroodshariefdiv_select_100" disabled>
					<option value="all">All</option>
					<option value="logged_in">Logged In</option>
					<option value="guest">Guest</option>
				</select>
			</td>
		</tr>
	</table>	
	<?php 
	
}

add_action('add_meta_boxes','duroodshariefdiv_init_advert_metabox');

function duroodshariefdiv_init_advert_metabox(){
  add_meta_box('duroodshariefdiv_advert_metabox', 'Working Instruction', 'duroodshariefdiv_add_advert_metabox', 'durood_sharief_fd', 'side', 'low');
}

function duroodshariefdiv_add_advert_metabox($post){	
	?>
	
	<ul style="list-style-type:disc;padding-left:20px;margin-bottom:25px;">
		<li>Insert Darood Sharief Image or Text</li>
        <li>Publish 1 Darood Sharief at once</li>
        <li>You can use duroos sharief data image text or video in your content area, copy from there or insert your own durood</li>
        

	</ul>
	

	
	<script type="text/javascript">
		$=jQuery.noConflict();
		jQuery(document).ready( function($) {
			$('input[name=pro_features]').live('change', function(){
				if($('#pro_features_yes').is(':checked')) {
					$('.duroodshariefdiv_pro_features').show("pulsate", {times:2}, 2000);
				} 
				if($('#pro_features_no').is(':checked')) {
					$('.duroodshariefdiv_pro_features').hide("pulsate", {times:2}, 2000);
				} 
			});
		});
	</script>
	
	<?php 
	
}

add_action('add_meta_boxes','duroodshariefdiv_init_content_metabox');

function duroodshariefdiv_init_content_metabox(){
  add_meta_box('duroodshariefdiv_content_metabox', 'Insert Durood Sharief Text, Image or video', 'duroodshariefdiv_add_content_metabox', 'durood_sharief_fd', 'normal');
}

function duroodshariefdiv_add_content_metabox($post){
	$prefix = '_floating_div_';

	$content = get_post_meta($post->ID, $prefix.'content',true);
	$position = get_post_meta($post->ID, $prefix.'position',true);
	$margin_top = get_post_meta($post->ID, $prefix.'margin_top',true);
	$margin_bottom = get_post_meta($post->ID, $prefix.'margin_bottom',true);
	$margin_right = get_post_meta($post->ID, $prefix.'margin_right',true);
	$margin_left = get_post_meta($post->ID, $prefix.'margin_left',true);
	$borders = get_post_meta($post->ID, $prefix.'borders',true);	
	$border_color = get_post_meta($post->ID, $prefix.'border_color',true);	
	$corners = get_post_meta($post->ID, $prefix.'corners',true);
	$background = get_post_meta($post->ID, $prefix.'background',true);
	$background_color = get_post_meta($post->ID, $prefix.'background_color',true);
	$image = get_post_meta($post->ID, $prefix.'image',true);
	
	$settings = array( 'textarea_name' => 'content' );	
	wp_editor( htmlspecialchars_decode($content), 'duroodshariefdiv_content', $settings);
	
	?>
	
	<h2 class="duroodshariefdiv_admin_title">Position</h2>
	
		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="position">Choose your floating div position : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">	
					<select name="position" class="duroodshariefdiv_select_125p">
						<option <?php selected( $position, "bottom_right");  ?> id="duroodshariefdiv_position_bottom_right" value="bottom_right">Bottom Right</option>
						<option <?php selected( $position, "top_right"); ?> id="duroodshariefdiv_position_top_right" value="top_right">Top Right</option>
						<option <?php selected( $position, "top");  ?> id="duroodshariefdiv_position_top" value="top">Top</option>
						<option <?php selected( $position, "top_left"); ?> id="duroodshariefdiv_position_top_left" value="top_left">Top Left</option>
						<option <?php selected( $position, "bottom");  ?> id="duroodshariefdiv_position_bottom" value="bottom">Bottom</option>
						<option <?php selected( $position, "bottom_left");  ?> id="duroodshariefdiv_position_bottom_left" value="bottom_left">Bottom Left</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_top">
						<label for="margin_top" class="duroodshariefdiv_label_margins" >Specify a margin Top : </label>
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_bottom">
						<label for="margin_bottom" class="duroodshariefdiv_label_margins" >Specify a margin Bottom : </label>
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_right">
						<label for="margin_right" class="duroodshariefdiv_label_margins" >Specify a margin Right : </label>
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_left">
						<label for="margin_left" class="duroodshariefdiv_label_margins" >Specify a margin Left : </label>
					</div>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_top">
						<input type="text" id="duroodshariefdiv_margin_top" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="margin_top" value="<?php echo $margin_top; ?>" /> px
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_bottom">
						<input type="text" id="duroodshariefdiv_margin_bottom" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="margin_bottom" value="<?php echo $margin_bottom; ?>" /> px
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_right">
						<input type="text" id="duroodshariefdiv_margin_right" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="margin_right" value="<?php echo $margin_right; ?>" /> px
					</div>
					<div class="duroodshariefdiv_div_margins duroodshariefdiv_div_margin_left">
						<input type="text" id="duroodshariefdiv_margin_left" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="margin_left" value="<?php echo $margin_left; ?>" /> px
					</div>
				</td>
				<td>
				</td>
			</tr>
		</table>
	<h2 class="duroodshariefdiv_admin_title">Style</h2>
		

		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="corners">Do you want rounded corners ? </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<input type="radio" id="corners_yes" name="corners" class="duroodshariefdiv_radio_pright" value="25px" <?php echo (empty($corners)) ? '' : duroodshariefdiv_check($corners,'25px'); ?>> Yes 
					<input type="radio" id="corners_no" name="corners" class="duroodshariefdiv_radio_pright duroodshariefdiv_radio_pleft" value="2px" <?php echo (empty($corners)) ? 'checked="checked"' : duroodshariefdiv_check($corners,'2px'); ?>> No	
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="borders">Do you want a border ? </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<input type="radio" id="duroodshariefdiv_borders_yes" name="borders" class="duroodshariefdiv_radio_pright" value="yes" <?php echo (empty($borders)) ? 'checked="checked"' : duroodshariefdiv_check($borders,'yes'); ?>> Yes 
					<input type="radio" id="duroodshariefdiv_borders_no" name="borders" class="duroodshariefdiv_radio_pright duroodshariefdiv_radio_pleft" value="no" <?php echo (empty($borders)) ? '' : duroodshariefdiv_check($borders,'no'); ?>> No
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<div class="duroodshariefdiv_border_color">
						<label for="border_color" class="duroodshariefdiv_label_colorpicker" >Choose your Border Color : </label>
					</div>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<div class="duroodshariefdiv_border_color">
						<input id="border_color" name="border_color" type="text" value="<?php echo (empty($border_color)) ? '#000000' : $border_color; ?>" class="duroodshariefdiv_colorpicker" />
					</div>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="duroodshariefdiv_table_100_label" >
					<label for="background">Choose your background type : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<select name="background" class="duroodshariefdiv_select_125p">
						<option <?php selected( $background, "color"); ?> id="duroodshariefdiv_background_color" value="color">Color</option>
						<option <?php selected( $background, "image");  ?> id="duroodshariefdiv_background_image" value="image">Image</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<div class="duroodshariefdiv_div_background_color">
						<label for="background_color" class="duroodshariefdiv_label_colorpicker">Choose your Background Color : </label>
					</div>					
					<div class="duroodshariefdiv_div_background_image">
						<label for="image" class="duroodshariefdiv_back_image">Choose your Background Image : </label>
					</div>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<div class="duroodshariefdiv_div_background_color">
						<input id="background_color" name="background_color" type="text" value="<?php echo (empty($background_color)) ? '#FFFFFF' : $background_color; ?>" class="duroodshariefdiv_colorpicker" />
					</div>					
					<div class="duroodshariefdiv_div_background_image">
						<input type="text" name="image" id="duroodshariefdiv_media_background_image" value="<?php echo $image; ?>" />
						<input type="button" class="button background-image-button" value="Choose an image" />
					</div>
				</td>
				<td>
				</td>
			</tr>
         
            
		</table>
        
        
        	<h2 class="duroodshariefdiv_admin_title">Durood Sharief Data (You can copy Durood Image Url and Use in Content )</h2>
		

		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="corners">Durood 1 Image </label>
				</td>
        		<td class="duroodshariefdiv_table_100_input">
<a href="https://imgur.com/ISUmajK"><img src="https://i.imgur.com/ISUmajK.jpg" style="width:100px;" title="source: imgur.com" /></a>
<a href="https://imgur.com/tJuAQPx"><img src="https://i.imgur.com/tJuAQPx.gif" style="width:100px;" title="source: imgur.com" /></a>
<a href="https://imgur.com/QjYzUob"><img src="https://i.imgur.com/QjYzUob.jpg" style="width:100px;" title="source: imgur.com" /></a>
<a href="https://imgur.com/neKM1am"><img src="https://i.imgur.com/neKM1am.jpg" style="width:100px;" title="source: imgur.com" /></a>
<a href="https://imgur.com/eFvL55B"><img src="https://i.imgur.com/eFvL55B.jpg" style="width:100px;" title="source: imgur.com" /></a>
<a href="https://imgur.com/cqm5NnB"><img src="https://i.imgur.com/cqm5NnB.png" style="width:100px;" title="source: imgur.com" /></a>
<br />
Or Add Video  1
<br />

https://www.youtube.com/watch?v=yY7j5Zszlsk&t=4s
<br />
Or Add Video  2
<br />
https://www.youtube.com/watch?v=_B1GMBOyNfQ
<br /><br />

Or Add Text 1
<br />

اللَّهُـمّ صَــــــلٌ علَےَ مُحمَّــــــــدْ و علَےَ آل مُحمَّــــــــدْ كما صَــــــلٌيت علَےَ إِبْرَاهِيمَ و علَےَ آل إِبْرَاهِيمَ إِنَّك حَمِيدٌ مَجِيدٌ♥
اللهم بارك علَےَ مُحمَّــــــــدْ و علَےَ آل مُحمَّــــــــدْ كما باركت علَےَ إِبْرَاهِيمَ و علَےَ آل إِبْرَاهِيمَ إِنَّك حَمِيدٌ مَجِيدٌ♥

<br />
<br />
Or Add Text 2
<br />
اللَّهُمَّ صَلِّ عَلَى مُحَمَّدٍ وَعَلَى آلِ مُحَمَّدٍ
كَمَا صَلَّيْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ
.إِنَّكَ حَمِيدٌ مَجِيدٌ
اللَّهُمَّ بَارِكْ عَلَى مُحَمَّدٍ، وَعَلَى آلِ مُحَمَّدٍ
كَمَا بَارَكْتَ عَلَى إِبْرَاهِيمَ وَعَلَى آلِ إِبْرَاهِيمَ
.إِنَّكَ حَمِيدٌ مَجِيدٌ

				</td>
        </tr>

			


	
        


        
       </table>
        
        	
		
	<div id="duroodshariefdiv_collapsible_settings" class="duroodshariefdiv_pro_features">
		<h2 class="duroodshariefdiv_admin_title">Collapsible Effect</h2>
	
		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="speed">Choose your effect speed : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<select name="speed" class="duroodshariefdiv_select_125p" disabled>
						<option value="1">Instant</option>
						<option value="300">Fast</option>
						<option value="600">Medium</option>
						<option value="900">Slow</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<label for="position_start">In which position your collapsible element should start ? </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<input type="radio" name="position_start" value="collapsed" disabled> Collapsed 
					<input type="radio" name="position_start" value="expanded" disabled> Expanded
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="button_image" >Button Image to <strong>expand</strong> your content : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<input type="text" name="button_image" id="duroodshariefdiv_media_button_image" value="" disabled />
					<input type="button" class="button button-image-button" value="Choose an image" disabled />
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<label for="button_image_collapse" >Button Image to <strong>collapse</strong> your content : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<input type="text" name="button_image_collapse" id="duroodshariefdiv_media_button_image_collapse" value="" disabled />
					<input type="button" class="button button-image-collapse-button" value="Choose an image" disabled />
				</td>
				<td>
				</td>
			</tr>
		</table>	
	</div>
	
	<div id="duroodshariefdiv_stop_on_scroll" class="duroodshariefdiv_pro_features">
		<h2 class="duroodshariefdiv_admin_title">Stop Scrolling</h2>
	
		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="stop_scroll">Stop Scrolling at a certain point : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<select name="stop_scroll" class="duroodshariefdiv_select_125p" disabled >
						<option id="duroodshariefdiv_stop_scroll_yes" value="yes">Enable</option>
						<option id="duroodshariefdiv_stop_scroll_no" value="no">Disable</option>						
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label duroodshariefdiv_if_stop_scroll">
					<label for="stop_scroll_distance">How far would the user have to scroll ? </label>
				</td>
				<td class=" duroodshariefdiv_table_100_input duroodshariefdiv_if_stop_scroll">
					<input type="text" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="stop_scroll_distance" value="" disabled /> px
				</td>
				<td>
				</td>
			</tr>
		</table>	
	</div>
	
	<div id="duroodshariefdiv_appearing_settings" class="duroodshariefdiv_pro_features">
		<h2 class="duroodshariefdiv_admin_title">Appearing Effect</h2>
	
		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="appearing_active">Do you want an Appearing Effect : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<select name="appearing_active" class="duroodshariefdiv_select_125p" disabled>
						<option id="duroodshariefdiv_appearing_active_yes" value="yes">Enable</option>
						<option id="duroodshariefdiv_appearing_active_no" value="no">Disable</option>						
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<div class="duroodshariefdiv_if_appearing_active">
						<label for="appear_cond_time">How long before revealing the content ? </label>
					</div>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<div class="duroodshariefdiv_if_appearing_active">
						<input type="text" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="appear_cond_time" value="" disabled /> ms
					</div>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="duroodshariefdiv_table_100_label duroodshariefdiv_if_appearing_active">
					<label for="appearing_effect">Choose your Appearing Effect : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input duroodshariefdiv_if_appearing_active">
					<select name="appearing_effect" class="duroodshariefdiv_select_125p" disabled >
						<option class="duroodshariefdiv_appear_slide_or_clip_no" value="fade">Fade In</option>
						<option class="duroodshariefdiv_appear_slide_or_clip_yes" id="duroodshariefdiv_appear_slide_effect" value="slide">Slide In</option>
						<option class="duroodshariefdiv_appear_slide_or_clip_no" value="fold">Unfold</option>
						<option class="duroodshariefdiv_appear_slide_or_clip_no" value="explode">Assemble</option>
						<option class="duroodshariefdiv_appear_slide_or_clip_yes" id="duroodshariefdiv_appear_clip_effect"value="clip">Clip In</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label duroodshariefdiv_appear_slide_or_clip">
					<label for="appear_slide_direction">Choose the effect direction : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input duroodshariefdiv_appear_slide_or_clip">
					<div id="duroodshariefdiv_appear_slide_direction_div">
						<select name="appear_slide_direction" class="duroodshariefdiv_select_125p" disabled >
							<option value="up">Up</option>
							<option value="down">Down</option>
							<option value="left">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
				</td>
				<td>
				</td>
			</tr>
		</table>	
	</div>
	
	<div id="duroodshariefdiv_disappearing_settings" class="duroodshariefdiv_pro_features">
		<h2 class="duroodshariefdiv_admin_title">Disappearing Effect</h2>
	
		<table class="duroodshariefdiv_table_100">
			<tr>
				<td class="duroodshariefdiv_table_100_label">
					<label for="disappearing_active">Do you want a Disappearing Effect : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input">
					<select name="disappearing_active" class="duroodshariefdiv_select_125p" disabled >
						<option id="duroodshariefdiv_disappearing_active_yes" value="yes">Enable</option>
						<option id="duroodshariefdiv_disappearing_active_no" value="no">Disable</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label">
					<div class="duroodshariefdiv_if_disappearing_active">
						<label for="disappear_cond_time">How long before hiding the content ? </label>
					</div>
				</td>	
				<td class="duroodshariefdiv_table_100_input">
					<div class="duroodshariefdiv_if_disappearing_active">
						<input type="text" class="duroodshariefdiv_input_align_right duroodshariefdiv_input_small_width" name="disappear_cond_time" value="" disabled /> ms
					</div>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="duroodshariefdiv_table_100_label duroodshariefdiv_if_disappearing_active">
					<label for="disappearing_effect">Choose your Disappearing Effect : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input duroodshariefdiv_if_disappearing_active">
					<select name="disappearing_effect" class="duroodshariefdiv_select_125p" disabled >
						<option class="duroodshariefdiv_disappear_slide_or_clip_no" value="fade">Fade Out</option>
						<option class="duroodshariefdiv_disappear_slide_or_clip_yes" id="duroodshariefdiv_disappear_slide_effect" value="slide">Slide Out</option>
						<option class="duroodshariefdiv_disappear_slide_or_clip_no" value="fold">Fold</option>
						<option class="duroodshariefdiv_disappear_slide_or_clip_no" value="explode">Explode</option>
						<option class="duroodshariefdiv_disappear_slide_or_clip_yes" id="duroodshariefdiv_disappear_clip_effect" value="clip">Clip Out</option>
					</select>
				</td>
				<td class="duroodshariefdiv_table_100_label duroodshariefdiv_disappear_slide_or_clip">
					<label for="disappear_slide_direction">Choose the effect direction : </label>
				</td>
				<td class="duroodshariefdiv_table_100_input duroodshariefdiv_disappear_slide_or_clip">
					<div id="duroodshariefdiv_disappear_slide_direction_div" >
						<select name="disappear_slide_direction" class="duroodshariefdiv_select_125p" disabled>
							<option value="down">Down</option>
							<option value="left">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
				</td>
				<td>
				</td>				
			</tr>
		</table>	
	</div>
	
	<script type="text/javascript">
		$=jQuery.noConflict();
		jQuery(document).ready( function($) {
			
			if($('#duroodshariefdiv_position_top_right').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').show();
				$('.duroodshariefdiv_div_margin_bottom').hide();
				$('.duroodshariefdiv_div_margin_right').show();
				$('.duroodshariefdiv_div_margin_left').hide();
			} 
			if($('#duroodshariefdiv_position_top').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').show();
				$('.duroodshariefdiv_div_margin_bottom').hide();
				$('.duroodshariefdiv_div_margin_right').hide();
				$('.duroodshariefdiv_div_margin_left').hide();
			} 
			if($('#duroodshariefdiv_position_top_left').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').show();
				$('.duroodshariefdiv_div_margin_bottom').hide();
				$('.duroodshariefdiv_div_margin_right').hide();
				$('.duroodshariefdiv_div_margin_left').show();
			} 
			if($('#duroodshariefdiv_position_bottom_right').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').hide();
				$('.duroodshariefdiv_div_margin_bottom').show();
				$('.duroodshariefdiv_div_margin_right').show();
				$('.duroodshariefdiv_div_margin_left').hide();
			} 
			if($('#duroodshariefdiv_position_bottom').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').hide();
				$('.duroodshariefdiv_div_margin_bottom').show();
				$('.duroodshariefdiv_div_margin_right').hide();
				$('.duroodshariefdiv_div_margin_left').hide();
			} 
			if($('#duroodshariefdiv_position_bottom_left').is(':selected')) {
				$('.duroodshariefdiv_div_margin_top').hide();
				$('.duroodshariefdiv_div_margin_bottom').show();
				$('.duroodshariefdiv_div_margin_right').hide();
				$('.duroodshariefdiv_div_margin_left').show();
			} 
			
			$('select[name=position]').live('change', function(){
				if($('#duroodshariefdiv_position_top_right').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').show();
					$('.duroodshariefdiv_div_margin_bottom').hide();
					$('.duroodshariefdiv_div_margin_right').show();
					$('.duroodshariefdiv_div_margin_left').hide();
				} 
				if($('#duroodshariefdiv_position_top').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').show();
					$('.duroodshariefdiv_div_margin_bottom').hide();
					$('.duroodshariefdiv_div_margin_right').hide();
					$('.duroodshariefdiv_div_margin_left').hide();
				} 
				if($('#duroodshariefdiv_position_top_left').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').show();
					$('.duroodshariefdiv_div_margin_bottom').hide();
					$('.duroodshariefdiv_div_margin_right').hide();
					$('.duroodshariefdiv_div_margin_left').show();
				} 
				if($('#duroodshariefdiv_position_bottom_right').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').hide();
					$('.duroodshariefdiv_div_margin_bottom').show();
					$('.duroodshariefdiv_div_margin_right').show();
					$('.duroodshariefdiv_div_margin_left').hide();
				} 
				if($('#duroodshariefdiv_position_bottom').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').hide();
					$('.duroodshariefdiv_div_margin_bottom').show();
					$('.duroodshariefdiv_div_margin_right').hide();
					$('.duroodshariefdiv_div_margin_left').hide();
				} 
				if($('#duroodshariefdiv_position_bottom_left').is(':selected')) {
					$('.duroodshariefdiv_div_margin_top').hide();
					$('.duroodshariefdiv_div_margin_bottom').show();
					$('.duroodshariefdiv_div_margin_right').hide();
					$('.duroodshariefdiv_div_margin_left').show();
				} 
			});						
			
			if($('#duroodshariefdiv_background_color').is(':selected')) {
				$('.duroodshariefdiv_div_background_color').show();
				$('.duroodshariefdiv_div_background_image').hide();
			} 
			if($('#duroodshariefdiv_background_image').is(':selected')) {
				$('.duroodshariefdiv_div_background_color').hide();
				$('.duroodshariefdiv_div_background_image').show();
			} 
			
			$('select[name=background]').live('change', function(){
				if($('#duroodshariefdiv_background_color').is(':selected')) {
					$('.duroodshariefdiv_div_background_color').show();
					$('.duroodshariefdiv_div_background_image').hide();
				} 
				if($('#duroodshariefdiv_background_image').is(':selected')) {
					$('.duroodshariefdiv_div_background_color').hide();
					$('.duroodshariefdiv_div_background_image').show();
				} 
			});
			
			if($('#duroodshariefdiv_borders_yes').is(':checked')) {
				$('.duroodshariefdiv_border_color').show();
			} 
			if($('#duroodshariefdiv_borders_no').is(':checked')) {
				$('.duroodshariefdiv_border_color').hide();
			} 
			
			$('input[name=borders]').live('change', function(){
				if($('#duroodshariefdiv_borders_yes').is(':checked')) {
					$('.duroodshariefdiv_border_color').show();
				} 
				if($('#duroodshariefdiv_borders_no').is(':checked')) {
					$('.duroodshariefdiv_border_color').hide();
				} 
			});
		});
	</script>
	
	<?php


}

function duroodshariefdiv_colorpicker_enqueue() {
    global $typenow;
    if( $typenow == 'durood_sharief_fd' ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'duroodshariefdiv_colorpicker', plugin_dir_url( __FILE__ ) . 'js/duroodshariefdiv_colorpicker.js', array( 'wp-color-picker' ) );
    }
}
add_action( 'admin_enqueue_scripts', 'duroodshariefdiv_colorpicker_enqueue' );	

add_action( 'admin_enqueue_scripts', 'duroodshariefdiv_image_file_enqueue' );
function duroodshariefdiv_image_file_enqueue() {
	global $typenow;
	if( $typenow == 'durood_sharief_fd' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'duroodshariefdiv_media_cover-js', plugin_dir_url( __FILE__ ) . 'js/duroodshariefdiv_media_cover.js', array( 'jquery' ) );
		wp_localize_script( 'duroodshariefdiv_media_cover-js', 'duroodshariefdiv_media_cover_js',
			array(
				'title' => __( 'Choose or Upload an image'),
				'button' => __( 'Use this file'),
			)
		);
		wp_enqueue_script( 'duroodshariefdiv_media_cover-js' );
	}
}





add_action('save_post','duroodshariefdiv_save_metabox');
function duroodshariefdiv_save_metabox($post_id){
	
	$prefix = '_floating_div_';
	
	//Metabox Settings
	if(isset($_POST['width'])){
		update_post_meta($post_id, $prefix.'width', sanitize_text_field($_POST['width']));
	}
	if(isset($_POST['all_pages'])){
		update_post_meta($post_id, $prefix.'all_pages', sanitize_text_field($_POST['all_pages']));
	}

	if(isset($_POST['content'])){
		update_post_meta($post_id, $prefix.'content', $_POST['content']);
	}	
	if(isset($_POST['position'])){
		update_post_meta($post_id, $prefix.'position', sanitize_text_field($_POST['position']));
	}	
	if(isset($_POST['margin_top'])){
		update_post_meta($post_id, $prefix.'margin_top', sanitize_text_field($_POST['margin_top']));
	}
	if(isset($_POST['margin_bottom'])){
		update_post_meta($post_id, $prefix.'margin_bottom', sanitize_text_field($_POST['margin_bottom']));
	}
	if(isset($_POST['margin_left'])){
		update_post_meta($post_id, $prefix.'margin_left', sanitize_text_field($_POST['margin_left']));
	}
	if(isset($_POST['margin_right'])){
		update_post_meta($post_id, $prefix.'margin_right', sanitize_text_field($_POST['margin_right']));
	}
	if(isset($_POST['corners'])){
		update_post_meta($post_id, $prefix.'corners', sanitize_text_field($_POST['corners']));
	}
	if(isset($_POST['borders'])){
		update_post_meta($post_id, $prefix.'borders', sanitize_text_field($_POST['borders']));
	}
	if(isset($_POST['border_color'])){
		update_post_meta($post_id, $prefix.'border_color', sanitize_text_field($_POST['border_color']));
	}
	if(isset($_POST['background'])){
		update_post_meta($post_id, $prefix.'background', sanitize_text_field($_POST['background']));
	}
	if(isset($_POST['background_color'])){
		update_post_meta($post_id, $prefix.'background_color', sanitize_text_field($_POST['background_color']));
	}
	if(isset($_POST['image'])){
		update_post_meta($post_id, $prefix.'image', sanitize_text_field($_POST['image']));
	}
}

add_action( 'manage_durood_sharief_fd_posts_custom_column' , 'duroodshariefdiv_custom_columns_pro', 10, 2 );

function duroodshariefdiv_custom_columns_pro( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$pre_slug = '' ;
		$pre_slug = $post->post_title;
		$slug = sanitize_title($pre_slug);
    	//$shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[durood_sharief_fd name="'.$slug.'"]</strong>';
	    //echo $shortcode; 
	    break;
    }
}

function duroodshariefdiv_add_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_durood_sharief_fd_posts_columns' , 'duroodshariefdiv_add_columns');

function duroodshariefdiv_get_wysiwyg_output_pro( $meta_key, $post_id = 0 ) {
    global $wp_embed;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta( $post_id, $meta_key, 1 );
    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = do_shortcode( $content );
    $content = wpautop( $content );

    return $content;
}

function duroodshariefdiv_shortcode($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
		
	global $post;
    $args = array('post_type' => 'durood_sharief_fd', 'numberposts'=>-1);
    $custom_posts = get_posts($args);
	$output = '';
	foreach($custom_posts as $post) : setup_postdata($post);
	$sanitize_title = sanitize_title($post->post_title);
	if ($sanitize_title == $name)
	{
	$prefix = '_floating_div_';
	$all_pages = get_post_meta( get_the_id(), $prefix.'all_pages',true);
	if ($all_pages == '')
		$all_pages = 'no';
	
	if($all_pages == "no")
	{
		$div_content = get_post_meta( get_the_id(), $prefix . 'content', true );
		$div_width = get_post_meta( get_the_id(), $prefix . 'width', true );
		if ($div_width == '')
			$div_width = '260px';
		$div_width_class = "duroodshariefdiv_width_".$div_width;

		$div_corners = get_post_meta( get_the_id(), $prefix . 'corners', true );
		$div_position = get_post_meta( get_the_id(), $prefix . 'position', true );
		if ($div_position == '')
			$div_position = 'top_right';
		if (in_array($div_position, array('top_right', 'top', 'top_left'), true))
		{
			$div_margin_top = get_post_meta( get_the_id(), $prefix . 'margin_top', true );
			if ($div_margin_top == "")
				$div_margin_top = 0;
		}
		if (in_array($div_position, array('top_right', 'bottom_right'), true))
		{
			$div_margin_right = get_post_meta( get_the_id(), $prefix . 'margin_right', true );
			if ($div_margin_right == "")
				$div_margin_right = 0;
		}
		if (in_array($div_position, array('top_left', 'bottom_left'), true))
		{
			$div_margin_left = get_post_meta( get_the_id(), $prefix . 'margin_left', true );
			if ($div_margin_left == "")
				$div_margin_left = 0;
		}
		if (in_array($div_position, array('bottom_right', 'bottom', 'bottom_left'), true))
		{
			$div_margin_bottom = get_post_meta( get_the_id(), $prefix . 'margin_bottom', true );
			if ($div_margin_bottom == "")
				$div_margin_bottom = 0;
		}
		
		$div_borders = get_post_meta( get_the_id(), $prefix.'borders',true);
		$div_border_color = get_post_meta( get_the_id(), $prefix . 'border_color', true );
		if($div_border_color == "")
			$div_border_color = '#000000';
		
		if($div_borders == "yes" || $div_borders == "")
			$border_class = 'border:2px solid '.$div_border_color.'';
		
		if($div_borders == "no")
			$border_class = "border-style:none";

		$div_background = get_post_meta( get_the_id(), $prefix . 'background', true );

		if ($div_background == '')
			$div_background = 'color';
		$background = 'background:#FFFFFF';
		if ($div_background == 'color')
		{
			$div_background_color = get_post_meta( get_the_id(), $prefix . 'background_color', true );
			if($div_background_color == "")
				$div_background_color = '#FFFFFF';
			$background = 'background:'.$div_background_color.'';
		}
		
		if ($div_background == 'image')
		{
			$div_image = get_post_meta( get_the_id(), $prefix.'image',true);
			$background = 'background-image:url('.esc_attr($div_image).')';
		}
			
		$postid = get_the_ID();
		
		$css_position = '';
		switch ($div_position) {
		case 'top_right':
			$css_position .= 'right:'.$div_margin_right.'px;';   
			$css_position .= 'top:'.$div_margin_top.'px;';  
			break;
		case 'top':
			$css_position .= 'top:'.$div_margin_top.'px;';  
			$css_position .= 'left:50%;margin-left:-'. $div_width / 2 . 'px;'; 
			break;
		case 'top_left':
			$css_position .= 'left:'.$div_margin_left.'px;';  
			$css_position .= 'top:'.$div_margin_top.'px;';  
			break;
		case 'bottom_right':
			$css_position .= 'right:'.$div_margin_right.'px;';   
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			break;
		case 'bottom':
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			$css_position .= 'left:50%;margin-left:-'. $div_width / 2 . 'px;'; 
			break;
		case 'bottom_left':
			$css_position .= 'left:'.$div_margin_left.'px;';   
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			break;
		default:
			$css_position .= 'right:10px;';    
			$css_position .= 'top:10px;';  
		}
		$output = '';

		$output .= '<div id="floatdiv_'.$postid.'" class="exp_floatdiv_content_pro '.$device_restrict_no_tablet.' '.$device_restrict_no_desktop.' '.$device_restrict_no_mobile.' '.$force_font_class.' '.$div_width_class.'" style="'.$css_position.';border-radius:'.esc_attr( $div_corners).';'.$background.';">';
		$output .= '<div class="exp_floatdiv_content_padding_pro" style="'.$border_class.';border-radius:'.esc_attr( $div_corners).';">';
		$output .= ''. duroodshariefdiv_get_wysiwyg_output_pro( $prefix . 'content', get_the_ID() )  .'';
$output .= '</div>';
		$output .= '</div>';
		$output .= '<script type="text/javascript">';
		$output .= '$j=jQuery.noConflict();';
		$output .= '$j(document).ready(function()';
		$output .= '{';
						$output .= '$j("#floatdiv_'.$postid.'").hide("slow");';						
						$output .= '$j("#floatdiv_'.$postid.'").show("slow");';	
		$output .= '$j("#floatdiv_'.$postid.'").prepend("<button>CLOSE</button>");';					
		$output .= '$j("#floatdiv_'.$postid.' button").attr("class", "duroodshariefdiv_close");';					
		//$output .= '$j("#floatdiv_'.$postid.' a").attr("href", "#");';					
		$output .= '$j("#floatdiv_'.$postid.'").appendTo("body");';
		$output .= 'var height = $j("#floatdiv_'.$postid.'").height();';
		$output .= '$j("#floatdiv_'.$postid.'").height(height);';		
    	$output .= '$j(".duroodshariefdiv_close").click(function()';
		$output .= '{';	
		$output .= '$j(".exp_floatdiv_content_pro").hide("slow");';	
		$output .= '})';


		$output .= '})';	
		$output .= '</script>';
	}
    
	}
	endforeach; wp_reset_query();
	return $output;
}
add_shortcode( 'durood_sharief_fd', 'duroodshariefdiv_shortcode' );

function duroodshariefdiv_footer() {
	global $post;
    $args = array('post_type' => 'durood_sharief_fd', 'numberposts'=>-1);
    $custom_posts = get_posts($args);
	$output = '';
	foreach($custom_posts as $post) : setup_postdata($post);

	$prefix = '_floating_div_';
	$all_pages = get_post_meta( get_the_id(), $prefix.'all_pages',true);
	if ($all_pages == '')
		$all_pages = 'no';
	
	if($all_pages == "yes")
	{
		$div_content = get_post_meta( get_the_id(), $prefix . 'content', true );
		$div_width = get_post_meta( get_the_id(), $prefix . 'width', true );
		if ($div_width == '')
			$div_width = '260px';
		$div_width_class = "duroodshariefdiv_width_".$div_width;

		$div_corners = get_post_meta( get_the_id(), $prefix . 'corners', true );
		$div_position = get_post_meta( get_the_id(), $prefix . 'position', true );
		if ($div_position == '')
			$div_position = 'top_right';
		if (in_array($div_position, array('top_right', 'top', 'top_left'), true))
		{
			$div_margin_top = get_post_meta( get_the_id(), $prefix . 'margin_top', true );
			if ($div_margin_top == "")
				$div_margin_top = 0;
		}
		if (in_array($div_position, array('top_right', 'bottom_right'), true))
		{
			$div_margin_right = get_post_meta( get_the_id(), $prefix . 'margin_right', true );
			if ($div_margin_right == "")
				$div_margin_right = 0;
		}
		if (in_array($div_position, array('top_left', 'bottom_left'), true))
		{
			$div_margin_left = get_post_meta( get_the_id(), $prefix . 'margin_left', true );
			if ($div_margin_left == "")
				$div_margin_left = 0;
		}
		if (in_array($div_position, array('bottom_right', 'bottom', 'bottom_left'), true))
		{
			$div_margin_bottom = get_post_meta( get_the_id(), $prefix . 'margin_bottom', true );
			if ($div_margin_bottom == "")
				$div_margin_bottom = 0;
		}	
		
		$div_borders = get_post_meta( get_the_id(), $prefix.'borders',true);
		$div_border_color = get_post_meta( get_the_id(), $prefix . 'border_color', true );
		if($div_border_color == "")
			$div_border_color = '#000000';
		
		if($div_borders == "yes" || $div_borders == "")
			$border_class = 'border:2px solid '.$div_border_color.'';
		
		if($div_borders == "no")
			$border_class = "border-style:none";

		$div_background = get_post_meta( get_the_id(), $prefix . 'background', true );

		if ($div_background == '')
			$div_background = 'color';
		$background = 'background:#FFFFFF';
		if ($div_background == 'color')
		{
			$div_background_color = get_post_meta( get_the_id(), $prefix . 'background_color', true );
			if($div_background_color == "")
				$div_background_color = '#FFFFFF';
			$background = 'background:'.$div_background_color.'';
		}
		
		if ($div_background == 'image')
		{
			$div_image = get_post_meta( get_the_id(), $prefix.'image',true);
			$background = 'background-image:url('.esc_attr($div_image).')';
		}
			
		$postid = get_the_ID();
		
		$css_position = '';
		switch ($div_position) {
		case 'top_right':
			$css_position .= 'right:'.$div_margin_right.'px;';   
			$css_position .= 'top:'.$div_margin_top.'px;';  
			break;
		case 'top':
			$css_position .= 'top:'.$div_margin_top.'px;';  
			$css_position .= 'left:50%;margin-left:-'. $div_width / 2 . 'px;'; 
			break;
		case 'top_left':
			$css_position .= 'left:'.$div_margin_left.'px;';  
			$css_position .= 'top:'.$div_margin_top.'px;';  
			break;
		case 'bottom_right':
			$css_position .= 'right:'.$div_margin_right.'px;';   
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			break;
		case 'bottom':
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			$css_position .= 'left:50%;margin-left:-'. $div_width / 2 . 'px;'; 
			break;
		case 'bottom_left':
			$css_position .= 'left:'.$div_margin_left.'px;';   
			$css_position .= 'bottom:'.$div_margin_bottom.'px;';  
			break;
		default:
			$css_position .= 'right:10px;';    
			$css_position .= 'top:10px;';  
		}

		$output = '';

		$output .= '<div id="floatdiv_'.$postid.'" class="exp_floatdiv_content_pro '.$div_width_class.'" style="'.$css_position.';border-radius:'.esc_attr( $div_corners).';'.$background.';">';
	$output .= '<div class="exp_floatdiv_content_padding_pro" style="'.$border_class.';border-radius:'.esc_attr( $div_corners).';">';
		$output .= ''. duroodshariefdiv_get_wysiwyg_output_pro( $prefix . 'content', get_the_ID() )  .'';
		$output .= '</div>';
		$output .= '</div>';

		$output .= '<script type="text/javascript">';
		$output .= '$j=jQuery.noConflict();';
		$output .= '$j(document).ready(function()';
		$output .= '{';	
						$output .= '$j("#floatdiv_'.$postid.'").hide("slow");';						
						$output .= '$j("#floatdiv_'.$postid.'").show("slow");';						

		$output .= '$j("#floatdiv_'.$postid.'").prepend("<button>CLOSE</button>");';					
		$output .= '$j("#floatdiv_'.$postid.' button").attr("class", "duroodshariefdiv_close");';					
		//$output .= '$j("#floatdiv_'.$postid.' a").attr("href", "#");';					
			
		$output .= '$j("#floatdiv_'.$postid.'").appendTo("body");';

		$output .= 'var height = $j("#floatdiv_'.$postid.'").height();';
		$output .= '$j("#floatdiv_'.$postid.'").height(height);';

    	$output .= '$j(".duroodshariefdiv_close").click(function()';
		$output .= '{';	
		$output .= '$j(".exp_floatdiv_content_pro").hide("slow");';	
		$output .= '})';
		
		$output .= '})';
			
		$output .= '</script>';

	}
    
	endforeach; wp_reset_query();
	echo $output;
}
add_action( 'wp_footer', 'duroodshariefdiv_footer' );


	
?>