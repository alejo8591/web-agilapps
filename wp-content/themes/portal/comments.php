<?php
/**
 * @package WordPress
 * @subpackage Portal Theme
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>

<div id="comments" class="comments">
<?php if ( have_comments() ) : ?>

	<h3 class="block color_default margin-bottom40 margin-top60"><?php echo ( get_comments_number() == 1 ? '1 ' . __('Comment', 'portal') : get_comments_number() . ' ' . __('Comments', 'portal') ); ?></h3>

	<?php if ( post_password_required() ) : ?>
		<div class="nopassword">
			<?php _e( 'This post is password protected. Enter the password to view any comments.', 'portal' ); ?>
		</div>
	<?php return; endif;?>

	<ul id="comments_wrapper">
		<?php wp_list_comments( array( 'callback' => 'portal_comment' ) ); ?>
	</ul>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below">
		<div class="nav-previous">
			<?php previous_comments_link( __( '&larr; Older Comments', 'portal' ) ); ?>
		</div>
		<div class="nav-next">
			<?php next_comments_link( __( 'Newer Comments &rarr;', 'portal' ) ); ?>
		</div>
	</nav>
	<?php
		endif;
		endif;
		if ( comments_open() ) :
	?>
		<div class="comment_form margin-bottom40">
		<?php
			$fields =  array(
				'author' =>'<input id="author" class="input_field block margin-bottom20" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __( 'NAME', 'portal' ) . '" />',

				'email' => '<input id="email" class="input_field block margin-bottom20" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'EMAIL', 'portal' ) . '"/>',

				'url' => '<input id="url" class="input_field block margin-bottom20" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'WEB', 'portal' ) . '" />'
			);
			comment_form( array('fields'=>$fields, 'comment_field' => '<textarea id="comment" name="comment" maxlength="300" class="textarea_field block margin-bottom20" aria-required="true">' . __( 'MESSAGE GOES HERE (MAX 300 CHARS)', 'portal' ) . '</textarea>', 'title_reply' => __( 'Send Us A Message Here', 'portal' ), 'title_reply_to' => __( 'Leave a Reply to %s' , 'portal' ), 'label_submit' => __( 'Send', 'portal' )));
			?>
			<div class="clearfix"></div>
		</div>
			<div class="clearfix"></div>
<?php
	endif;
?>

</div>