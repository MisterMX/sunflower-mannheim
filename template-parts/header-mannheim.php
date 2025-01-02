<?php
/**
 * Mannheim Header
 *
 * @package sunflower
 */

?>
	<header class="fixed-top header-mannheim">
		<nav class="navbar navbar-expand-lg bg-white" role="navigation">
			<a class="img-container" href="<?php echo esc_url( get_home_url() ) ?>" rel="home" aria-current="page" title="<?php echo esc_attr( get_bloginfo( 'name' ) )?>">
				<img class="sunflower-logo" alt="Logo" src="<?php echo esc_attr( sunflower_parent_or_child( 'assets/img/sunflower.svg' ) ) ?>">
			</a>

			<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu-container" aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-times close"></i>
				<i class="fas fa-bars open"></i>
			</button>

			<div class="navbar-collapse collapse-horizontal" id="mainmenu-container">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'mainmenu',
							'menu_id'        => 'mainmenu',
							// 1 = no dropdowns, 2 = with dropdowns.
							'depth'          => 4,
							// we opened the <div> container already.
							'container'      => false,
							'menu_class'     => 'navbar-nav mr-auto',
							'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
							'walker'         => new WP_Bootstrap_Navwalker_Mannheim(),
						)
					);
				?>
			</div>
		</nav>
	</header>

<?php
class WP_Bootstrap_Navwalker_Mannheim extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth == 0) { // Only allow submenu at level 1
            $output .= '<div class="dropdown-menu-container"><div class="bg-img"></div><ul class="menu">';
        } elseif ($depth == 1) {
			$output .= '<div class="depth-1"><ul class="menu">';
		}
    }

    /**
     * Ends the list after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth == 0) {
            $output .= '</ul></div>';
        } elseif ($depth == 1) {
			$output .= '</ul></div>';
		}
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $classes[] = 'depth-0';
        }
        if ($depth > 2) return; // Skip levels greater than 1

		// Little hack to create title menu items
		$item_type = "a";
		if ($depth > 0 && $item->url == "#") {
			$item_type = "span";
			$classes[] = " nav-item-heading";
		}
        if ($item->url != "#") {
            $classes[] = " menu-item-link";
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= "<li{$id}{$class_names}>";

        $atts = [];
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';

        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $atts['href'] = !empty($item->url) ? $item->url : '';
            $atts['class'] = '';
            // $atts['data-bs-toggle'] = 'dropdown';
        } else {
            $atts['href'] = !empty($item->url) ? $item->url : '';
            $atts['class'] = '';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= " {$attr}=\"{$value}\"";
            }
        }

        $item_output = $args->before;
        $item_output .= "<{$item_type}{$attributes}>";
		if ($item->description != "") {
			$item_output .= sprintf( '<div class="nav-item-desc">%s</div>', $item->description );
		}
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= "</{$item_type}>";
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth <= 1) {
            $output .= "</li>\n";
        }
    }
}
