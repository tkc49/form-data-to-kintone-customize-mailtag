<?php
/**
 * Plugin Name:     Form Data To Kintone Customize Mailtag
 * Plugin URI:
 * Description:     Mailtag を合体させてkintoneへ登録することができます
 * Author:          Takashi Hosoya
 * Author URI:      https://takashihosoya.ninja/
 * Text Domain:     form-data-to-kintone-customize-mailtag
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Form_Data_To_Kintone_Customize_Mailtag
 */

// Your code starts here.


namespace FormDataToKintoneCustomizeMailtag;


function kintone_form_text_customize_mailtag( $value, $cf7_send_data, $cf7_mail_tag ) {

	preg_match_all( "|{(.*)}|U",
		$cf7_mail_tag,
		$out,
		PREG_PATTERN_ORDER );

	if ( ! empty( $out[1] ) ) {

		foreach ( $out[1] as $key => $split_mial_tag ) {
			$cf7_value    = $cf7_send_data[ $split_mial_tag ];
			$cf7_mail_tag = str_replace( $out[0][ $key ], $cf7_value, $cf7_mail_tag );
		}

		$value = $cf7_mail_tag;

		return $value;

	} else {
		return $value;
	}


}

add_filter( 'kintone_form_text_customize_mailtag', '\FormDataToKintoneCustomizeMailtag\kintone_form_text_customize_mailtag', 10, 3 );
add_filter( 'kintone_form_date_customize_mailtag', '\FormDataToKintoneCustomizeMailtag\kintone_form_text_customize_mailtag', 10, 3 );
