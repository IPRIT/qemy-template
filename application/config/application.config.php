<?php

return array(
    'modules' => array(
        '404' => 'Err404',
        'index' => 'Index'
    ),
    'module_options' => array(
        'module_path' => '/module'
    ),
    'vendor_options' => array(
        'vendor_path' => '/vendor',
        'projects' => array(
            'qemy' => array(
                'base_path' => '/qemy/qemyframework',
                'library_path' => '/qemy/qemyframework/lib'
            ),
            'your_project_name' => array(
                'base_path' => '/your_project',
                'library_path' => '/your_project/lib'
            )
        )
    ),
    'views_options' => array(
        'views_path' => '/vendor/qemy/qemyframework/resources/layout',
        'common_includes' => array(
            'title' => 'Имя страницы',
            'meta' => array(
                'charset' => '<meta http-equiv="content-type" content="text/html; charset=utf-8">',
                'ie' => '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
            ),
            'script' => array(
                'jquery',
                'your_script'
            ),
            'css' => array(
                'style'
            ),
            'icon' => array(
                'favicon'
            ),
            'views' => array(
                'head' => array(
                    'auth' => true,
                    'allocated_paths' => array(
                        array(
                            'flag' => 0,
                            'value' => 'common/head/head'
                        )
                    )
                ),
                'footer' => array(
                    'auth' => true,
                    'allocated_paths' => array(
                        array(
                            'flag' => 0,
                            'value' => 'common/footer/footer'
                        )
                    )
                )
            )
        )
    ),
    'resource_options' => array(
        'path' => '/application/resources/global.php'
    ),
    'db_options' => require Q_PATH.'/application/config/db.config.php',
    'user_files_opt' => array(
        'host' => 'userapi.twosphere.ru',
        'protocol' => 'http'
    )
);