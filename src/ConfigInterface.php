<?php

namespace bemang;

interface ConfigInterface
{
    public static function define($key, $value = null);

    public static function get($key);

    public static function has($key);

    public static function delete($key);
}
