<?php

namespace bemang\Core;

class Config
{
    protected $config = [];
    protected $configFiles;

    public function getConfigArray()
    {
        return $this->config;
    }

    public function get($key)
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        } else {
            return false;
        }
    }

    public function define($file)
    {
        if (is_file($file)) {
            $this->config = array_merge($this->config, require($file));
        } else {
            return false;
        }
    }

    public function defineUnique($nameParam, $valParam)
    {
        $this->config[$nameParam] = $valParam;
    }
}
