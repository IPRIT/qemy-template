<?php

return array(
    'actions' => array(
        'index' => 'index'
    ),
    'module_includes' => array(
        /*
         * Настройки index специально для action "index".
         * Если хотите использовать одинаковые настройки для всех action'ов, то используйте 'default' (Чуть ниже)
         **/
        'index' => array(
            /*
             * Используйте merge, когда необходимо соединить воедино настройки ниже с настройками в файле
             * application/config/application.config.php
             */
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
                                'flag' => 0, /*
                                              * Как пример, это свойство может принимать значения: 2 | 4 | 8 | 1024 - права пользователя (2^N)
                                              * Числа складываются через "битовое или".
                                              *
                                              * Пример: 'flag' => 2 | 1024 | 512
                                              * * Означает, что шаблон index/404 будут видеть только пользователи, у которых
                                              * * права 2 (например, пользователь) или 1024 (например, администратор) или 512 (модератор)
                                              *
                                              * Все остальные не увидят этот шаблон, если конечно флаг 'auth' принимает не false.
                                              * 0 — значение по умолчанию
                                             **/
                                'value' => 'index/404'
                            ),
                            array(
                                'flag' => 256, /* Шаблон 'index/404_another' увидят только пользователи с правами 256. */
                                'value' => 'index/404_another'
                            )
                        )
                    )
                )
            ),
            /*
             * Используйте replace, когда необходимо заменить настройки в файле application/config/application.config.php
             */
            'replace' => array()
        ),
        'default' => array() /* Если хотите использовать одинаковые настройки для всех action'ов  */
    )
);