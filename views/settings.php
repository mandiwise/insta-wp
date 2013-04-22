<?php

global $wpsf_settings;

$wpsf_settings[] = array(
    'section_id' => 'api',
    'section_title' => 'Instagram Authentication',
    'section_description' => 'In order to use this plugin you\'ll need to <a href="http://instagram.com/developer/">register for the Instagram API</a>.',
    'section_order' => 5,
    'fields' => array(
        array(
            'id' => 'clientID',
            'title' => 'Instagram Client ID:',
            'desc' => 'Once you\'ve registered a new client with the Instagram API, enter its Client ID here.',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'id' => 'accessToken',
            'title' => 'Access Token:',
            'desc' => 'Add your assigned access token. Generate one <a href="http://www.pinceladasdaweb.com.br/instagram/access-token/">here</a>.',
            'type' => 'text',
            'std' => ''
        ),
    )
);

$wpsf_settings[] = array(
    'section_id' => 'display',
    'section_title' => 'Instagram Feed Shortcode',
    'section_description' => 'Customize the settings below to make your shortcode:',
    'section_order' => 10,
    'fields' => array(
        array(
            'id' => 'displayby',
            'title' => 'Display images based on:',
            'type' => 'select',
            'std' => 'none',
            'choices' => array(
	            'none' => '- Please select -',
                'byhash' => 'A hash tag',
                'byuser' => 'A username',
            )
        ),
        array(
            'id' => 'hash',
            'title' => 'Hash tag:',
            'desc' => 'Add your hash tag as letters and/or numbers only. Do not include "#" before the text.',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'id' => 'username',
            'title' => 'Username:',
            'desc' => 'Add your Instagram username (e.g. "johnsmith").',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'id' => 'max',
            'title' => 'Number of photos to show:',
            'type' => 'select',
            'std' => '10',
            'choices' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20'
            )
        ),
        array(
            'id' => 'size',
            'title' => 'Image size:',
            'type' => 'select',
            'std' => 'medium',
            'choices' => array(
                'small' => 'Small',
                'medium' => 'Medium',
                'big' => 'Big'
            )
        ),
    )
);

?>