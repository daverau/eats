<?php

class Foods extends Controller {
    
	function __construct() {
		parent::__construct();
		Auth::handleLogin();
		//$this->view->js = array('dashboard/js/default.js');
	}
	
	function index() {
        $this->view->total_waters = $this->model->getTotalWaters();
        $this->view->total_foods = $this->model->getTotalFoods();
        $this->view->total_eaten = $this->model->getTotalEaten();
		$this->view->render('foods/index');
	}

}