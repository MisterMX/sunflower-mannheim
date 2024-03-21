<?php
/**
 * Template part for displaying events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sunflower
 */

?>

<?php
    $tags = wp_get_object_terms(get_the_ID(), 'sunflower_event_tag');
$tag_list = [];
foreach ($tags as $tag) {
    $tag_list[$tag->slug] = $tag->name;
}
?>

<a href="<?php echo esc_url(get_permalink()); ?>" class="event-card <?php echo implode(' ', array_keys($tag_list)); ?>" rel="bookmark">
<article id="post-<?php the_ID(); ?>" <?php post_class('event has-shadow'); ?>>
	<div class="p-4">
		<?php
         [$weekday, $days, $time] = sunflower_prepare_event_time_data($post);

$from = strToTime((string) get_post_meta($post->ID, '_sunflower_event_from')[0]);
$attribute = date('Y-m-d H:i', $from);

?>
		<div class="event-archive-meta">
			<div class="text-uppercase small"><?php echo $weekday; ?></div>
			<div class="date">
				<time datetime="<?php echo $attribute; ?>">
					<?php echo $days . (empty($time) ? '' : ' <span class="small">' . $time . ' ' . __("o'clock", 'sunflower') . '</span>'); ?>
				</time>
			</div>
			<div class="fst-italic small">
				<?php
            echo implode(' | ', $tag_list);
?>
			</div>
		</div>

		<div class="mt-2">
			<header class="entry-header pt-2 pb-2">
				<?php
    the_title('<strong class="h2">', '</strong>');
?>
			</header><!-- .entry-header -->


			<div class="entry-content">
				<?php
the_excerpt(
    sprintf(
        wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'sunflower'),
            [
                'span' => [
                    'class' => [],
                ],
            ]
        ),
        wp_kses_post(get_the_title())
    )
);
?>
			</div><!-- .entry-content -->

		</div>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
</a>
