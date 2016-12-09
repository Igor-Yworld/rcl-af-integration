<?php
if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_asgaros_scripts',10);
endif;
function rcl_asgaros_scripts(){
    rcl_enqueue_style('rcl-rcl-asgaros',rcl_addon_url('style.css', __FILE__));
    
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
/* // Звание на форуме, зависят от количества постов. Раскомментировать если вам такое надо.
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_author_rank', 10, 5);
function my_asgarosforum_after_post_author_rank($author_id, $author_posts) {
	$rank1 = 10; $rank2 = 20; $rank3 = 30; $rank4 = 40; $rank5 = 50;
  if (($author_posts > $rank1) && ($author_posts < $rank2)){
    echo '<br />Участник';
  } 
  else if (($author_posts > $rank2) && ($author_posts < $rank3)) {
    echo '<br />Активист';
  } 
  else if (($author_posts > $rank3) && ($author_posts < $rank4)) {
    echo '<br />Завсегдатай';
  } 
  else if (($author_posts > $rank4) && ($author_posts < $rank5)) {
    echo '<br />Старожил';
  } else {
    echo '<div class="icon-status-contributor">Новичок&nbsp;<i class="fa fa-info-circle"></i></div>';
  }
} */
	
/* // Вывод роли пользователя, вариант из релизов до 1.0.4 . Расскоментировать и настроить как у вас было, если новый не устроит или нужен вывод еще ролей.
add_action('asgarosforum_after_post_author', 'my_function_asgaros_recall_roles', 10, 1);
function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_function_asgaros_recall_roles($author_id) {
	$user_info = get_userdata($author_id);
    if(getUserRoles($author_id)=='administrator') {echo '<div class="icon-status-admin">Админ&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='contributor') {echo '<div class="icon-status-contributor">Участник&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='author') {echo '<div class="icon-status-author">Модератор&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='editor') {echo '<div class="icon-status-editor">Редактор&nbsp;<i class="fa fa-info-circle"></i></div>';};
} */
//Модератор, администратор, остальные участники форума
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_administration', 10, 2);
function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_asgarosforum_after_post_administration($author_id, $author_posts) {
if (getUserRoles($author_id)=='administrator') {
    echo '<div class="icon-status-admin">'.__('Admin','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
    if (AsgarosForumPermissions::isModerator($author_id)) {
    echo '<div class="icon-status-moderator">'.__('Moderator','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
	if(getUserRoles($author_id)=='contributor') {
	echo '<div class="icon-status-contributor">'.__('Contributor','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
	} else {
	if(getUserRoles($author_id)=='author') {
	echo '<div class="icon-status-author">'.__('Author','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
} else {
	if(getUserRoles($author_id)=='editor') {
	echo '<div class="icon-status-editor">'.__('Editor','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';};	
           }	
         }
      }
    }
  }
/* ссылки и иконки в кабинет */
add_action('asgarosforum_after_post_author', 'my_function_asgaros_cabinet', 30, 1);
function my_function_asgaros_cabinet($author_id) {
	$user_info = get_userdata($author_id);
	echo '<a href="'.get_author_posts_url($author_id).'" title="'.__('Profile','rcl-asgaros').'"><i class="fa fa-user"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'chat').'" title="'.__('Private message','rcl-asgaros').'"><i class="fa fa-comment"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'recall').'" title="'.__('Reviews','rcl-asgaros').'"><i class="fa fa-trophy"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'groups').'" title="'.__('Groups','rcl-asgaros').'"><i class="fa fa-group"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'publics').'" title="'.__('Publications','rcl-asgaros').'"><i class="fa fa-book"></i></a></span>';
/* статус онлайн/офлайн */	
	$action = rcl_get_time_user_action($author_id); echo '<div class="status-forum-online">'.rcl_get_miniaction($action).'</div>';
/* локация */	
	if(function_exists('ucc_get_value'))
	{
		echo '<div class="ucc-cou-siti">'.ucc_get_value($author_id).'</div>';
		}
}
/* подпись на форуме при использовании произвольного поля в профиле */
add_action('asgarosforum_after_post_message', 'my_function_signature', 10, 1);
function my_function_signature($author_id) {
echo '<div class="signature">'.get_user_meta($author_id,'podpis_na_forume_tekst_html_zapreshhen_35',1).'</div>';
	
}
  } 
  else if (($author_posts > $rank4) && ($author_posts < $rank5)) {
    echo '<br />Старожил';
  } else {
    echo '<div class="icon-status-contributor">Новичок&nbsp;<i class="fa fa-info-circle"></i></div>';
  }
} */
	
/* // Вывод роли пользователя, вариант из релизов до 1.0.4 . Расскоментировать и настроить как у вас было, если новый не устроит или нужен вывод еще ролей.
add_action('asgarosforum_after_post_author', 'my_function_asgaros_recall_roles', 10, 1);

function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_function_asgaros_recall_roles($author_id) {
	$user_info = get_userdata($author_id);
    if(getUserRoles($author_id)=='administrator') {echo '<div class="icon-status-admin">Админ&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='contributor') {echo '<div class="icon-status-contributor">Участник&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='author') {echo '<div class="icon-status-author">Модератор&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='editor') {echo '<div class="icon-status-editor">Редактор&nbsp;<i class="fa fa-info-circle"></i></div>';};

} */

//Модератор, администратор, остальные участники форума
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_administration', 10, 2);

function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_asgarosforum_after_post_administration($author_id, $author_posts) {
if (getUserRoles($author_id)=='administrator') {
    echo '<div class="icon-status-admin">Админ&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
    if (AsgarosForumPermissions::isModerator($author_id)) {
    echo '<div class="icon-status-moderator">Модератор&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
	if(getUserRoles($author_id)=='contributor') {
	echo '<div class="icon-status-contributor">Участник&nbsp;<i class="fa fa-info-circle"></i></div>';
	} else {
	if(getUserRoles($author_id)=='author') {
	echo '<div class="icon-status-author">Автор&nbsp;<i class="fa fa-info-circle"></i></div>';
} else {
	if(getUserRoles($author_id)=='editor') {
	echo '<div class="icon-status-editor">Редактор&nbsp;<i class="fa fa-info-circle"></i></div>';};	
           }	
         }
      }
    }
  }
/* ссылки и иконки в кабинет */
add_action('asgarosforum_after_post_author', 'my_function_asgaros_cabinet', 30, 1);

function my_function_asgaros_cabinet($author_id) {
	$user_info = get_userdata($author_id);
	echo '<a href="'.get_author_posts_url($author_id).'" title="Профиль"><i class="fa fa-user"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'chat').'" title="Личное сообщение"><i class="fa fa-comment"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'recall').'" title="Отзывы"><i class="fa fa-trophy"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'groups').'" title="Группы"><i class="fa fa-group"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'publics').'" title="Публикации"><i class="fa fa-book"></i></a></span>';
/* статус онлайн/офлайн */	
	$action = rcl_get_time_user_action($author_id); echo '<div class="status-forum-online">'.rcl_get_miniaction($action).'</div>';
/* локация */	<?php
if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_asgaros_scripts',10);
endif;
function rcl_asgaros_scripts(){
    rcl_enqueue_style('rcl-rcl-asgaros',rcl_addon_url('style.css', __FILE__));
    
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
/* // Звание на форуме, зависят от количества постов. Раскомментировать если вам такое надо.
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_author_rank', 10, 5);
function my_asgarosforum_after_post_author_rank($author_id, $author_posts) {
	$rank1 = 10; $rank2 = 20; $rank3 = 30; $rank4 = 40; $rank5 = 50;
  if (($author_posts > $rank1) && ($author_posts < $rank2)){
    echo '<br />Участник';
  } 
  else if (($author_posts > $rank2) && ($author_posts < $rank3)) {
    echo '<br />Активист';
  } 
  else if (($author_posts > $rank3) && ($author_posts < $rank4)) {
    echo '<br />Завсегдатай';
  } 
  else if (($author_posts > $rank4) && ($author_posts < $rank5)) {
    echo '<br />Старожил';
  } else {
    echo '<div class="icon-status-contributor">Новичок&nbsp;<i class="fa fa-info-circle"></i></div>';
  }
} */
	
/* // Вывод роли пользователя, вариант из релизов до 1.0.4 . Расскоментировать и настроить как у вас было, если новый не устроит или нужен вывод еще ролей.
add_action('asgarosforum_after_post_author', 'my_function_asgaros_recall_roles', 10, 1);
function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_function_asgaros_recall_roles($author_id) {
	$user_info = get_userdata($author_id);
    if(getUserRoles($author_id)=='administrator') {echo '<div class="icon-status-admin">Админ&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='contributor') {echo '<div class="icon-status-contributor">Участник&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='author') {echo '<div class="icon-status-author">Модератор&nbsp;<i class="fa fa-info-circle"></i></div>';}
else 
	if(getUserRoles($author_id)=='editor') {echo '<div class="icon-status-editor">Редактор&nbsp;<i class="fa fa-info-circle"></i></div>';};
} */
//Модератор, администратор, остальные участники форума
add_action('asgarosforum_after_post_author', 'my_asgarosforum_after_post_administration', 10, 2);
function getUserRoles($id) { 
    $user = new WP_User((int)$id); 
    return implode(' and ', $user->roles); 
}
function my_asgarosforum_after_post_administration($author_id, $author_posts) {
if (getUserRoles($author_id)=='administrator') {
    echo '<div class="icon-status-admin">'.__('Admin','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
    if (AsgarosForumPermissions::isModerator($author_id)) {
    echo '<div class="icon-status-moderator">'.__('Moderator','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
  } else {
	if(getUserRoles($author_id)=='contributor') {
	echo '<div class="icon-status-contributor">'.__('Contributor','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
	} else {
	if(getUserRoles($author_id)=='author') {
	echo '<div class="icon-status-author">'.__('Author','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';
} else {
	if(getUserRoles($author_id)=='editor') {
	echo '<div class="icon-status-editor">'.__('Editor','rcl-asgaros').'&nbsp;<i class="fa fa-info-circle"></i></div>';};	
           }	
         }
      }
    }
  }
/* ссылки и иконки в кабинет */
add_action('asgarosforum_after_post_author', 'my_function_asgaros_cabinet', 30, 1);
function my_function_asgaros_cabinet($author_id) {
	$user_info = get_userdata($author_id);
	echo '<a href="'.get_author_posts_url($author_id).'" title="'.__('Profile','rcl-asgaros').'"><i class="fa fa-user"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'chat').'" title="'.__('Private message','rcl-asgaros').'"><i class="fa fa-comment"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'recall').'" title="'.__('Reviews','rcl-asgaros').'"><i class="fa fa-trophy"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'groups').'" title="'.__('Groups','rcl-asgaros').'"><i class="fa fa-group"></i></a>
	<a href="'.rcl_format_url(get_author_posts_url($author_id),'publics').'" title="'.__('Publications','rcl-asgaros').'"><i class="fa fa-book"></i></a></span>';
/* статус онлайн/офлайн */	
	$action = rcl_get_time_user_action($author_id); echo '<div class="status-forum-online">'.rcl_get_miniaction($action).'</div>';
/* локация */	
	if(function_exists('ucc_get_value'))
	{
		echo '<div class="ucc-cou-siti">'.ucc_get_value($author_id).'</div>';
		}
}
/* подпись на форуме при использовании произвольного поля в профиле */
add_action('asgarosforum_after_post_message', 'my_function_signature', 10, 1);
function my_function_signature($author_id) {
echo '<div class="signature">'.get_user_meta($author_id,'podpis_na_forume_tekst_html_zapreshhen_35',1).'</div>';
	
}
	if(function_exists('ucc_get_value'))
	{
		echo '<div class="ucc-cou-siti">'.ucc_get_value($author_id).'</div>';
		}

}

/* подпись на форуме при использовании произвольного поля в профиле */
add_action('asgarosforum_after_post_message', 'my_function_signature', 10, 1);

function my_function_signature($author_id) {
echo '<div class="signature">'.get_user_meta($author_id,'podpis_na_forume_tekst_html_zapreshhen_35',1).'</div>';
	
}
