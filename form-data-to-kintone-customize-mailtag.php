<?php
/**
 * Plugin Name:     Form Data To Kintone Customize Mailtag
 * Plugin URI:
 * Description:     Mailtag を合体させてkintoneへ登録することができます
 * Author:          Takashi Hosoya
 * Author URI:      https://takashihosoya.ninja/
 * Text Domain:     form-data-to-kintone-customize-mailtag
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Form_Data_To_Kintone_Customize_Mailtag
 */

// Your code starts here.


namespace FormDataToKintoneCustomizeMailtag;


/**
 * テキストフィールドのメールタグを合体させてkintoneへ登録する
 *
 * @param string $value メールタグを合体させた値.
 * @param array  $cf7_send_data フォームデータ.
 * @param string $cf7_mail_tag メールタグ.
 *
 * @return string メールタグを合体させた値.
 */
function kintone_form_text_customize_mailtag( $value, $cf7_send_data, $cf7_mail_tag ) {

	preg_match_all(
		'|{(.*)}|U',
		$cf7_mail_tag,
		$out,
		PREG_PATTERN_ORDER
	);

	if ( ! empty( $out[1] ) ) {

		foreach ( $out[1] as $key => $split_mail_tag ) {
			if ( isset( $cf7_send_data[ $split_mail_tag ] ) ) {
				$cf7_value = $cf7_send_data[ $split_mail_tag ];
				if ( is_array( $cf7_value ) ) {
					$cf7_mail_tag = str_replace( $out[0][ $key ], $cf7_value[0], $cf7_mail_tag );
				} else {
					$cf7_mail_tag = str_replace( $out[0][ $key ], $cf7_value, $cf7_mail_tag );
				}
			} else {
				// タグに対応する値が見つからない場合は、空文字列で置換.
				$cf7_mail_tag = str_replace( $out[0][ $key ], '', $cf7_mail_tag );
			}
		}

		$value = $cf7_mail_tag;

		return $value;

	} else {
		return $value;
	}
}

add_filter( 'kintone_form_text_customize_mailtag', '\FormDataToKintoneCustomizeMailtag\kintone_form_text_customize_mailtag', 10, 3 );
add_filter( 'kintone_form_date_customize_mailtag', '\FormDataToKintoneCustomizeMailtag\kintone_form_text_customize_mailtag', 10, 3 );
