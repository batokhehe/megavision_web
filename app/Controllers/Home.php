<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->data['view']     = 'dashboard';
        $this->data['menu']     = '@MEGAVISION';
        $this->data['slug']     = 'dashboard';
        $this->data['required'] = '<span style="color:red">* Required</span></br></br>';

        $this->session             = \Config\Services::session();
        $this->data['session']     = $this->session->get();
    }

    public function index(): string
    {
        return view('welcome_message');
    }

    public function dashboard()
    {
        $this->template->views($this->data['view'] . '/index', $this->data, $this->data['view'] . '/scripts');
    }
}
