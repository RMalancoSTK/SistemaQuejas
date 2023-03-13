<?php

class ErrorController extends Controller
{
    private $messageerror;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Utils::comprobarSesion();
        $this->loadView('error/index');
    }

    public function getError404()
    {
        return $this->messageerror;
    }

    public function setError404($messageerror)
    {
        $this->messageerror = $messageerror;
    }
}
