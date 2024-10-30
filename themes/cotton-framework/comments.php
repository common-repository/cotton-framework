<?php
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
if( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
	die ('Please do not load this page directly. Thanks!');
if( post_password_required() ) {
	echo "<p class='nocomments'>This post is password protected. Enter the password to view comments.</p>";
	return;
} // if
?>

<?php if( have_comments() ) : ?>
	<h3 class="comment-title"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to <?php the_title(); ?></h3>

	<ol class="comment-list">
		<?php wp_list_comments( array( 'type' => 'comment' ) ); ?>
	</ol>

	<div class="comment-navigation">
		<?php paginate_comments_links(); ?> 
	</div>
<?php endif; ?>


<?php if( comments_open() ) : ?>
<div class="comment-form" id="respond">
	<h3><?php comment_form_title( 'Leave a Comment', 'Leave a Reply to %s' ); ?></h3>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

			<?php if ( $user_ID ) : ?>
				<p id="comment-user">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
			<?php else : ?>
				<p id="comment-field-author">
					<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
					<label for="author">Name <?php if ($req) echo "(required)"; ?></label>
				</p>

				<p id="comment-field-email">
					<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
					<label for="email">E-mail (will not be published) <?php if ($req) echo "(required)"; ?></label>
				</p>

				<p id="comment-field-website">
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					<label for="url">Website</label>
				</p>
			<?php endif; ?>

		<p id="comment-allowed-html"><label for="comment">Allowed <acronym title="Hyper Text Markup Language">HTML</acronym> tags: <code><?php echo allowed_tags(); ?></code></label></p>
		<p id="comment-field-comment"><textarea name="comment" id="comment" rows="10" cols="130" tabindex="4"></textarea></p>

		<p id="comment-field-submiit"><input name="submit" type="submit" id="submit" tabindex="5" value="Submit <?php comment_form_title( 'Comment', 'Reply to %s' ); ?>" />
		<?php comment_id_fields(); ?>
		</p>
		<?php do_action('comment_form', $post->ID); ?>

		</form>
	<?php endif; ?>
</div>
<?php else: ?>
	<p class='nocomments'>Comments are closed.</p>
<?php endif; ?>