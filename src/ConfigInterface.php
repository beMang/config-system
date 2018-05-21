<?php

namespace bemang;

interface ConfigInterface
{
    public static function getInstance();

    public function define($key, $value = null);

    public function get($key);

    public function has($key);

    public function delete($key);
}
