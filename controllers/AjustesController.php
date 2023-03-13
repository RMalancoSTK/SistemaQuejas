<?php

require_once 'models/AjustesModel.php';

class AjustesController extends Controller
{
    private $ajustesModel;

    public function __construct()
    {
        parent::__construct();
        $this->ajustesModel = new AjustesModel();
    }

    public function general()
    {
        Utils::isAdmin();
        $this->loadView('ajustes/general');
    }
}
