<?php

// From https://wordpress.stackexchange.com/a/10708
// Added skb_ prefix as a precaution
function skb_get_page_by_slug($page_slug, $post_type = 'page', $output = OBJECT ) {
    global $wpdb;
    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
    if ( $page )
      return get_page($page, $output);
    return null;
}

function skb_make_virtual_pages() {

	require_once(SKB_ROOTDIR ."skb-butterflies/skb-butterflies.apclass.php");
	require_once(SKB_ROOTDIR ."skb-butterflies/skb.vp.php");

	$butterflies_conn = new SKB_AirtableConnection();
	$skb_butterflies = $butterflies_conn->getAllRecords(true);

	foreach($skb_butterflies as $butterfly) {
		$name = ucwords($butterfly['Common Name']);

		$content = "[skb_breadcrumbs parent_title='Butterflies' parent_url='butterflies']";
		
		$images = array();
		if( array_key_exists("Photo", $butterfly) ) {
	
			foreach($butterfly['Photo'] as $index=>$photo) {
				$i = $index + 1;
				
				$img = '<img src="'. $photo .'" alt="'. $butterfly['Common Name'] .' Photo #'. $i .'">';
				array_push($images, $img);

			}

			$content .= "<div class='skb-butterflies--single-gallery'>". implode("", $images) ."</div>";
		}
		$content .= "<p class='common-name'><strong>{$butterfly['Common Name']}</strong><br>";
		$content .= "<span class='genus-species'><em>{$butterfly['Genus']} {$butterfly['Species']}</em></span></p>";
		$content .= "<p class='region'><strong>Region:</strong> {$butterfly['Region']}</p>";
		$content .= "<h4>Fun Facts</h4><p>{$butterfly['Fun Facts']}</p>";
		$content .= "<h4>Colors</h4><p>{$butterfly['Colors']}</p>";
		$content .= "<h4>Markings</h4><p>{$butterfly['Markings']}</p>";
		$content .= "<h4>Shape</h4><p>{$butterfly['Shape']}</p>";

		$vp_args = array('slug' => $butterfly['slug'], 'parent' => 'butterflies', 'page_title' => $butterfly['Common Name'], 'page_content' => $content);

		$post = new WP_EX_PAGE_ON_THE_FLY($vp_args);

	}
}
skb_make_virtual_pages();

// function skb_get_butterfly($key,$value) {
// 	global $skb_butterflies_query;

// 	$collection = new AirpressCollection($skb_butterflies_query);
// 	$butterfly = $collection->lookup($key, $value);

// 	return (array)$butterfly;
// }

// function skb_butterflies_rewrites($id) {
// 	global $wp, $butterflies;
// 	$wp->add_query_var( 'map' );

// 	add_rewrite_rule( $id, , 'top' );
// }