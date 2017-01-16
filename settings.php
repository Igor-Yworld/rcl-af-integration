<?php

if (!defined('ABSPATH')) exit;

// Настройка дополнения
add_filter('admin_options_wprecall','options_rcl_asgaros');
function options_rcl_asgaros($options){
	
    $opt = new Rcl_Options();
	
    $options .= $opt->options(
        (__('Forum settings','rcl-asgaros')),
        $opt->option_block(
            array(
                $opt->title(__('User signature','rcl-asgaros')),
 $opt->option('select',array(
                    'name'=>'afrcl_signature_enable',
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'signature-hide'=>(__('Turn off','rcl-asgaros')),
                        'signature'=>(__('Enable','rcl-asgaros')),
                        )
                )),

$opt->child(
            array(
                    'name'=>'afrcl_signature_enable',
                    'value'=>'signature'//значение опции родителя
                    ),
                    array(
					$opt->option('text',array('name'=>'signature','label'=>__('Install MetaKey additional signature field','rcl-asgaros'),'help'=>__('Creating an additional text field in your profile and set it MetaKey. Not necessary.','rcl-asgaros'),'notice'=>__('Example: podpis_na_forume','rcl-asgaros'))),
					)
                ),
               
				$opt->title(__('User roles','rcl-asgaros')),
				$opt->option('select',array(
                    'name'=>'afrcl_roles_enable',
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        '1'=>(__('Turn off','rcl-asgaros')),
                        '2'=>(__('Enable','rcl-asgaros')),
                        )
                )),

$opt->child(
            array(
                    'name'=>'afrcl_roles_enable',
                    'value'=>'2'//значение опции родителя
                    ),
                array(
				$opt->option('text',array('name'=>'admin_forum','label'=>__('Forum administrator','rcl-asgaros'),'help'=>__('Display name of the administrator role','rcl-asgaros'),'notice'=>__('Example: Admin','rcl-asgaros'))),                
                $opt->option('text',array('name'=>'moderator_forum','label'=>__('Forum moderftor','rcl-asgaros'),'help'=>__('Display name of the moderftor role','rcl-asgaros'),'notice'=>__('Example: Moderftor','rcl-asgaros'))),                
                $opt->option('text',array('name'=>'contributor_forum','label'=>__('Forum contributor','rcl-asgaros'),'help'=>__('Display name of the contributor role','rcl-asgaros'),'notice'=>__('Example: Contributor','rcl-asgaros'))),                
                $opt->option('text',array('name'=>'author_forum','label'=>__('Author(The role of the site)','rcl-asgaros'),'help'=>__('Display name of the author role','rcl-asgaros'),'notice'=>__('Example: Author','rcl-asgaros'))),                
                $opt->option('text',array('name'=>'editor_forum','label'=>__('Editor(The role of the site)','rcl-asgaros'),'help'=>__('Display name of the editor role','rcl-asgaros'),'notice'=>__('Example: Editor','rcl-asgaros'))),
                    )
                ),
                $opt->label(__('The icon next to the role','rcl-asgaros')),
                $opt->option('select',array(
                    'name'=>'icon_role',
                //    'default'=>1,
                    'parent'=>true,
                    'options'=>array(
                        ''=>(__('Turn off','rcl-asgaros')),
                        'fa fa-info-circle icon-status-indent'=>(__('Enable','rcl-asgaros')),
                        )
                )),
                $opt->title(__('Ranks from the number of messages','rcl-asgaros')),
				$opt->option('select',array(
                    'name'=>'afrcl_rank_enable',
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        '1'=>(__('Turn off','rcl-asgaros')),
                        '2'=>(__('Enable','rcl-asgaros')),
                        )
                )),
                $opt->child(
                array(
                    'name'=>'afrcl_rank_enable',
                    'value'=>'2'//значение опции родителя 1
                    ),
				array(	
                $opt->option('text',array('name'=>'rank1_forum','label'=>__('The first rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: Contributor','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount1_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 10','rcl-asgaros'))),
            
                $opt->option('text',array('name'=>'rank2_forum','label'=>__('Second rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: Activist','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount2_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 50','rcl-asgaros'))),
                                
                $opt->option('text',array('name'=>'rank3_forum','label'=>__('A third rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: lodger','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount3_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 100','rcl-asgaros'))),                
                
                $opt->option('text',array('name'=>'rank4_forum','label'=>__('The fourth rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: Frequenter','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount4_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 500','rcl-asgaros'))),
                                
                $opt->option('text',array('name'=>'rank5_forum','label'=>__('The fifth rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: The local','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount5_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 800','rcl-asgaros'))),
                                
                $opt->option('text',array('name'=>'rank6_forum','label'=>__('The sixth rank','rcl-asgaros'),'help'=>__('Do not fill the field if you do not use the rank.','rcl-asgaros'),'notice'=>__('Example: VIP','rcl-asgaros'))),
                $opt->option('number',array('name'=>'amount6_posts','label'=>__('Number of posts','rcl-asgaros'),'notice'=>__('Example: 1000','rcl-asgaros'))),
                  )
                ),
                $opt->title(__('Information block','rcl-asgaros')),
 $opt->option('select',array(
                    'name'=>'information_enable_recall',
                    'label'=>(__('Information block','rcl-asgaros')),
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'info-hide'=>(__('Turn off','rcl-asgaros')),
                        'info-enable'=>(__('Enable','rcl-asgaros')),
                        )
                )),
                
                $opt->title(__('Profile Icons','rcl-asgaros')),
 $opt->option('select',array(
                    'name'=>'icon_enable_recall',
                    'label'=>(__('Enable reviews','rcl-asgaros')),
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'icon-hide'=>(__('Turn off','rcl-asgaros')),
                        'fa fa-trophy'=>(__('Enable','rcl-asgaros')),
                        )
                )),
                
 $opt->option('select',array(
                    'name'=>'icon_enable_groups',
                    'label'=>(__('Enable groups','rcl-asgaros')),
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'icon-hide'=>(__('Turn off','rcl-asgaros')),
                        'fa fa-group'=>(__('Enable','rcl-asgaros')),
                        )
                )),
                
 $opt->option('select',array(
                    'name'=>'icon_enable_publics',
                    'label'=>(__('Enable publications','rcl-asgaros')),
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'icon-hide'=>(__('Turn off','rcl-asgaros')),
                        'fa fa-book'=>(__('Enable','rcl-asgaros')),
                        )
                )),

                $opt->title(__('Additional field','rcl-asgaros')),
 $opt->option('select',array(
                    'name'=>'afrcl_field_name_enable',
                 //   'default'=>5,
                    'parent'=>true,
                    'options'=>array(
                        'hidden'=>(__('Turn off','rcl-asgaros')),
                        'afrcl-field'=>(__('Enable','rcl-asgaros')),
                        )
                )),

$opt->child(
            array(
                    'name'=>'afrcl_field_name_enable',
                    'value'=>'afrcl-field'//значение опции родителя
                    ),
                    array(
					$opt->option('text',array('name'=>'afrcl_field_name_1','label'=>__('Name','rcl-asgaros'),'help'=>__('Enter the the field name. Not necessary.','rcl-asgaros'),'notice'=>__('Example: android','rcl-asgaros'))),
                    $opt->option('text',array('name'=>'afrcl_field_1','label'=>__('Install MetaKey additional field','rcl-asgaros'),'help'=>__('Creating an additional text field in your profile and set it MetaKey. Not necessary.','rcl-asgaros'),'notice'=>__('Example: android_version','rcl-asgaros'))),
                    )
                )           
            )
        )
    ); 
	
    return $options;
}

?>
