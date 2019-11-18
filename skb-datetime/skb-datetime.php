<?php

function skb_datetime_shortcode($atts) {
	global $skb_options;

	ob_start();

	if($skb_options['skb_enable_datetime'] === 'true') {
		$a = shortcode_atts( array(
			'date'						=> 'today',
			'time'						=> 'now',
			'date_format'			=> 'default',
			'time_format'			=> 'default',
			'order'						=> 'date,time',
			'separator'				=> '&nbsp;',
			'bold_date'				=> 'false',
			'bold_time'				=> 'false',
			'bold_all'				=> 'false'
		), $atts );

		$order = explode(",", $a['order']);

		$date_format = $skb_options['skb-dt-default_date_format'];
		$time_format = $skb_options['skb-dt-default_time_format'];

		if($a['date_format'] !== 'default' && $a['date_format'] != $date_format) {
			$date_format = $a['date_format'];
		}

		if($a['time_format'] !== 'default' && $a['time_format'] != $time_format) {
			$time_format = $a['time_format'];
		}

		$today = date($date_format);
		$now = date($time_format);

		$date = $a['date']; $time = $a['time'];

		if($a['date'] != 'today' && $a['date'] != 'false') {
			$date = date($date_format, strtotime($a['date']));

		} elseif($a['date'] != 'false' && $a['date'] == 'today') {
			$date = $today;

		} else {
			$date = NULL;

		}

		if($a['time'] != 'now' && $a['time'] != 'today' && $a['time'] != 'false') {
			$time = date($time_format, strtotime($a['time']));

		} elseif($a['time']!= 'false' && $a['time'] == 'now') {
			$time = $now;

		} else {
			$time = NULL;
		}

		$separator = $a['separator'];
		if($separator != '' && $separator != '&nbsp;') {
			$separator = str_pad($separator, strlen($separator) + 2, " ", STR_PAD_BOTH);
		}

		if($a['bold_date'] == 'true' && $date !== NULL) { $date = "<strong>{$date}</strong>"; }
		if($a['bold_time'] == 'true' && $time !== NULL) { $time = "<strong>{$time}</strong>"; }

		$content = "";
		if($date !== NULL && $time !== NULL) {
			if($order[0] === 'date') {
				$content .= "{$date}{$separator}{$time}";

			} else {
				$content .= "{$time}{$separator}{$date}";

			}
		} elseif($date !== NULL) {
			$content .= "{$date}";

		} elseif($time !== NULL) {
			$content .= "{$time}";
		}

		if($a['bold_all'] == 'true') { $content = "<strong>{$content}</strong>"; }

		echo $content;

	} else {
		echo "<p>skb_datetime shortcode not enabled</p>";
	}

	return ob_get_clean();
}
add_shortcode('skb_datetime', 'skb_datetime_shortcode');