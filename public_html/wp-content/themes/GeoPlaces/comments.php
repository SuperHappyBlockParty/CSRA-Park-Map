<?php 
if(get_option('default_comment_status') == 'open'):
if ( comments_open() ) : ?>
<div class="comments">
  <?php if ( post_password_required() ) : ?>
  <p class="nopassword">
    <?php echo PASSWORD_PROTECT; ?>
  </p>
</div>
<!-- #comments -->
<?php  return; endif; ?>
<div id="comments">
  <?php if (have_comments()) : ?>
  <h3><?php printf(_n(__('1 Comment','templatic'), __('%1$s Comment','templatic'), get_comments_number()), number_format_i18n( get_comments_number() ), '' ); ?></h3>
  <div class="comment_list">
    <ol>
      <?php wp_list_comments(array('callback' => 'commentslist')); ?>
    </ol>
  </div>
  <?php endif; // end have_comments() ?>
</div>
<?php 
global $post,$wp_query;
$post = $wp_query->post;
$comment_add_flag =  is_user_can_add_comment($post->ID);
if($comment_add_flag)
{
	_e('<h6>Review has already been inserted from this machine. So no other reviews are allowed from this machine on this post.</h6>');	
}
?>
<?php if ('open' == $post->comment_status && !$comment_add_flag) : ?>
<div id="respond">
  <h3><?php echo POST_REVIEW;?></h3>
  <div class="comment_form">
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p class="comment_message"><?php echo YOU_MUST;?> <a href="<?php echo get_option('home'); ?>/?ptype=login"><?php echo LOGGED_IN;?></a> <?php echo POST_COMMENT;?></p>
    <?php else : ?>
    <form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php global $post;
	if(get_option('ptthemes_disable_rating') == 'no' && ($post->post_type == CUSTOM_POST_TYPE1 || $post->post_type == CUSTOM_POST_TYPE2)){ ?> 
		 <span class="rating_text"><?php echo RATING_MSG;?> </span>
         <p class="commpadd"><span class="comments_rating"> <?php require_once (get_template_directory() . '/library/rating/get_rating.php');?> </span> </p>
		<?php	} ?>
      <?php if ( $user_ID ) : 
	   global $current_user;
		$user_link = get_author_posts_url($user_ID);
		if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
	  ?>
      <p class="comment_message"><?php echo LOGGED_AS;?> <a href="<?php echo str_replace(' ','-',$user_link); ?>"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo LOGOUT;?></a></p>
      
      
      <p class="commpadd clearfix commform-textarea">
				<label for="comment"><?php echo REVIEW;?></label>
				<textarea name="comment" id="comment" cols="50" rows="7" tabindex="1"></textarea>
			</p>
     
            
      <?php else : ?>
       
      
       <p class="commpadd clearfix">
                <label for="author"><?php echo NAME;?> <small class="author">*</small></label>
                <input type="text" name="author" id="author" tabindex="2" value="" onfocus="if (this.value == 'Your name') {this.value = '';}" PLACEHOLDER="<?php echo CMT_YOUR_NAME; ?>" />
            </p>
            
            <p class="commpadd clearfix">
                <label for="email"><?php echo EMAIL;?> <small class="email2">*</small></label>
                 <input type="text" name="email" id="email" tabindex="3" value="" PLACEHOLDER="<?php echo CMT_EMAIL_TEXT; ?>" />
            </p>
            
            <p class="commpadd clearfix">
                <label for="url"><?php echo WEBSITE;?></label>
                 <input type="text" name="url" id="url" tabindex="4" value="" PLACEHOLDER="<?php echo WEBSITE_TEXT; ?>"/>
            </p>
            
            <p class="commpadd clearfix commform-textarea">
				<label for="comment"><?php echo REVIEW;?></label>
				<textarea name="comment" id="comment" cols="50" tabindex="5" rows="7"  PLACEHOLDER="<?php echo COMMENT; ?>"></textarea>
			</p>
            
      
      
      <?php endif; ?>
      <div class="submit clear">
        <input name="submit" type="submit" id="submit" tabindex="6" value="<?php echo SUBMIT;?>" />
        <p id="cancel-comment-reply">
          <?php cancel_comment_reply_link() ?>
        </p>
      </div>
      <div>
        <?php comment_id_fields(); ?>
        <?php //do_action('comment_form', $post->ID); ?>
      </div>
    </form>
    <?php endif; // If registration required and not logged in ?>
  </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
<?php if(!$comment_add_flag) { ?>
</div>
<?php } ?>
<?php endif; // end ! comments_open() ?>
<?php endif; // end ! get_option('default_comment_status') ?>
<!-- #comments -->
