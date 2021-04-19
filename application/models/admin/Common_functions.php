<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Common_functions extends CI_Model
{
    public function app_name()
    {
        return $this->config->item('app_name');
    }
}

  