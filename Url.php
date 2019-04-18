<?php

class Url extends Model
{
    protected $table = 'urls';
    protected $id = 'url';
    public $route;

    public function validate($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public function getHash($url)
    {
        return hash('crc32b', md5($url));
    }

    public function isRoute()
    {
        $requestUri = explode('?', $_SERVER['REQUEST_URI']);
        $hash = trim($requestUri[0], '/');

        if (preg_match('/^[\w\d]+$/', $hash)) {
            $res = $this->getByHash($hash);
            if ($res) {
                $this->route = $res['url'];
                return true;
            }
        }

        return false;
    }

    public function getByHash($hash)
    {
        $params = array('hash' => $hash);
        return $this->getWhere($params);
    }
}
