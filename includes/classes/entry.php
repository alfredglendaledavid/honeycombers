<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HC_Entry {
	public function __construct() {

		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'wp', array($this, 'init') );

	}

	public function init() {

		global $post;

		if( !is_singular('post') )
			return;

		add_filter( 'body_class', array($this, 'body_class') );

		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

		add_action( 'genesis_entry_header', array($this, 'display_header'), 12 );

		$this->header_type = get_post_meta( $post->ID, '_hc_post_header_type', true );
		$this->header_type = !empty($this->header_type) ? $this->header_type : 'default';
		switch( $this->header_type ) {
			case 'default':
				add_action( 'genesis_entry_content', array($this, 'display_excerpt'), 8 );
				break;
			case 'slideshow':
				add_action( 'genesis_after_header', array($this, 'display_slideshow'), 14 );
				break;
			case 'video':
				add_action( 'genesis_entry_content', array($this, 'display_video'), 8 );
				break;
		}

	}

	public function body_class( $classes ) {

		switch( $this->header_type ) {
			case 'default':
			case 'video':
				$classes[] = 'header-default';
				break;
			case 'slideshow':
				$classes[] = 'header-' . $this->header_type;
				break;
		}

		return $classes;

	}

	public function display_header() {

		global $post;
		
		$this->editorial_ad();

		switch( $this->header_type ) {
			case 'slideshow':
				?>
				<div class="clearfix inner">
					<div class="three-fifths first header-left">
						<?php genesis_do_post_title(); ?>

						<?php $this->display_excerpt(); ?>
					</div>

					<div class="two-fifths header-right clearfix">
						<div class="author header-top clearfix">
							<?php
							$user_id = get_the_author_meta( 'ID' );
							?>

							<div class="author-left">
								<?php echo get_avatar( $user_id, 85 ); ?>
							</div>

							<div class="author-right">
								<?php echo do_shortcode( '[post_author_posts_link]' ); ?>

								<?php

								$job_title = HC()->authors->get_title( $user_id );
								if( !empty($job_title) )
									echo '<p>' . $job_title . '</p>';
								?>
							</div>
						</div>

						<div class="share header-bottom">
							<?php HC()->folders->display_add_button( $post->ID ); ?>
							<?php HC()->share->display( $post->ID ); ?>
						</div>
					</div>
				</div>
				<?php
				break;
			default:
				genesis_do_post_title();

				?>
				<div class="entry-meta">
					<div class="author-share-row clearfix">
						<div class="left">
							<?php
							
							$blog_id = get_current_blog_id();
		
							if ( $blog_id != 6 ) {
					
								$lines   = array();
								$lines[] = do_shortcode( __( 'By', CHILD_THEME_TEXT_DOMAIN ) . ' [post_author_posts_link]' );
	
								$title = HC()->authors->get_title( $post->post_author );
								if( !empty($title) )
									$lines[] = $title;
	
								echo '<p>' . implode( ', ', $lines ) . '</p>';
							
							}
							?>

						</div>

						<div class="right">
							<?php HC()->folders->display_add_button( $post->ID ); ?>
							<?php HC()->share->display( $post->ID ); ?>
						</div>
					</div>
				</div>
				<?php

				if( 'default' === $this->header_type )	

					$this->display_image();

				break;
		}

	}

	public function display_slideshow() {

		$slides = get_field( '_hc_post_slides' );
		if( empty($slides) )
			return;

		?>
		<div class="entry-slideshow hide-no-js">
			<?php
			foreach( $slides as $slide ) {
				echo '<div>';
					$src = wp_get_attachment_image_src( $slide['ID'], 'full' );
					echo '<a href="' . $src[0] . '" class="entry-slideshow-item">';
						echo wp_get_attachment_image( $slide['ID'], 'featured' );
					echo '</a>';

					$image = get_post( $slide['ID'] );
					if( !empty($image->post_excerpt) ) {
						?>
						<div class="slide-content">
							<?php echo apply_filters( 'the_content', $image->post_excerpt ); ?>
						</div>
						<?php
					}
				echo '</div>';
			}
			?>
		</div>
		<?php

	}

	public function display_image() {

		global $post;

		?>
		<div class="featured-image-container">
			<?php
			$is_animated = get_post_meta( $post->ID, '_hc_image_is_animated', true );
			$image_size  = !empty($is_animated) ? 'full' : 'entry-image';

			$atts          = genesis_parse_attr( 'entry-image', array('alt' => get_the_title()) );
			$atts['class'] = 'alignnone';

			echo genesis_get_image(
				array(
					'format' => 'html',
					'size'   => $image_size,
					'attr'   => $atts,
				)
			);
			?>
            <?php if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
                <figcaption class="wp-caption-text"><?php echo $caption; ?></figcaption>
            <?php endif; ?>
		</div>
		<?php

	}

	public function display_excerpt() {

		global $post;

		?>
		<div class="entry-excerpt" itemprop="description">
			<?php echo '<p>' . HC()->formatting->get_excerpt($post, 0) . '</p>'; ?>
		</div>
		<?php

	}

	public function display_video() {

		global $post;

		$video_url = get_post_meta( $post->ID, '_hc_post_video_url', true );
		if( empty($video_url) )
			return;

		?>
		<div class="entry-video">
			<?php echo wp_oembed_get( $video_url ); ?>
		</div>
		<?php

	}
	
	public function get_headline_title( $post_id ) {

		$title = get_post_meta( $post_id, '_hc_headline_title', true );
		if( !empty($title) ) {
			return sanitize_text_field($title);
		} else {
			return get_the_title($post_id);
		}

	}
	
	
	public function editorial_ad() {
		
			$ed_posts = wp_most_popular_get_popular( array( 'limit' => 1, 'post_type' => 'post', 'range' => 'weekly' ) );

			if ( count( $ed_posts ) > 0 ): foreach ( $ed_posts as $ed_post ):
				setup_postdata( $ed_post );
				$posttitle = get_field('_hc_headline_title',$ed_post);
				?>
                
                <a href="<?php the_permalink($ed_post->ID); ?>" class="ed_ad_link">
                    <div class="ed_ad show-phone">
                        <div class="cat">
                            <span>TRENDING</span>
                        </div>
                        <div class="title">
                            <?php 
								if (strlen($posttitle) > 53) {
									$posttitle = substr($posttitle, 0, 52);
									echo $posttitle.'..';
								} else {
									$posttitle = get_field('_hc_headline_title',$ed_post);
									echo $posttitle;
								}
							
							 ?>
                        </div>
                        
                    </div>
                </a>
				<?php
			endforeach; endif; wp_reset_postdata();
			
	}
	
	

}

add_filter('the_content', 'mid_ad_content');

function mid_ad_content($content) {
	
	global $post;
	$edAd = get_field('_hc_editorial_ad_article', $post->ID );

    if (!is_single()) return $content;
    $paragraphAfter = 3; //Enter number of paragraphs to display ad after.
    $content = explode("</p>", $content);
    $new_content = '';
    for ($i = 0; $i < count($content); $i++) {
        if ($i == $paragraphAfter) {
				
				$short_title = get_field('_hc_headline_title', $edAd);
				if (empty($short_title)) {
					$the_title = get_the_title( $edAd );
				} else {
					$the_title = $short_title;
				}
				
				$primary_term = HC()->utilities->get_primary_term( $edAd, 'category' );
				$term_link = get_term_link( $primary_term );
				
				global $post;
				$article_type = get_field('_hc_post_is_sponsored',$post->ID);
				if (is_single()) {
					if( get_field('_hc_post_is_sponsored',$post->ID) )
						{
							$article = 'advertorial';
						}
						else
						{
							$article = 'editorial';
						}
				}
				
				if(in_category(array('')) && ($article !== 'advertorial')) {
					
                    if( have_rows('_hc_category_mid_banner','option') ):
                        while ( have_rows('_hc_category_mid_banner','option') ) :
                            the_row();
    
                            $head = get_sub_field('head_code');
                            $body = get_sub_field('body_code');
    
                            if( !empty($head) && !empty($body) )
								
                                $new_content.= "<div class='mid_banner'>";
								$new_content.= "<script>";
								$new_content.= $head;
								$new_content.= "</script>";
								$new_content.= $body;
								$new_content.= "</div>";
                        endwhile;
                    endif;
					
					

				} elseif(!empty($edAd) && !in_category(array(''))) {

					$new_content.= '<div class="mid_editorial_ad">';
					$new_content.= '<div class="left"><a href="'.get_permalink($edAd).'" class="mid_ad_link">'.get_the_post_thumbnail( $edAd, 'archive').'</a></div>';
					$new_content.= '<div class="right"><div class="cat"><a href="'.esc_url( $term_link ).'" class="mid_ad_link">'.$primary_term->name.'</a></div><a href="'.get_permalink($edAd).'" class="mid_ad_link"><div class="title">'.$the_title.'</a></div></div>';
					$new_content.= '</div>';
				
				}

        }

        $new_content.= $content[$i] . "</p>";
    }

    return $new_content;
}

return new HC_Entry();
