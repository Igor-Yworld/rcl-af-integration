<?php

require_once('settings.php');

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_asgaros_scripts',10);
endif;
function rcl_asgaros_scripts(){
    rcl_enqueue_style('rcl-asgaros',rcl_addon_url('style.css', __FILE__));
}
add_action('plugins_loaded', 'rcl_asgaros_load_plugin_textdomain',10);
function rcl_asgaros_load_plugin_textdomain(){
    load_textdomain( 'rcl-asgaros', rcl_addon_path(__FILE__) . '/languages/rcl-asgaros-'. get_locale() . '.mo' );
}
/* регистрация рейтинга постов на форуме */
if(!is_admin()) add_action('init','rcl_register_rating_forum_type');
if(is_admin()) add_action('admin_init','rcl_register_rating_forum_type');
function rcl_register_rating_forum_type(){
	global $active_addons;
	if(!$active_addons['rating-system']) return false;
        rcl_register_rating_type(array('rating_type'=>'forum-page','type_name'=>'Форум','style'=>true,'icon'=>'fa-user'));
}
/* рейтинг лайк в посте */
add_action('asgarosforum_after_post_message', 'my_function_rating', 10, 2);
function my_function_rating($author_id, $author_posts) {
	global $active_addons;
	if(!$active_addons['rating-system']) return false;
	$object_id = $author_posts;
	echo '<div class="rating-post rating-header">'.rcl_get_html_post_rating($object_id,'forum-page',$author_id).'</div>';
	
}
/* Общий рейтинг */
add_action('asgarosforum_after_post_author', 'my_function_asgaros_recall_rating', 20, 1);
function my_function_asgaros_recall_rating($author_id) {
	$user_info = get_userdata($author_id);
    global $active_addons;
	if(!$active_addons['rating-system']) return false;
	echo '<span title="'.__('Rating','rcl-asgaros').'"><span>'.rcl_rating_block(array('value'=>rcl_get_user_rating($author_id))).'</span></span>';
		
}

// Звание на форуме, зависят от количества постов.
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_author_rank', 10, 5);
function my_asgarosforum_after_post_author_rank($author_id, $author_posts) {
global  $rcl_options;
	$rank1 = $rcl_options['amount1_posts']; $rank2 = $rcl_options['amount2_posts']; $rank3 = $rcl_options['amount3_posts']; $rank4 = $rcl_options['amount4_posts']; $rank5 = $rcl_options['amount5_posts']; $rank6 = $rcl_options['amount6_posts'];
  if (($author_posts > $rank1) && ($author_posts <= $rank2)){
    echo '<span class="'.$rcl_options['afrcl_rank_enable'].'"><div class="status-author-rating">'.$rcl_options['rank1_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank2) && ($author_posts <= $rank3)) {
    echo '<span class="'.$rcl_options['afrcl_rank_enable'].'"><div class="status-author-rating">'.$rcl_options['rank2_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank3) && ($author_posts <= $rank4)) {
    echo '<span class="'.$rcl_options['afrcl_rank_enable'].'"><div class="status-author-rating">'.$rcl_options['rank3_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank4) && ($author_posts <= $rank5)) {
    echo '<span class="'.$rcl_options['afrcl_rank_enable'].'"><div class="status-author-rating">'.$rcl_options['rank4_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></span>';
  }
  else if (($author_posts > $rank5) && ($author_posts >= $rank6)) {
    echo '<span class="'.$rcl_options['afrcl_rank_enable'].'"><div class="status-author-rating">'.$rcl_options['rank6_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></span>';
  }
}
// Звание на форуме, зависят от рейтинга.
add_action('asgarosforum_after_post_author', 'asgarosforum_after_author_rating', 10, 5);
function asgarosforum_after_author_rating($author_id, $author_posts) {
global  $rcl_options;
if(rcl_exist_addon('rating-system')){
    $author_posts = rcl_get_user_rating($author_id);
	$rank_rating1 = $rcl_options['author_rating_1']; $rank_rating2 = $rcl_options['author_rating_2']; $rank_rating3 = $rcl_options['author_rating_3']; $rank_rating4 = $rcl_options['author_rating_4']; $rank_rating5 = $rcl_options['author_rating_5']; $rank_rating6 = $rcl_options['author_rating_6'];
  if (($author_posts > $rank_rating1) && ($author_posts <= $rank_rating2)){
    echo '<span class="'.$rcl_options['afrcl_rank_rating_enable'].'"><div class="status-author-rating">'.$rcl_options['rank1_rating_forum'].'&nbsp;<i class="fa '.$rcl_options['rank_rating_icon1'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank_rating2) && ($author_posts <= $rank_rating3)) {
    echo '<span class="'.$rcl_options['afrcl_rank_rating_enable'].'"><div class="status-author-rating">'.$rcl_options['rank2_rating_forum'].'&nbsp;<i class="fa '.$rcl_options['rank_rating_icon2'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank_rating3) && ($author_posts <= $rank_rating4)) {
    echo '<span class="'.$rcl_options['afrcl_rank_rating_enable'].'"><div class="status-author-rating">'.$rcl_options['rank3_rating_forum'].'&nbsp;<i class="fa '.$rcl_options['rank_rating_icon3'].'"></i></div></span>';
  } 
  else if (($author_posts > $rank_rating4) && ($author_posts <= $rank_rating5)) {
    echo '<span class="'.$rcl_options['afrcl_rank_rating_enable'].'"><div class="status-author-rating">'.$rcl_options['rank4_rating_forum'].'&nbsp;<i class="fa '.$rcl_options['rank_rating_icon4'].'"></i></div></span>';
  }
  else if (($author_posts > $rank_rating5) && ($author_posts >= $rank_rating6)) {
    echo '<span class="'.$rcl_options['afrcl_rank_rating_enable'].'"><div class="status-author-rating">'.$rcl_options['rank6_rating_forum'].'&nbsp;<i class="fa '.$rcl_options['rank_rating_icon6'].'"></i></div></span>';
  }
 }
}
/* Модератор, администратор, остальные участники форума, зависит от званий на сайте, прогресс бар */
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_administration', 10, 2);
function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_asgarosforum_after_post_administration($author_id, $author_posts) {
global  $rcl_options;
/* Иконки и ссылки */
    echo '<div class="'.$rcl_options['afrcl_progress_enable'].'"><div class="star"><progress class="progress" value="'.$author_posts.'" max="'.$rcl_options['progress_number'].'"></progress><span><i class="fa '.$rcl_options['progress_icon1'].'"></i>&nbsp;<i class="fa '.$rcl_options['progress_icon2'].'"></i>&nbsp;<i class="fa '.$rcl_options['progress_icon3'].'"></i>&nbsp;<i class="fa '.$rcl_options['progress_icon4'].'"></i><i class="fa '.$rcl_options['progress_icon6'].'"></i>'.$rcl_options['progress_goal'].'</span></div></div>';
if (getUserRoles($author_id)=='administrator') {
    echo '<div class="'.$rcl_options['afrcl_roles_enable'].'"><div class="icon-status-admin">'.$rcl_options['admin_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></div>';
  } else {
    if (AsgarosForumPermissions::isModerator($author_id)) {
    echo '<div class="'.$rcl_options['afrcl_roles_enable'].'"><div class="icon-status-moderator">'.$rcl_options['moderator_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></div>';
  } else {
	if(getUserRoles($author_id)=='contributor') {
	echo '<div class="'.$rcl_options['afrcl_roles_enable'].'"><div class="icon-status-contributor">'.$rcl_options['contributor_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></div>';
	} else {
	if(getUserRoles($author_id)=='author') {
	echo '<div class="'.$rcl_options['afrcl_roles_enable'].'"><div class="icon-status-author">'.$rcl_options['author_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></div>';
} else {
	if(getUserRoles($author_id)=='editor') {
	echo '<div class="'.$rcl_options['afrcl_roles_enable'].'"><div class="icon-status-editor">'.$rcl_options['editor_forum'].'<i class="'.$rcl_options['icon_role'].'"></i></div></div>';};
           }	
         }
      }
    }
 }
 /* Модератор, администратор, редактор, автор, пользователь - картинка вместо роли*/
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_administration_img', 10, 2);

function my_asgarosforum_after_post_administration_img($author_id, $author_posts) {
global  $rcl_options;
/* Иконки и ссылки */
if (getUserRoles($author_id)=='administrator') {
    echo '<div class="'.$rcl_options['afrcl_roles_img_enable'].'"><div class="status-admin-img"><img src="'.wp_get_attachment_image_url( $rcl_options['admin_forum_img'], 'full' ).'" width="110" height="24" alt=""></div></div>';
  } else {
    if (AsgarosForumPermissions::isModerator($author_id)) {
    echo '<div class="'.$rcl_options['afrcl_roles_img_enable'].'"><div class="status-moderator-img"><img src="'.wp_get_attachment_image_url( $rcl_options['moderator_forum_img'], 'full' ).'" width="110" height="24" alt=""></div></div>';
  } else {
	if(getUserRoles($author_id)=='contributor') {
	echo '<div class="'.$rcl_options['afrcl_roles_img_enable'].'"><div class="status-contributor-img"><img src="'.wp_get_attachment_image_url( $rcl_options['contributor_forum_img'], 'full' ).'" width="110" height="24" alt=""></div></div>';
	} else {
	if(getUserRoles($author_id)=='author') {
	echo '<div class="'.$rcl_options['afrcl_roles_img_enable'].'"><div class="status-author-img"><img src="'.wp_get_attachment_image_url( $rcl_options['author_forum_img'], 'full' ).'" width="110" height="24" alt=""></div></div>';
} else {
	if(getUserRoles($author_id)=='editor') {
	echo '<div class="'.$rcl_options['afrcl_roles_img_enable'].'"><div class="status-editor-img"><img src="'.wp_get_attachment_image_url( $rcl_options['editor_forum_img'], 'full' ).'" width="110" height="24" alt=""></div></div>';};
           }	
         }
      }
    }
 }
/* ссылки и иконки в кабинет */
add_action('asgarosforum_after_post_author', 'my_function_asgaros_cabinet', 30, 1);
function my_function_asgaros_cabinet($author_id) {
global  $rcl_options;    
	$user_info = get_userdata($author_id);
	echo '<a href="'.get_author_posts_url($author_id).'" title="'.__('Profile','rcl-asgaros').'"><i class="fa fa-user"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'chat').'" title="'.__('Private message','rcl-asgaros').'"><i class="fa fa-comment"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'recall').'" title="'.__('Reviews','rcl-asgaros').'"><i class="'.$rcl_options['icon_enable_recall'].'"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'groups').'" title="'.__('Groups','rcl-asgaros').'"><i class="'.$rcl_options['icon_enable_groups'].'"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'publics').'" title="'.__('Publications','rcl-asgaros').'"><i class="'.$rcl_options['icon_enable_publics'].'"></i></a></span>';
/* статус онлайн/офлайн */	
	$action = rcl_get_time_user_action($author_id); echo '<div class="'.$rcl_options['of_onlin'].'"><div class="status-forum-online">'.rcl_get_miniaction($action).'</div></div>';
/* дата регитсрации */
$user_info = get_userdata($author_id);
$registered = $user_info->user_registered;
echo '<div class="'.$rcl_options['information_enable_recall'].'"><details class="details">
    <summary>'.__('Information','rcl-asgaros').'</summary><div class="data-registered">'.__('Registration','rcl-asgaros').':<br/>'.date("j.n.Y", strtotime($registered)).'</div>';

/* локация */	
	if(function_exists('ucc_get_value'))
	{
		echo '<div class="ucc-cou-siti">'.ucc_get_value($author_id).'</div>';
		}
/* Соц ссылки */		
if(function_exists('get_slink_rcl'))
	{
		echo '<div class="soc-link">'.get_slink_rcl($author_id).'</div>';
		}	
}
/* Дополнительное поле 1 в зоне аватара*/
add_action('asgarosforum_after_post_author', 'my_function_afrcl_field_name_1', 40, 1);
function my_function_afrcl_field_name_1($author_id) {
global  $rcl_options;
echo '<div class="'.$rcl_options['afrcl_field_name_enable'].'">'.$rcl_options['afrcl_field_name_1'].'</div>';
	
}
add_action('asgarosforum_after_post_author', 'my_function_afrcl_field_1', 40, 1);
function my_function_afrcl_field_1($author_id) {
global  $rcl_options;
echo '<div class="'.$rcl_options['afrcl_field_name_enable'].'">'.get_user_meta($author_id,$rcl_options['afrcl_field_1'],1).'</div></details></div>';
	
}
/* объявление пользователя на форуме */
add_action('asgarosforum_after_post_author', 'my_function_announcement', 50, 1);
function my_function_announcement($author_id) {
global  $rcl_options;
echo '<p><div class="'.$rcl_options['afrcl_announcement_enable'].'"><a href="#modal'.$author_id.'" class="button openModal">'.$rcl_options['announcement_title'].'&nbsp;<i class="fa '.$rcl_options['announcement_img'].'" aria-hidden="true"></i></a></p>';
echo '<div id="modal'.$author_id.'" class="modal">
<div>
<!--noindex--><div>'.get_user_meta($author_id,$rcl_options['announcement'],1).'</div><!--/noindex-->
<a href="#close" title="Закрыть">Закрыть</a></div></div>	
</div>';
}
/* подпись на форуме при использовании произвольного поля в профиле */
add_action('asgarosforum_after_post_message', 'my_function_signature', 10, 1);
function my_function_signature($author_id) {
global  $rcl_options;
echo '<div class="'.$rcl_options['afrcl_signature_enable'].'">'.get_user_meta($author_id,$rcl_options['signature'],1).'</div>';
	
}
