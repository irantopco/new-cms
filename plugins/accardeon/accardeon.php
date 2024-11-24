<?php

if ( !defined( 'plugins-inc' ) OR !is_array( @$data ) )
{
    die( '<a href="http://help.mihanphp.com/plugins" target=_blank>samaneh</a> :: Invalid calling of ' . basename( __FILE__ ) );
}

function accardeon_output()
{
    global $tpl, $d, $config;
    $args = func_get_args();
    $itpl       = new samaneh();
    $id = intval( $args[0]['tid'] );
	$group = $d->Query( "SELECT * FROM `accardeon_groups` WHERE `id`='$id'" );
	$group = $d->fetch( $group );
	$template = $group['template'];
	if( !empty( $template ) && ctype_alnum( $template ) )
	{
		if( file_exists( current_theme_dir . 'plugins' . DIRECTORY_SEPARATOR .'accardeon' .DIRECTORY_SEPARATOR . $template . '.html' ) )
		{
			$itpl->load( current_theme_dir . 'plugins' . DIRECTORY_SEPARATOR .'accardeon' .DIRECTORY_SEPARATOR . $template . '.html' );
		}
		else if(  file_exists( plugins_dir . DS . 'accardeon' . DS . 'themes' . DS . $template . '.html' ) )
		{
			$itpl->load( plugins_dir . DS . 'accardeon' . DS . 'themes' . DS . $template . '.html' );
		}
		else
		{
			$itpl->load( 'plugins/accardeon/plugins/default.html' );
		}
	}	
	else
	{
		$itpl->load( 'plugins/accardeon/plugins/default.html' );
	}
    $itpl->assign( 'theme_url', core_theme_url );
    
	$accardeon = $d->Query( "SELECT * FROM `accardeon` WHERE `gid`='$id'" );
	while( $data = $d->fetch( $accardeon ) )
	{
		$itpl->block( 'accardeon', $data );
	}
    return $itpl->dontshowit();
}