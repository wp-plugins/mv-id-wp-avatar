<?php
/*
Plugin Name: MV-ID: WP Avatar
Plugin URI: http://signpostmarv.name/mv-id/
Description: Replaces images for identities handled by the Metaverse ID plugin with WordPress avatars if the identity name matches a WordPress username
Version: 1.0
Author: SignpostMarv Martin
Author URI: http://signpostmarv.name/
 Copyright 2009 SignpostMarv Martin  (email : mv-id.wp@signpostmarv.name)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(class_exists('mv_id_vcard') === false)
{
	return;
}

class mv_id_wp_avatar{
	public static function filter_post_output_mv_id_vcard($hresume,mv_id_vcard $vcard){
		if(($data = get_userdatabylogin($vcard->name())) !== false){
			if(isset($data->user_email) && empty($data->user_email) === false){
				$avatar = get_avatar($data->user_email);
				if($vcard->img() !== null){
					$hresume = str_replace('<img class="photo" src="' . $vcard->image_url() . '" alt="' . htmlentities2($vcard->name()) . '" />', $avatar, $hresume);
				}
			}
		}
		return $hresume;
	}
}
add_filter('post_output_mv_id_vcard', array('mv_id_wp_avatar', 'filter_post_output_mv_id_vcard'), 10, 2);
?>