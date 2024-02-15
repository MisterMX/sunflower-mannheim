<?php

function shortcode_sunflower_social_media_icons_func( $atts ) {
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
add_shortcode( 'sunflower_social_media_icons', 'shortcode_sunflower_social_media_icons_func' );

function shortcode_sunflower_mailto_link( $atts ) {
    $attributes = shortcode_atts( array(
		'mailto' => "",
        "class" => "",
        "a_class" => "",
        "icon_class" => "mr-1 fa-solid fa-envelope"
	), $atts );

    $a_class = sprintf("d-flex gap-1 align-items-center text-decoration-none %s", $attributes["a_class"]);

    $result = sprintf("<p class=\"%s\"><a class=\"%s\" href=\"mailto:%s\"><i class=\"%s\"></i>%s</a></p>", $attributes["class"], $a_class, $attributes["mailto"], $attributes["icon_class"], $attributes["mailto"]);
    return $result;
}
add_shortcode( 'sunflower_mailto_link', 'shortcode_sunflower_mailto_link' );
