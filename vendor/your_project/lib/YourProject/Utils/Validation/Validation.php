<?php

namespace YourProject\Utils\Validation;

class Validation {

    public static $regexp_array = array(
        'email' => '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i',
        'phone' => '/^\+?[0-9]{1,3}\s?([0-9]{1,3})?\s?\(?[0-9]{3}\)?(\s)?[0-9]{3}(\s|\-)?[0-9]{2}(\s|\-)?[0-9]{2}$/i',
        'url' => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i',
        'company_domain' => '/^[a-zA-Z][0-9a-zA-Z_]{2,}$/i',
    );

    public function isValidEmail($email) {
        if (empty($email)) {
            return false;
        }
        return !!preg_match(self::$regexp_array['email'], $email);
    }

    public function isValidPhone($phone) {
        if (empty($phone)) {
            return false;
        }
        return !!preg_match(self::$regexp_array['phone'], $phone);
    }

    public function isValidUrl($url) {
        if (empty($url)) {
            return false;
        }
        return !!preg_match(self::$regexp_array['url'], $url);
    }

    public function isValidCompanyDomain($domain) {
        if (empty($domain)) {
            return false;
        }
        return !!preg_match(self::$regexp_array['company_domain'], $domain);
    }
}