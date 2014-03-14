<?php
	$sidebar = get_post_meta( get_the_ID(), 'portal_post_sidebar', true );
?>
<div class="col-md-4">
	<div class="sidebar_wrap margin-left20">
	<?php dynamic_sidebar( $sidebar ); ?>
	</div>
</div>