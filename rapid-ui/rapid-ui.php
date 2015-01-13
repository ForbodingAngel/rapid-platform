<?php

class RapidUI {

	function __construct() {
		add_action('init', array($this, 'init'));
	}
	
	function init() {
		add_action('wp_enqueue_scripts', array($this, 'load_shortcodes_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'load_shortcodes_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'load_shortcodes_styles'));
		add_action('admin_enqueue_scripts', array($this, 'load_shortcodes_styles'));
		//add_action('wp_head', array($this, 'load_shortcodes_less')); UNDONE: less will be implemented at a later time...
		
		add_shortcode( 'rp_accordion', array($this, 'rp_accordion') );
		add_shortcode( 'rp_button', array($this, 'rp_button') );
		add_shortcode( 'rp_callout', array($this, 'rp_callout') );
		add_shortcode( 'rp_caption_box', array($this, 'rp_caption_box') );
		add_shortcode( 'rp_quote', array($this, 'rp_quote') );
		add_shortcode( 'rp_echo_shortcode', array($this, 'rp_echo_shortcode') );
		add_shortcode( 'rp_hbar', array($this, 'rp_hbar') );
		add_shortcode( 'rp_likert', array($this, 'rp_likert') );
		add_shortcode( 'rp_choice', array($this, 'rp_choice') );
		add_shortcode( 'rp_list', array($this, 'rp_list') );
		add_shortcode( 'rp_paged_menu', array($this, 'rp_paged_menu') );
		add_shortcode( 'rp_select_bar', array($this, 'rp_select_bar') );
		add_shortcode( 'rp_slider', array($this, 'rp_slider') );
		add_shortcode( 'rp_style', array($this, 'rp_style') );
		add_shortcode( 'rp_style_nest1', array($this, 'rp_style') );
		add_shortcode( 'rp_style_reset', array($this, 'rp_style_reset') );
		add_shortcode( 'rp_gcse', array($this, 'rp_gcse') );
		add_shortcode( 'rp_grid', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest0', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest1', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest2', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest3', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest4', array($this, 'rp_grid') );
		add_shortcode( 'rp_grid_nest5', array($this, 'rp_grid') );
		//add_shortcode( 'rp_gplus_stream', array($this, 'rp_gplus_stream') );
		add_shortcode( 'rp_spacer', array($this, 'rp_spacer') );
		add_shortcode( 'rp_snapshot', array($this, 'rp_snapshot') );
		add_shortcode( 'rp_login', array($this, 'rp_login') ); // TODO: change to rp_login_form, see other notes about deprecation...
		add_shortcode( 'rp_tabs', array($this, 'rp_tabs') );
		add_shortcode( 'rp_tab', array($this, 'rp_tab') );
	}
	
	// load rapid-ui.js file and third-party scripts
	function load_shortcodes_scripts() {
		wp_enqueue_script('rp-ui', plugin_dir_url( __FILE__ ) . 'rapid-ui.js', array('jquery', 'jquery-ui-core'));
		wp_enqueue_script('rp-jquery-easing', "http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('jquery', 'jquery-ui-core'));
	}

	// load rapid-ui.css file and third-party styles
	function load_shortcodes_styles() {
		wp_enqueue_style('rp-ui', plugin_dir_url( __FILE__ ) . 'rapid-ui.css');
		wp_enqueue_style('rp-fontello16', plugin_dir_url( __FILE__ ) . '/libs/fontello/css/fontello16.css');
		//wp_enqueue_style('rp-ui-less', plugin_dir_url( __FILE__ ) . 'rapid-ui.less'); UNDONE: less will be implemented at a later time...
	}
	//UNDONE: less will be implemented at a later time...
	/*
	function load_shortcodes_less() {
		echo '<link rel="stylesheet/less" type="text/css" href="' . plugin_dir_url( __FILE__ ) . 'rapid-ui.less' . '" />';
	}
	*/

	// injects some quick filler text wherever you might need some, for testing purposes
	function get_lorem_ipsum($short = true) {
		if ($short == true) {
			return "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
		}
		else {
			return "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis libero vel justo sagittis ultrices. Donec vitae metus eget orci blandit suscipit ac vitae mi. Nullam pharetra lacus sed tellus molestie ornare. Duis sit amet nunc ipsum. Quisque malesuada massa quis sapien rutrum et posuere tellus rhoncus. Aliquam id eros urna. Phasellus lacinia eros in augue accumsan ornare. Sed ac urna metus. Aliquam et eleifend augue. Aliquam erat volutpat. Quisque sed eros orci, ac imperdiet sem. Nunc ut lacus elit, vitae blandit tellus. Aliquam adipiscing tincidunt sem eget adipiscing. Integer nisl magna, iaculis in consectetur vel, volutpat vel enim. Phasellus vel arcu quam, sed pharetra massa. Nam dignissim sollicitudin mi.";
		}
	}
	
	/*UNDONE: RapidLogin() is deprecated; instead we should merge in recent work on 
		my WP-OpenLogin plugin...will need to determine how to handle plugin dependencies
	function rp_login( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'title' => 'Title',
		), $atts );
		$html = "";
		$html .= "<div class='rp_login'>";
		$html .= "<a href='#' onclick='loginOpenID(\"google\"); return false;'>Google</a><br/>";
		$html .= "<a href='#' onclick='loginFacebook(); return false;'>Facebook</a><br/>";
		$html .= "<a href='#' onclick='loginOpenID(\"yahoo\"); return false;'>Yahoo</a><br/>";
		$html .= "<a href='#' onclick='loginOpenID(\"myopenid\"); return false;'>MyOpenID</a><br/>";
		$html .= "</div>";
		return $html;
	}
	*/
	
	// TODO: rename to tab pages/tab page
	// TODO: which tab to show starting out? this would depend on the active rp-choice-button,
	//	and that could depend on the rp-choice "reverse" attribute, since the rp-choice could
	//	possibly start out with button 5 active first...
	// TODO: don't we already handle tabs in the choice shortcode?
	function rp_tabs( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'title' => 'Title',
			'id' => 'rp-tabs',
		), $atts );
		$html = "";
		$html .= "<div id='" . $atts["id"] . "' class='rp-tabs'>";
		$html .= do_shortcode($content);
		$html .= "</div>";
		return $html;
	}
	
	function rp_tab( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'title' => 'Title',
		), $atts );
		$html = "";
		$html .= "<div class='rp-tab'>";
		$html .= do_shortcode($content);
		$html .= "</div>";
		return $html;
	}
	
	/*============================================
		ACCORDION:
		
		Hide content in a drop-down tray thing.
	*/

	function rp_accordion( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'title' => 'Title',
			'title_color' => 'inherit',
			'title_float' => 'left',
			'icon_float' => 'right',
			'icon_class' => 'icon-plus-squared',
			'style' => '',
			'design' => 'basic',
		), $atts );
		
		if ($content == null) {
			$processed_content = "Custom text, HTML or shortcodes go here...";
		}
		else {
			//$content = str_replace("\r\n", '', $content);
			$processed_content = do_shortcode($content);
		}
		
		$html = "";
		$html .= '<div class="rp-accordion rp-accordion-design-' . $atts['design'] . '" style="' . $atts['style'] . '" onmousedown="return false;">';
		$html .= '<div class="rp-accordion-top" style="text-align:' . $atts['title_float'] . '; color:' . $atts['title_color'] . '">';
		$html .= "<i class='rp-accordion-icon " . $atts['icon_class'] . "' style='float:" . $atts['icon_float'] . ";'></i>";
		$html .= '<span class="rp-accordion-title">' . $atts['title'] . '</span>';
		$html .= '</div>';
		$html .= '<div class="rp-accordion-content">' . $processed_content . '</div>';
		//$html .= '<div class="accordion-content">' . do_shortcode($content) . '</div>';
		$html .= '</div>';
		return $html;
	}
	
	/*============================================
		BUTTON:
		
		I hope you know what a button does!
	*/

	function rp_button( $atts ){
		$atts = shortcode_atts( array(
			'caption' => 'Button',
			'caption_b' => '',
			'color' => '',
			'icon_class' => '',
			'link' => 'javascript:void(0);',
			'target' => '_blank',
			'design' => 'cassette',
			'width' => 'auto',
			'style' => '',
		), $atts );
		$html = "";
		// handle special cases for the DESIGN attribute
		if ($atts['caption_b'] != "") {
			//$html .= "<span class='rp-button rp-button-design-" . $atts['design'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "' data-caption='" . $atts['caption'] . "' data-caption_b='" . $atts['caption_b'] . "' onmousedown='return false;'>";
			$html .= "<span class='rp-button rp-button-design-" . $atts['design'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "' data-caption='" . $atts['caption'] . "' data-caption_b='" . $atts['caption_b'] . "'>";
		}
		else {
			//$html .= "<span class='rp-button rp-button-design-" . $atts['design'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "' onmousedown='return false;'>";
			$html .= "<span class='rp-button rp-button-design-" . $atts['design'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "'>";
		}
		//$html .= "<span class='rp-button rp-button-design-" . $atts['design'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "' onmousedown=''>";
		//$html .= "<a class='rp-button rp-button-design-" . $atts['design'] . " " . $atts['icon_class'] . "' style='width:" . $atts['width'] . "; " . $atts['style'] . "' href='" . $atts['link'] . "'>";
		$html .= "<span class='" . $atts['icon_class'] . "' style='color:" . $atts['color'] . "' data-href='" . str_replace("'", "&quot;", $atts['link']) . "'>";
		$html .= $atts['caption'];
		$html .= "</span>";
		$html .= "</span>";
		return $html;
	}

	/*============================================
		CALLOUT:
		
		Inserts a block of text that is styled fancily for directing the reader's attention to this block.
	*/

	function rp_callout ( $atts, $content = null, $tag ){
		$atts = shortcode_atts( array(
			'caption' => '',
			'width' => '90%',
			'padding' => '0.5em',
			'icon_class' => '',
			'icon_size' => '1em',
			'design' => 'float',
			'style' => '',
		), $atts );
		if ($atts['caption'] == "" && $content == null) {
			$processed_content = $this->get_lorem_ipsum();
		}
		else {
			$processed_content = do_shortcode($content);
		}
		$html = '';
		$html .= '<div class="rp-callout rp-callout-design-' . $atts['design'] . '">';
		// handle certain designs that may need to specify their own default attribute values
		// TODO: this isn't a good idea especially when we introduce user designs; maybe use a 
		// WordPress filter or hook to let the user tap into this special handling, otherwise 
		// don't use special handling and just make sure the user specifies the icon-class for 
		// every design where an icon is desired, though this doesn't really save time
		if ($atts['design'] == 'quote' ) {
			$atts['icon_class'] = "icon-quote";
			$atts['icon_size'] = "2.5em";
		}
		// output the caption if it has been set
		if ($atts['caption'] != '' ) {
			$html .= '<p style="' . $atts['style'] . '">' . $atts['caption'] . '</p>';
		}
		// output the icon if it has been set
		if ($atts['icon_class'] != '' ) {
			$html .= '<i class="' . $atts['icon_class'] . '" style="float:left; font-size:' . $atts['icon_size'] . ';"></i>';
		}
		$html .= '<div>' . $processed_content . '</div>';
		$html .= '</div>';
		return $html;
	}

	/*============================================
		CAPTION BOX:
		
		Inserts an image with a caption (text) and click event.
	*/

	function rp_caption_box($atts, $content = null) {
		$atts = shortcode_atts(array(
			'title' => 'Caption Box',
			'title_opacity' => '0',
			'title_color' => '',
			'width' => '100%',
			'height' => '200px',
			'img_abs' => '',
			'img_rel' => '',
			'img_pos' => '0,0',
			'count' => '',
			'link' => '#',
			'design' => 'basic'
		), $atts);
		if ($atts["img_abs"] != "") {
			$img_path = $atts["img_abs"];
		}
		elseif ($atts["img_rel"] != "") {
			$img_path = plugin_dir_url( __FILE__ ) . '/' . $atts["img_rel"];
		}
		$html = "";
		$html .= '<div class="rp-caption-box rp-caption-box-design-' . $atts['design'] . '" style="width:' . $atts['width'] . ';height:' . $atts['height'] . '; background-image:url(' . $img_path . ');">';
		$html .= '<div class="rp-caption-box-title" style="color:' . $atts['title_color'] . ';">' . $atts['title'] . '</div>';
		//$html .= '<div class="rp-caption-box-count">' . $atts['count'] . '</div>';
		$html .= '<a class="rp-caption-box-link" href="' . $atts['link'] . '"></a>';
		$html .= '</div>';
		return $html;
	}

	/*============================================
		QUOTE:
		
		TODO: possibly deprecated by rp_callout...
	*/

	function rp_quote($atts, $content = null) {
		$atts = shortcode_atts(array(
			'design' => 'basic'
		), $atts);
		if ($content == null) {
			$content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
		}
		$html = "";
		$html .= '<div class="rp-quote rp-quote-design-' . $atts['design'] . '" style="width:' . $atts['width'] . ';height:' . $atts['height'] . '; background-image:url(' . $img_path . ');">';
		$html .= '<i class="icon-quote"></i><p style="padding-left:55px;">' . $content . '</p>';
		$html .= '</div>';
		return $html;
	}
	
	/*============================================
		ECHO SHORTCODE:
		
		Allows echoing (printing) a shortcode's syntax on a page, without it being processed as a shortcode by WordPress.
	*/

	function rp_echo_shortcode( $atts, $content = null ){
		$atts = shortcode_atts( array(
			'' => '',
		), $atts );
		return $content;
	}

	/*============================================
		GOOGLE CUSTOM SEARCH ENGINE:
		
		Add a custom Google Search to your site.
	*/
	
	function rp_gcse($atts) {
		$atts = shortcode_atts( array(
			'cx' => '',
		), $atts );
		$cx = $atts['cx'];
		if ($cx != "") {
			return "
			<script>
			  (function() {
				var cx = '" . $cx . "';
				var gcse = document.createElement('script'); gcse.type = 'text/javascript'; gcse.async = true;
				gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
					'//www.google.com/cse/cse.js?cx=' + cx;
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
			  })();
			</script>
			<gcse:search></gcse:search>
			";
		}
	}

	/*============================================
		GPLUS STREAM:
		
		Add a Google Plus stream to your site.
	*/
	
	// TODO: this fires every time we view the page and quickly reaches the 1000 query limit for Google
	// TODO: cache the results into the db with a timestamp, serve the cached data, refresh the cache every N minutes (check each time this shortcode is called)
	function rp_gplus_stream($atts) {
		$atts = shortcode_atts( array(
			'id' => '',
			'key' => '',
		), $atts );
		$id = $atts['id'];
		$key = $atts['key'];
		$feed = json_decode(file_get_contents('https://www.googleapis.com/plus/v1/people/'.$id.'/activities/public?key='.$key));
		$html = "";
		$html .= "<div class='rp-gplus-stream'>";
		foreach ($feed->items as $item) {
			$html .= $item;
		}
		$html .= "</div>";
		$html = print_r($feed);
		echo $html;
	}

	/*============================================
		GRID:
		
		Responsive columns/grids with nesting capability.
	*/

	//$rapid_grid_levels;
	function rp_grid ( $atts, $content = null, $tag ){
		$atts = shortcode_atts( array(
			'count' => 2,
			'span' => 1,
			'margin' => '5%',
			'class' => '',
		), $atts );
		// grab the global variable where the nested shortcode states are stored for recursive reference
		global $rapid_grid_levels;
		// keep track of how many columns have been output so far for this specific recursion
		//$rapid_grid_levels[$tag]++;
		$rapid_grid_levels[$tag] += $atts['span'];
		// process the content and any shortcodes it may contain
		$content_processed = do_shortcode($content);
		//$width = $atts['span'] * ((100 / $atts['count']) - 0);
		$margin_total_percent = $atts['margin'] * ($atts['count'] - 1);
		$column_percent = (100 - $margin_total_percent) / $atts['count'] * $atts['span'];
		$html = '';
		$group_class = '';
		$group_class = "rp-column-group " . $atts['class'];
		if ($atts['count'] == 1) { $group_class .= " rp-column-group-single" ; }
		$column_class = "rp-column";
		if ($rapid_grid_levels[$tag] == 1) {
			// first column
			$html .= '<div class="' . $group_class . '">';
			$column_class .= " rp-column-first";
		}
		if ($rapid_grid_levels[$tag] == $atts['count']) {
			// last column
			$column_class .= " rp-column-last";
		}
		//$html .= '<div class="rp-column" style="width:' . $width . '%; padding-right:' . $atts['spacing'] . '">' . $content_processed . '</div>';
		$html .= '<div class="' . $column_class . '" style="width:' . $column_percent . '%; margin-right:' . $atts['margin'] . ';">' . $content_processed . '</div>';
		if ($rapid_grid_levels[$tag] == $atts['count']) {
			$html .= '</div>';
			$html .= '<div style="clear:both;"></div>';
			$rapid_grid_levels[$tag] = null;
		}
		return $html;
	}


	/*============================================
		HORIZONTAL BAR:
		
		TODO: merge with rp_spacer...
	*/

	function rp_hbar( $atts ){
		$atts = shortcode_atts( array(
			'design' => 'basic'
		), $atts );
		$shortcode_html = "";
		$shortcode_html .= "<div class='rp-hbar rp-hbar-design-" . $atts['design'] . "'></div>";
		return $shortcode_html;
	}

	/*============================================
		LIKERT SCALE:
		
		TODO: Possibly deprecated by rp_choice...
	*/

	function rp_likert($atts, $content = null) {
		$atts = shortcode_atts(array(
			'labels' => '1,2,3,4,5',
			'start_text' => 'Least Likely',
			'end_text' => 'Most Likely',
			'width' => '100%',
			'reverse' => 2 // can be 0 (false), 1 (true), 2(random)
		), $atts);
		
		$labels_array = explode(",", $atts['labels']);
		$label_count = count($labels_array);
		$label_index = 0;
		$start_class = "a";
		
		// handle reverse order
		if ($atts['reverse'] == 2) { $atts['reverse'] = rand(0,1); } // if the reverse was set to random, set the reverse randomly to 0/1 (true/false)
		if ($atts['reverse'] == true) {
			// reverse label index
			$label_index = $label_count;
			// reverse the labels
			$labels_array = array_reverse($labels_array, true);
			// reverse the start/end text
			$end_text = $atts['end_text'];
			$start_text = $atts['start_text'];
			$atts['start_text'] = $end_text;
			$atts['end_text'] = $start_text;
		}
		
		$likert_html = "";
		
		// start the likert scale wrap
		$likert_html .= '<div class="rp-likert" style="width:' . $atts['width'] . '" onmousedown="return false;">';
		$likert_html .= '<div class="rp-likert-section"><div class="rp-likert-label-a">' . $atts['start_text'] . '</div></div>';
		
		// echo each likert scale label while constructing the legacy form field html
		$i = 0;
		$select_element_html = '';
		foreach ($labels_array as $label_text) {
			$i++;
			if ($i == 1) {
				$select_element_html .= '<select><option value="' . $label_text . '">' . $label_text . ' (' . $atts['start_text'] . ')</option>';
				$likert_html .= '<div class="rp-likert-section"><div class="rp-likert-anchor"><div class="rp-likert-anchor-label">' . $label_text . '</div></div></div>';
			}
			elseif ($i == $label_count) {
				$select_element_html .= '<option value="' . $label_text . '">' . $label_text . ' (' . $atts['end_text'] . ')</option></select>';
				$likert_html .= '<div class="rp-likert-section"><div class="rp-likert-anchor"><div class="rp-likert-anchor-label">' . $label_text . '</div></div><div class="rp-likert-label-b">' . $atts['end_text'] . '</div></div>';
			}
			else {
				$select_element_html .= '<option value="' . $label_text . '">' . $label_text . '</option>';
				$likert_html .= '<div class="rp-likert-section"><div class="rp-likert-anchor"><div class="rp-likert-anchor-label">' . $label_text . '</div></div></div>';
			}
		}
		
		// echo the legacy form field html
		$likert_html .= $select_element_html;
		
		// end the likert scale wrap
		$likert_html .= '</div>';
		
		return $likert_html;
		
	}
	
	/*============================================
		CHOICE:
		
		TODO: it should be possible to init without ANY button active
		TODO: change labels to buttons
		TODO: add labels and use this for start/end text instead
		TODO: add show_labels for showing/hiding the labels
		TODO: add label_behavior attribute with possible values of 
			"tail" (clicking the label activates the nearest tail button) 
			or "one" (clicking the label moves the active button to the 
			left or right by one). Allow the labels to be clicked and also 
			linked to a js function. This is needed for the pagination design.
		TODO: add a method for binding the choice to a set of internal "div" 
			pages for building things such as tabbed content
	*/

	function rp_choice($atts, $content = null) {
		$atts = shortcode_atts(array(
			'labels' => '1,2,3,4,5',
			'start_text' => 'Least Likely',
			'end_text' => 'Most Likely',
			'width' => 'auto',
			'design' => 'likert',
			'reverse' => 0, // can be 0 (false), 1 (true), 2(random)
			'action' => '' // TODO: implement the action attribute
		), $atts);
		
		$labels_array = explode(",", $atts['labels']);
		$label_count = count($labels_array);
		$label_index = 0;
		$start_class = "a";
		
		// handle reverse order
		if ($atts['reverse'] == 2) { $atts['reverse'] = rand(0,1); } // if the reverse was set to random, set the reverse randomly to 0/1 (true/false)
		if ($atts['reverse'] == true) {
			// reverse label index
			$label_index = $label_count;
			// reverse the labels
			$labels_array = array_reverse($labels_array, true);
			// reverse the start/end text
			$end_text = $atts['end_text'];
			$start_text = $atts['start_text'];
			$atts['start_text'] = $end_text;
			$atts['end_text'] = $start_text;
		}
		
		$choice_html = "";
		
		// start the choice scale wrap
		$choice_html .= '<table data-rp-action="' . $atts['action'] . '" class="rp-choice rp-choice-design-' . $atts['design'] . '" style="width:' . $atts['width'] . '" onmousedown="return false;"><tbody><tr>';
		$choice_html .= '<td class="rp-choice-label">' . $atts['start_text'] . '</td>';
		
		// echo each choice scale label while constructing the legacy form field html
		$i = 0;
		$select_element_html = '';
		foreach ($labels_array as $label_text) {
			$i++; // i starts at 1
			
			$class = "";
			if ($i == 1) {$class = "first active";}
			if ($i == $label_count) {$class = "last";}
			
			if ($i != 1 || $i == $label_count) {
				$choice_html .= '<td class="rp-choice-spacer">&nbsp;<div class="rp-choice-spacer-line"></div></td>';
			}
			
			$choice_html .= '<td class="rp-choice-button ' . $class . '"><div class="rp-choice-button-label">' . $label_text . '</div></td>';
			
			
			/*
			if ($i == 1) {
				$select_element_html .= '<select><option value="' . $label_text . '">' . $label_text . ' (' . $atts['start_text'] . ')</option>';
				$choice_html .= '<td class="rp-choice-section"><div class="rp-choice-anchor"><div class="rp-choice-anchor-label">' . $label_text . '</div></div></td>';
			}
			elseif ($i == $label_count) {
				$select_element_html .= '<option value="' . $label_text . '">' . $label_text . ' (' . $atts['end_text'] . ')</option></select>';
				$choice_html .= '<td class="rp-choice-section"><div class="rp-choice-anchor"><div class="rp-choice-anchor-label">' . $label_text . '</div></div><div class="rp-choice-label-b">' . $atts['end_text'] . '</div></td>';
			}
			else {
				$select_element_html .= '<option value="' . $label_text . '">' . $label_text . '</option>';
				$choice_html .= '<td class="rp-choice-section"><div class="rp-choice-anchor"><div class="rp-choice-anchor-label">' . $label_text . '</div></div></td>';
			}
			*/
		}
		
		//$choice_html .= '<td class="rp-choice-section"><div class="rp-choice-label-b">' . $atts['end_text'] . '</div></td>';
		$choice_html .= '<td class="rp-choice-label">' . $atts['end_text'] . '</td>';
		
		// echo the legacy form field html
		$choice_html .= $select_element_html;
		
		// end the choice scale wrap
		$choice_html .= '</tbody></tr></table>';
		
		return $choice_html;
		
	}
	
	/*
	NEW CHOICE CODE:

	<div class="rp-choice" style="box-sizing: border-box;width:100%" onmousedown="return false;">

		<div class="rp-choice-anchor-label">5</div>
		<div style="display: inline-block;width: 10px;box-sizing: border-box;position: relative;height: 100%;">
			&nbsp;
			<div style="border-bottom: 2px solid;display: inline-block;position: absolute;top: 50%;left: 0;bottom: 0;right: 0;height: 2px;"></div>
		</div>
		
		<div class="rp-choice-anchor-label">4</div>
		<div style="display: inline-block;width: 10px;box-sizing: border-box;position: relative;height: 100%;">
			&nbsp;
			<div style="border-bottom: 2px solid;display: inline-block;position: absolute;top: 50%;left: 0;bottom: 0;right: 0;height: 2px;"></div>
		</div>
		<div class="rp-choice-anchor-label">3</div>
	</div>
	*/
	
	/*============================================
		LIST:
		
		A list item can reference a single image 
		file, an icon_set (sprite .png) + an 
		icon_pos (position within the sprite), or
		a named icon from the fontello icon set.
		
		Priority: Sprite -> Single -> Fontello
	*/

	//$rp_list_levels;
	function rp_list( $atts, $content = null, $tag ){
		$atts = shortcode_atts( array(
			'design' => 'basic',
			'flags' => '',
			'count' => 1,
			'span' => 1,
			'indent' => '24px',
			'icon_class' => 'icon-right-circled',	// fontello old
			'icon_name' => 'icon-right-circled', 	// fontello as the source e.g. icon-floppy
			'icon_sprite' => 'img/icons-32x32.png', // sprite as the source e.g. img/icons-32x32.png
			'icon_pos' => '',						// sprite position e.g. -64px 0px
			'icon_img' => '',						// single image as the source e.g. img/file.png
			'icon_size' => '16px',					// size of the icon
		), $atts );
		// grab the global variable where the nested shortcode states are stored for recursive reference
		global $rp_list_levels;
		// keep track of how many columns have been output so far for this specific recursion
		$rp_list_levels[$tag]++;
		if ($atts['caption'] == "" && $content == null) {
			$processed_content = $this->get_lorem_ipsum();
		}
		else {
			$processed_content = do_shortcode($content);
		}
		$processed_content = str_replace("\r\n", '', $processed_content);
		$html = "";
		$group_class = "rp-list rp-list-design-" . $atts['design'];
		$item_class = "rp-list-item";
		if ($rp_list_levels[$tag] == 1) {
			// first
			$html .= '<div class="' . $group_class . '">';
			$item_class .= " rp-list-item-first";
		}
		elseif ($rp_list_levels[$tag] == $atts['count']) {
			// last
			$item_class .= " rp-list-item-last";
		}
		$html .= "<div class='" . $item_class . "' style='clear:both;'>";
		//$html .= "<img src='" . get_bloginfo('template_directory') . "/icons/" . $atts['icon'] . "' style=''></img>";
		//$html .= "<div style='background-image:url(" . get_bloginfo('stylesheet_directory') . '/rapid-core/shortcodes/' . $atts['iconset'] . ");'></div>";
		
		// output the icon
		if ($atts['icon_pos'] != "") {
			// output icon via sprite mode
			//$html .= "<div>";
			$html .= "<span style='width:" . $atts['icon_size'] . "; height:" . $atts['icon_size'] . "; background-image:url(" . plugin_dir_url( __FILE__ ) . "" . $atts['icon_sprite'] . "); background-position:" . $atts['icon_pos'] . ";'></span>";
			//$html .= "</div>";
		}
		elseif ($atts['icon_img'] != "") {
			// output icon via single image mode
			$html .= "<span style='background-image:url(" . $atts['icon_img'] . ");></span>";
		}
		else {
			// output icon via fontello mode
			$html .= "<span class='" . $atts['icon_class'] . "' style='background-position:" . $atts['icon_pos'] . ";'></span>";
		}
		//$padding = str_replace("px", "", $atts['icon_size']);
		//$padding += 10;
		$html .= "<p style='padding-left:" . $atts['indent'] . "'><span>" . $processed_content . "</span></p>";
		$html .= "</div>";
		if ($rp_list_levels[$tag] == $atts['count']) {
			$html .= '</div>';
			$rp_list_levels[$tag] = null;
		}
		return $html;
	}

	/*============================================
		PAGED MENU:

		Converts a UL list into a slider menu, binding any
		parent LI (menu-item) with it's child UL (sub-menu)
		to maintain the parent/child relationship after the
		UL list is flattened into several individual pages.
		
		Requires rapid-shortcodes.js
		
		TODO:
		
		Make sure this works with multiple menus (menu att)
	*/

	function rp_paged_menu( $atts, $content = null, $tag ){
		$atts = shortcode_atts( array(
			'menu' => '',
			'design' => 'basic',
		), $atts );
		// get the menu and strip empty p tags
		$menu_html = wp_nav_menu(array('container' => '', 'echo' => false));
		// use Simple HTML DOM to strip the empty p tags
		$menu_dom = str_get_html($menu_html);
		$stray_paragraphs = $menu_dom->find("p");
		foreach($stray_paragraphs as $p) {
			if(trim($p->plaintext) == '') {
				$p->outertext = '';
			}
		}
		$html = "";
		$html .= '<div class="rp-paged-menu rp-paged-menu-design-' . $atts['design'] . '" onmousedown="return false;">' . $menu_dom . '</div>';
		return $html;
	}

	
	/*============================================
		SPACER:
		
		Inserts a horizontal space or break. Useful in some cases where a quick HTML break is not 
		possible (e.g. WordPress editor LOVES to strip those out).
		
		TODO: rename to 'break' or similar and merge with horizontal line...they are the same idea
	*/

	function rp_spacer( $atts ){
		$atts = shortcode_atts( array(
			'' => '',
		), $atts );
		$html = "";
		$html .= "<span class='rp-spacer'></span>";
		return $html;
	}
	
	/*============================================
		STYLE:
		
		Experimental, do not use this.
	*/

	//$rp_style_levels;
	function rp_style( $atts, $content = null, $tag ){
		$atts = shortcode_atts( array(
			'style' => '',
			'class' => '',
			'count' => 1,
		), $atts );
		// grab the global variable where the nested shortcode states are stored for recursive reference
		global $rp_style_levels;
		// keep track of how many columns have been output so far for this specific recursion
		$rp_style_levels[$tag]++;
		$content_processed = do_shortcode($content);
		$html = "";
		$html .= "<div class='rp_style' style='" . $atts['style'] . "'>";
		//$html = "<style type='text/css'>";
		//$html .= "body {" . $atts['body'] . "}";
		//$html .= "</style>";
		$html .= $content_processed;
		$html .= "</div>";
		if ($rp_style_levels[$tag] == $atts['count']) {
			//$html .= '</div>';
			$rp_style_levels[$tag] = null;
		}
		return $html;
	}


	function rp_style_reset( $atts ){
		$atts = shortcode_atts( array(
			'parent' => 'post',
			'css' => '',
		), $atts );
		$html = "";
		$html = "<style type='text/css'>";
		$html .= $atts['css'];
		$html .= "</style>";
		return $html;
	}

	/*============================================
		SLIDER:
		
		A content slider.
	*/

	function rp_slider() {

		// outer wrap
		$slider_html = "";
		$slider_html .= '<div class="slide-wrap">';
		$slider_html .= '<div class="slide-frame"></div>';
		
		/* here we actually load the main slider images, even though they are hidden, so we can load the main slider descriptions, then preload the images */
		
		// get the user-defined Gallery (Post set to Gallery category)
		$slider_gallery_title = get_option('chelsea_theme_slider_gallery');
		$slider_gallery_post = get_page_by_title($slider_gallery_title, 'OBJECT', 'post');
		$slider_gallery_post_id = $slider_gallery_post->ID;
		
		// get the images from the Gallery Post
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $slider_gallery_post_id // TODO: this is a hardcoded post id, need to grab the Slider Post's ID!
		) );
		
		// output each image as a separate slide-anchor
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$image_info = wp_get_attachment_image_src( $attachment->ID, 'slider' );
				$slider_html .= '<a class="slide-anchor" href="#">';
				$slider_html .= '<img class="slide-img" src="' . $image_info[0] . '"></img>';
				$slider_html .= '</a>';
			}
		}
		
		// outer wrap
		$slider_html .= '<div class="slide-button-left"><span><</span></div>';
		$slider_html .= '<div class="slide-button-right"><span>></span></div>';
		$slider_html .= '</div>';
		
		return $slider_html;

	}

	/*============================================
		SELECT BAR:
		
		TODO: probably deprecated by rp_choice...
	*/

	function rp_select_bar( $atts ){
		$atts = shortcode_atts( array(
			'options' => 'A,B,C',
			'bgcolor' => '#777',
			'bgimage' => '',
			'class' => 'rp-select-bar-xxx',
		), $atts );
		$shortcode_html .= '<div class="rp-select-bar ' . $atts['class'] . '" style="background-image:url(' . $atts['bgimage'] . '); background-color:' . $atts['bgcolor'] . ';">';
		$shortcode_html .= '<ul>';
		$options = explode(",", $atts['options']);
		$i = 0;
		foreach ($options as $option) {
			$i++;
			if ($i == 1) {
				$shortcode_html .= '<li class="selected"><a href="#">' . $option . '</a></li>';
			}
			else {
				$shortcode_html .= '<li class=""><a href="#">' . $option . '</a></li>';
			}	
		}
		$shortcode_html .= '</ul>';
		$shortcode_html .= '</div>';
		return $shortcode_html;
	}

	/*============================================
		SNAPSHOT:
		
		Takes a snapshot of an external website given its url, then caches it in WordPress so
		that if the external website changes the snapshot does not change.
		
		Currently uses unofficial Wordpress.com mShots API
		
		TODO: first determine if thumb already exists in local cache, if so display it instead
			of regenerating another thumb.
			
		TODO: we're now getting 403 FORBIDDEN errors using CURL to acquire the $imagedata so
			remove the thumb caching functionality and migrate to a new lib (node-webshot)
	*/
	
	function rp_snapshot( $atts ){
		$atts = shortcode_atts( array(
			'link_url' => $_SERVER['SERVER_NAME'],
			'size' => '250',
		), $atts );
		
		$external_url = $atts["link_url"];
		$full_url = "http://s.wordpress.com/mshots/v1/" . rawurlencode($external_url) . "?w=" . $atts["size"];
		
		/*UNDONE: now getting 403 FORBIDDEN errors using CURL...
		// first cURL makes mShots cache the website thumbnail (does not return data)
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $full_url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		curl_exec($curl_handle);
		curl_close($curl_handle);

		// sleep for 10 seconds to allow mShots to finish
		//sleep(10);

		// second cURL (after wait) downloads the website thumbnail from mShots
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $full_url);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$imagedata = curl_exec($curl_handle);
		curl_close($curl_handle);

		echo print_r($imagedata);
		
		// build an image from the mShots data returned by cURL
		$imagedata = @imagecreatefromstring($imagedata); // to build as image

		// TODO: save this image with a unique name into the uploads/thumbs folder
		//if($imagedata) {imagejpeg($imagedata, dirname(__FILE__) . "/test.jpg");} // WORKS!!!
		$wp_upload_dir = wp_upload_dir();
		$new_file_url = $wp_upload_dir["baseurl"] . "/site-thumb-cache/" . date("Y") . "/" . date("m") . "/";
		$new_file_dir = $wp_upload_dir["basedir"] . "/site-thumb-cache/" . date("Y") . "/" . date("m") . "/";

		if (!is_dir($new_file_dir)) {mkdir($new_file_dir, 0755, true);}

		$file_name = wp_unique_filename($new_file_dir, "thumb.jpg");
		
		if($imagedata) {
			imagejpeg($imagedata, $new_file_dir . $file_name);	
		}
		if(is_resource($imagedata)) { 
			imagedestroy($imagedata); // free up memory (if done with it)
		}
		$thumb_url = $new_file_url . $file_name;
		*/
		
		$thumb_url = $full_url;
		$shortcode_html = "<img src='" . $thumb_url . "'></img>";
		return $shortcode_html;
	}
	
}