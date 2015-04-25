<?php

namespace Qemy\Core\View;

use Qemy\Core\Application;

abstract class AbstractView {

    /** @var $data array */
    protected $data; //данные, переданные из контроллера

    /** @var $view string */
    protected $view; //путь до контента (относительный)

    /** @var $config array */
    protected $config; //глобальная конфигурация приложения

    /** @var $module_config_all array */
    protected $module_config_all; //модульная конфигурация

    /** @var $module_config array */
    protected $module_config; //модульная конфигурация для action

    /** @var $module_path string */
    protected $module_path; //полный путь до модуля

    /** @var $module_name string */
    protected $module_name; //имя модуля

    /** @var $module_name string */
    protected $action_name; //имя action

    /** @var $common_view_path string */
    protected $common_view_path; //полный путь до общей верстки

    /** @var $general_includes array */
    protected $general_includes; //общие настройки подключаемых файлов

    /** @var $resources array */
    protected $resources; //ресурсы приложения

    function __construct($module_name, $action_name = "") {
        $this->module_name = $module_name;
        $this->action_name = $action_name;
        $this->config = Application::$config;
        $this->common_view_path = Q_PATH.$this->config['views_options']['views_path'];

        $module_options = $this->config['module_options'];
        $this->module_path = Q_PATH.$module_options['module_path'].'/'.$module_name;
        $this->module_config_path = $this->module_path.'/config/module.config.php';

        $this->module_config_all = require $this->module_config_path;

        $this->general_includes = $this->mergeSettings($this->config, $this->module_config_all);

        $this->resources = $this->getApplicationResources();
    }

    public function setContent($view) {
        $this->view = $view;
    }

    //подключение представления из модуля. Название передается как параметр.
    public function includeModuleView($view) {
        $view = isset($this->general_includes['module_views'][$view]) ? $this->general_includes['module_views'][$view] : !1;

        $data = $this->getData();
        /** @var \Service\User\User $user */
        $user = isset($data['user']) ? $data['user'] : null;
        $user_authorized = !empty($user) ? $user->isAuth() : false;
        $user_flag = !empty($user) ? $user->getAccessFlag() : 0;
        $mode = $view['auth'];

        if ($view) {
            $current_path = 'default';
            if ($mode && $user_authorized) {
                foreach ($view['allocated_paths'] as $path_set) {
                    list($view_flag, $path) = array($path_set['flag'], $path_set['value']);
                    if (!$view_flag) {
                        $current_path = $path;
                        continue;
                    }
                    if ($view_flag & $user_flag == $user_flag) {
                        $current_path = $path;
                        break;
                    }
                }
            } else {
                foreach ($view['allocated_paths'] as $path_set) {
                    list($view_flag, $path) = array($path_set['flag'], $path_set['value']);
                    if (!$view_flag) {
                        $current_path = $path;
                        break;
                    }
                }
            }
            $this->includeFile($this->module_path.'/view/'.$current_path.'.tpl.php');
        }
    }

    //подключение представления из общей настройки. Передается название в качестве параметра.
    public function includeView($view) {
        $view = isset($this->general_includes['views'][$view]) ? $this->general_includes['views'][$view] : !1;

        $data = $this->getData();
        /** @var \Service\User\User $user */
        $user = isset($data['user']) ? $data['user'] : null;
        $user_authorized = !empty($user) ? $user->isAuth() : false;
        $user_flag = !empty($user) ? $user->getAccessFlag() : 0;
        $mode = $view['auth'];

        if ($view) {
            $current_path = 'default';
            if ($mode && $user_authorized) {
                foreach ($view['allocated_paths'] as $path_set) {
                    list($view_flag, $path) = array($path_set['flag'], $path_set['value']);
                    if (!$view_flag) {
                        $current_path = $path;
                        continue;
                    }
                    if ($view_flag & $user_flag == $user_flag) {
                        $current_path = $path;
                        break;
                    }
                }
            } else {
                foreach ($view['allocated_paths'] as $path_set) {
                    list($view_flag, $path) = array($path_set['flag'], $path_set['value']);
                    if (!$view_flag) {
                        $current_path = $path;
                        break;
                    }
                }
            }
            $this->includeFile($this->common_view_path.'/'.$current_path.'.tpl.php');
        }
    }

    //подключение скриптов
    public function includeScripts() {
        $scripts = $this->general_includes['script'];
        $script_template = '<script type="text/javascript" src="{0}"></script>';
        foreach ($scripts as $key) {
            if (array_key_exists($key, $this->resources['static']['script'])) {
                $version = isset($this->resources['static']['script'][$key]['version']) ? $this->resources['static']['script'][$key]['version'] : '';
                if ($version) {
                    $version = rand(1, 1e9);
                }
                echo str_replace(array('{0}'), array($this->resources['static']['script'][$key]['file'].($version ? '?'.$version : '')), $script_template);
            }
        }
    }

    //подключение содержимого head
    public function includeHeaders() {
        if (isset($this->general_includes['title'])) {
            echo '<title ng-bind="title">'.$this->general_includes['title'].'</title>';
        }
        if (isset($this->general_includes['meta']) && is_array($this->general_includes['meta'])) {
            foreach ($this->general_includes['meta'] as $value) {
                echo $value;
            }
        }
        $styles = $this->general_includes['css'];
        if ($styles && is_array($styles)) {
            $style_template = '<link type="text/css" rel="stylesheet" href="{0}">';
            foreach ($styles as $key) {
                if (array_key_exists($key, $this->resources['static']['css'])) {
                    $version = isset($this->resources['static']['css'][$key]['version']) ? $this->resources['static']['css'][$key]['version'] : '';
                    if ($version) {
                        $version = rand(1, 1e9);
                    }
                    echo str_replace(array('{0}'), array($this->resources['static']['css'][$key]['file'].($version ? '?'.$version : '')), $style_template);
                }
            }
        }
        if (isset($this->general_includes['icon']) && !empty($this->general_includes['icon'][0])) {
            $key = $this->general_includes['icon'][0];
            $version = $this->resources['static']['img'][$key]['version'];
            echo str_replace(array('{0}'), array($this->resources['static']['img'][$key]['file'].'?'.$version), '<link rel="shortcut icon" type="image/png" href="{0}">');
        }
    }

    protected function includeFile($full_path) {
        if (file_exists($full_path)) {
            require $full_path;
        }
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getView() {
        return $this->view;
    }

    public function getData() {
        return $this->data;
    }

    public function resetView($name_view, $data) {
        $this->general_includes['views'][$name_view] = $data;
    }

    private function mergeSettings($global_config, $module_config_all) {
        $general_includes = $global_config['views_options']['common_includes'];
        $default_name = 'default';
        $module_includes = !empty($this->action_name) && isset($module_config_all['module_includes'][$this->action_name])
            ? $module_config_all['module_includes'][$this->action_name] : $module_config_all['module_includes'][$default_name];

        /* replace settings */
        if (isset($module_includes['replace']) && !empty($module_includes['replace'])) {
            foreach ($module_includes['replace'] as $key => $value) {
                if ($key == 'common_views') {
                    foreach ($value as $view_name => $view) {
                        if (array_key_exists($view_name, $general_includes['views'])) {
                            $general_includes['views'][$view_name] = $view;
                        }
                    }
                    continue;
                }
                $general_includes[$key] = $value;
            }
        }

        /* merge settings */
        if (isset($module_includes['merge']) && !empty($module_includes['merge'])) {
            foreach ($module_includes['merge'] as $key => $value) {
                if (!isset($general_includes[$key])) {
                    $general_includes[$key] = $value;
                    continue;
                }
                $general_includes[$key] = array_merge($general_includes[$key], $value);
            }
        }
        return $general_includes;
    }

    private function getApplicationResources() {
        return require Q_PATH.$this->config['resource_options']['path'];
    }
}