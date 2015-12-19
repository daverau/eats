<?php

class Moods extends Controller {
    
	function __construct() {
		parent::__construct();
		Auth::handleLogin();
		//$this->view->js = array('dashboard/js/default.js');
	}
	
	function index() {
        $this->view->total_moods = $this->model->getMoodTotals();
        $this->view->feelings_all = $this->model->getFeelingsAll();
        $this->view->moods_year = $this->model->getMoodsYear();
		$this->view->render('moods/index');
	}

}