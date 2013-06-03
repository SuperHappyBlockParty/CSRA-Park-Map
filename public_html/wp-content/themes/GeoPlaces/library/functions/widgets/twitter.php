<?php
/*
 * Create the templatic twiter post widget
 */	

// Display Twitter messages
function templatic_twitter_messages($options) {
	
	// CHECK OPTIONS
	
	if ($options['username'] == '') {
		return __('Twitter username not configured','templatic');
	} 
	
	if (!is_numeric($options['num']) or $options['num']<=0) {
		return __('Number of tweets not valid','templatic');
	}

	// SET THE NUMBER OF ITEMS TO RETRIEVE - IF "SKIP TEXT" IS ACTIVE, GET MORE ITEMS
	$max_items_to_retrieve = $options['num'];
	if ($options['skip_text']!='') {
		$max_items_to_retrieve *= 3;
	}
	
	// USE TRANSIENT DATA, TO MINIMIZE REQUESTS TO THE TWITTER FEED
	
	$timeout = 30 * 60; //30m
	$error_timeout = 5 * 60; //5m
	$no_cache_timeout = 60 * 60 * 24 * 365 * 10; //10 years should be fine...
	
	$transient_name = 'twitter_data_'.$options['username'].$options['skip_text'].'_'.$options['num'];
    
    $twitter_data = get_transient($transient_name);
    $twitter_status = get_transient($transient_name."_status");
    
	// Twitter Status
    if(!$twitter_status || !$twitter_data) {
        $json = wp_remote_get('http://api.twitter.com/1/account/rate_limit_status.json');
		$twitter_status = json_decode($json['body'], true);
        
		set_transient($transient_name."_status", $twitter_status, $no_cache_timeout);
    }
	//echo "<!-- Twitter status: ".print_r($twitter_status,true)." -->";
    $reset_seconds = (strtotime($twitter_status['reset_time'])-time());
    
    
	// Tweets
	if (!$twitter_data) {

		//echo "\n<!-- Fetching data from Twitter... -->";                            /* Debug Stuff */
		
		if($twitter_status['remaining_hits'] <= 7) {
		    $timeout = $reset_seconds;
		    $error_timeout = $timeout;
		}		
	    
        
		$json = wp_remote_get('http://api.twitter.com/1/statuses/user_timeline.json?screen_name='.$options['username'].'&count='.$max_items_to_retrieve);
 		if( is_wp_error( $json ) ) {
			return __('Error retrieving tweets','templatic');
		} else {
			$twitter_data = json_decode($json['body'], true);
                        
            if(!isset($twitter_data['error']) && (count($twitter_data) == $options['num']) ) {
			    set_transient($transient_name, $twitter_data, $timeout);
			    set_transient($transient_name."_valid", $twitter_data, $no_cache_timeout);
            } else {
			    set_transient($transient_name, $twitter_data, $error_timeout);	// Wait 5 minutes before retry
	            echo "\n<!-- Twitter error: ".$twitter_data['error']." -->";          /* Debug Stuff */
		    }
		}
	} else {		
		if(isset($twitter_data['error'])) {
	        echo "\n<!-- Twitter error: ".$twitter_data['error']." -->";              /* Debug Stuff */
		} 
	}
    
	$items_retrieved = count($twitter_data); 
    
	if (empty($twitter_data) and false === ($twitter_data = get_transient($transient_name."_valid"))) {
	    return __('No public tweets','templatic');
	}

	if (isset($twitter_data['errors'])) {
		// STORE ERROR FOR DISPLAY
		$twitter_error = $twitter_data['errors'];
	    if(false === ($twitter_data = get_transient($transient_name."_valid"))) {
			$debug = ($options['debug']) ? '<br /><i>Debug info:</i> ['.$twitter_error[0]['code'].'] '.$twitter_error[0]['message'].' - username: "'.$options['username'].'"' : '';
		    return __('Unable to get tweets'.$debug,'templatic');
		}
	}
	
	// SET THE MAX NUMBER OF ITEMS  
	$num_items_shown = $options['num'];
	if ($items_retrieved<$options['num']) {
		$num_items_shown = $items_retrieved;
	}
	
	$link_target = ($options['link_target_blank']) ? ' target="_blank" ' : '';
		
	$out = '<ul id="twitter_update_list" class="templatic_twitter_widget">';

	$i = 0;
	foreach($twitter_data as $message){
		if ($i>=$num_items_shown) {
			break;
		}
		$msg = $message['text'];
		$flag = 0;
		if(strpos($msg, "http://") !== false){
			$flag = 1;
			$mylink = explode("http",$msg);
		}
		if($flag==1){
			$subtract_link = explode(" ",$mylink[1]);
			$exact_link = 'http'.$subtract_link[0];
			$msg = substr($msg,0,strpos($msg, "http://"));
		}
		if ($options['skip_text']!='' and strpos($msg, $options['skip_text'])!==false) {
			continue;
		}
		$msg = utf8_encode($msg);
				
		$out .= '<li>';

		if ($options['hyperlinks']) { 
			// match protocol://address/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
			// match www.something.domain/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);    
			// match name@address
			$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
			//NEW mach #trendingtopics
			//$msg = preg_replace('/#([\w\pL-.,:>]+)/iu', '<a href="http://twitter.com/#!/search/\1" class="twitter-link">#\1</a>', $msg);
			//NEWER mach #trendingtopics
			$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/#!/search/%23\2" class="twitter-link" '.$link_target.'>#\2</a>', $msg);
		}
		if ($options['twitter_users'])  { 
			$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$link_target.">@$2</a>$3 ", $msg);
		}
          					
		$link = 'http://twitter.com/#!/'.$options['username'].'/status/'.$message['id_str'];
		if($options['linked'] == 'all')  { 
			$msg = '<a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$msg.'</a>';  // Puts a link to the status of each tweet 
		} else if ($options['linked'] != '') {
			$msg = $msg . ' <a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$options['linked'].'</a>'; // Puts a link to the status of each tweet
		} 
		$out .= $msg;
		if($flag==1){$out .= '<br/><a href="'.$exact_link.'" target="_blank" class="twitter-link" >'.$exact_link.'</a>';}
		$out .= '<span class="twit_time" style="display: block;">'.time_elapsed_string(strtotime($message['created_at'])).'</span>';
		$out .= '</li>';
		$i++;
	}
	$out .= '</ul>';
	
	if ($options['link_user']) {
		$out .= '<div class="rstw_link_user"><a href="http://twitter.com/' . $options['username'] . '" '.$link_target.'>'.$options['link_user_text'].'</a></div>';
	}
	
	return $out;
}

//Function to convert date to time ago format
//eg.1 day ago, 1 year ago, etc...
function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1) {
        return __('0 seconds','templatic');
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return __($r . ' ' . $str . ($r > 1 ? 's' : '').' ago','templatic');
        }
    }
}
//Function to convert date to time ago format


/**
 * templatic_twiter Class
 */
class templatic_twiter extends WP_Widget {
	private /** @type {string} */ $languagePath;

    /** constructor */
    function templatic_twiter() {
		$this->options = array(
			array(
				'name'	=> 'title',
				'label'	=> __( 'Title', 'templatic' ),
				'type'	=> 'text'
			),			
			array(
				'name'	=> 'username',
				'label'	=> __( 'Twitter Username', 'templatic' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'num',
				'label'	=> __( 'Show # of Tweets', 'templatic' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'follow_text',
				'label'	=> __( 'Twitter button text <small>(for eg. Follow us, Join me on Twitter, etc.)</small>', 'templatic' ),
				'type'	=> 'text'
			),			
			
			
		);

        $widget_ops = array('classname' => 'widget Templatic twitter', 'description' => __('Show your latest tweets on your site.') );
		$this->WP_Widget('templatic_twiter', __('T &rarr; Latest Twitter Feeds'), $widget_ops);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$username = apply_filters('widget_title', $instance['username']);
		$follow_text = apply_filters('widget_title', $instance['follow_text']);
		echo '<div id="twitter" style="margin:auto">';
		if ( $title ) {
			$title_icon = ($instance['title_icon']) ? '<img src="'.WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/twitter_small.png" alt="'.$title.'" title="'.$title.'" /> ' : '';
			if ( $instance['link_title'] === true ) {
				$link_target = ($instance['link_target_blank']) ? ' target="_blank" ' : '';
				echo $before_title . '<a href="http://twitter.com/' . $instance['username'] . '" class="twitter_title_link" '.$link_target.'>'. $title_icon . $instance['title'] . '</a>' . $after_title;
			} else {
				echo '<h3 class="i_twitter">' . $title_icon . $instance['title'] . '</h3>';
			}
		}
		echo templatic_twitter_messages($instance);
		if($follow_text){
            echo "<a href='http://www.twitter.com/$username/' title='$follow_text' class='b_twitter fr' target='_blank'>$follow_text</a>";
        }
		echo '</div>';
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		foreach ($this->options as $val) {
			if ($val['type']=='text') {
				$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
			} else if ($val['type']=='checkbox') {
				$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
			}
		}
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		if (empty($instance)) {
			$instance['title']			= __( 'Live Tweet', 'templatic' );			
			$instance['username']		= 'templatic';
			$instance['num']			= '5';			
			$instance['follow_text']	= __('Follow Us','templatic');
			
		}					
	
		foreach ($this->options as $val) {
			$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
			if ($val['type']=='separator') {
				echo '<hr />';
			} else if ($val['type']=='text') {
				echo '<p>'.$label.'<br />';
				echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
			} else if ($val['type']=='checkbox') {
				$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
				echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
			}
		}
	}

} // class templatic_twiter

// register templatic_twiter widget
add_action('widgets_init', create_function('', 'return register_widget("templatic_twiter");'));

?>