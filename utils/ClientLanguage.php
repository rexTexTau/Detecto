<?php
class ClientLanguage {
    public static function get() {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
}