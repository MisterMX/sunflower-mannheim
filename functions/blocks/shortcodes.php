<?php

function sunflower_social_media_icons_func( $atts ) {
    $attributes = shortcode_atts( array(
		'wrapper_element' => "p",
		'wrapper_class' => "has-medium-font-size is-layout-flex justify-content-around",
        'links' => ""
	), $atts );

    $result = "";
    $result .= sprintf("<%s class=\"%s\">", $attributes["wrapper_element"], $attributes["wrapper_class"]);

    $exp = "/{(.*)}/i";
    preg_match_all($exp, $attributes["links"], $entries);
    foreach ($entries[1] as &$entry) {
        $line_attrs = explode("|", $entry);
        if ( count($line_attrs) < 3 ) {
            continue;
        }
        $result .= sprintf(
            "<a href=\"%s\" target=\"_blank\" rel=\"noopener\" class=\"%s\"><i class=\"%s\"></i></a>",
            $line_attrs[0],
            $line_attrs[1],
            $line_attrs[2]
        );
    }
    $result .= sprintf("</%s>", $attributes['wrapper_element']);
    return $result;
}
add_shortcode( 'sunflower_social_media_icons', 'sunflower_social_media_icons_func' );
