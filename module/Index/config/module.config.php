<?php

/*
 * Файл настроек для модуля Index. Чуть подробнее информация лежит в файле module/Err404/config/module.config.php
 */
return array(
    'actions' => array(
        'index' => 'index'
    ),
    'module_includes' => array(
        'index' => array(
            'merge' => array(
                'meta' => array(
                    'keywords' => '<meta name="keywords" content="...">',
                    'description' => '<meta name="description" content="...">'
                ),
                'script' => array(),
                'css' => array(),
                'module_views' => array(
                    'main' => array(
                        'auth' => true,
                        'allocated_paths' => array(
                            array(
                                'flag' => 0,
                                'value' => 'index/main/main'
                            )
                        )
                    )
                )
            ),
            'replace' => array(
                'title' => 'Замененный заголовок для экшена index'
            )
        ),
        'default' => array(
            'merge' => array(
                'meta' => array(
                    'keywords' => '<meta name="keywords" content="...">',
                    'description' => '<meta name="description" content="...">'
                ),
                'script' => array(),
                'css' => array(),
                'module_views' => array(
                    'main' => array(
                        'auth' => true,
                        'allocated_paths' => array(
                            array(
                                'flag' => 0,
                                'value' => 'index/main/main'
                            )
                        )
                    )
                )
            ),
            'replace' => array(
                'title' => 'Замененный заголовок для всех экшенов, которые не описаны в этом файле (экшен index - описан)'
            )
        )
    )
);