<div class="cpb-row  pad-bottom gutter side-left recipe-search" style="">
	<div class="cpb-row-inner">
		<div class="cpb-column  one small column-size-300" id="recipe-search-sidebar">
			
			<span class="recipe-search green-text text-uppercase"><b>Search Recipes</b></span>
			<?php

			// Get the category ID
			$cat_id = get_cat_ID( 'recipe' );

			// The standard search form
			$form = get_search_form( false );

			// Keep form results on this page
			$form = str_replace( 'action="' . esc_url( home_url( '/' ) ) . '"', '', $form );

			// Let's add a hidden input field
			$form = str_replace( '<input type="submit"', '<input type="hidden" name="cat" id="cat" value="' . $cat_id . '"><input class="recipe-search btn-blue text-uppercase" type="submit"', $form );

			// Display our modified form
			// phpcs:disable
			echo $form;
			// phpcs:enable

			$children = get_term_children( $cat_id, 'category' );
			if ( $children ) { ?>
				<label class="recipe-search green-text text-uppercase"><?php echo esc_html( get_cat_name( $cat_id ) ) ?> Categories</label>
				<ul class="list-style-none">
					<li><a href="<?php echo esc_url( get_permalink( get_queried_object_id() ) ) ?>">All</a>
					<?php
					foreach ( $children as $child ) {
						$child = get_category( $child );
						if ( $child->count > 0 ) {

							$active = ( strval( $child->cat_ID ) === $_GET['cat'] ) ? 'active' : '';

							echo '<li><a href="' . esc_url( get_permalink( get_queried_object_id() ) . '?cat=' . strval( $child->cat_ID ) ) . '" class="' . esc_attr( $active ) . '">' . esc_html( $child->name ) . '</a></li>';
						}
					} ?>
				</ul>
				<?php
			}
			?>
		</div>
		<div class="container recipe-results" style="">
			<div class="row">
			<?php

			//Update query if variables exist
			if ( isset( $_GET['cat'] ) ) {
				$query_args['category__and'] = $_GET['cat'];
			}
			if ( isset( $_GET['s'] ) ) {
				$query_args['s'] = $_GET['s'];
			}

			// The Query
			$the_query = new \WP_Query( $query_args );

			// Pagination fix
			$temp_query = $wp_query;
			$wp_query   = null;
			$wp_query   = $the_query;

			// The Loop
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post(); ?>

					<div class="recipe-result col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<a href="<?php the_permalink() ?>"><?php
							the_post_thumbnail() ?></a>
							<a href="<?php the_permalink() ?>"><b class="recipe-search green-text"> <?php the_title() ?></b></a>
							<?php the_excerpt(); ?>
					</div>
					<?php
				} ?>
				<div style="width:100%;">
					<br/>
					<div class="nav-previous alignleft"><?php previous_posts_link( 'Previous page' ); ?></div>
					<div class="nav-next alignright"><?php next_posts_link( 'Next page', $the_query->max_num_pages ); ?></div>
				</div>
				<?php

				// Reset main query object
				$wp_query = null;
				$wp_query = $temp_query;
			} else {
				echo 'No recipes match your search criteria. :(';
			}
			?>
			</div>
		</div>
	</div>
</div>
