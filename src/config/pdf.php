<?php

return [
    'mode'                 => '',
    'format'               => 'A4',
    'default_font_size'    => '12',
    'default_font'         => 'sans-serif',
    'margin_left'          => 10,
    'margin_right'         => 10,
    'margin_top'           => 10,
    'margin_bottom'        => 10,
    'margin_header'        => 0,
    'margin_footer'        => 0,
    'orientation'          => 'P',
    'title'                => 'Laravel mPDF',
    'author'               => '',
    'watermark'            => '',
    'show_watermark'       => false,
    'watermark_font'       => 'sans-serif',
    'display_mode'         => 'fullpage',
    'watermark_text_alpha' => 0.1,
    'auto_language_detection'  => true,
    'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
    'pdfa'          => false,
    'pdfaauto'      => false,
    'custom_font_dir' => base_path('resources/fonts/'),
    'custom_font_data' => [
        'ipag' => [
        'R'  => 'ipag.ttf',
        ],
    ],
];