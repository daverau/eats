<?php

class Eat extends Controller {
    
	function __construct() {
		parent::__construct();
		Auth::handleLogin();
	}
	
	function index() {
        $this->view->calories_today = $this->model->getCaloriesToday();
        $this->view->water_today = $this->model->getWaterToday();
        $this->view->caloriesTwoweeks = $this->model->getCaloriesTwoweeks();
        $this->view->recently_eaten = $this->model->getRecentlyEaten();
        $this->view->fave_foods = $this->model->getFaveFoods();
        $this->view->feelings_year = $this->model->getFeelingsYear();
        $this->view->moods_this_month = $this->model->getMoodsThisMonth();
		$this->view->render('eat/index');
	}

// food
    public function add_food() {
        $this->model->add_food($_POST['food_name'], $_POST['food_calories'], $_POST['food_category']);
        header('location: ' . URL . 'eat');
    }
    public function delete_food($food_id) {
        $this->model->delete_food($food_id);
        header('location: ' . URL . 'eat');
    }
    public function eat_food() {
        $this->model->eat_food($_POST['eats_foods_id']);
        header('location: ' . URL . 'eat');
    }
    public function delete_eat_log($eats_log_id) {
        $this->model->delete_eat_log($eats_log_id);
        header('location: ' . URL . 'eat');
    }

// mood
    public function add_mood() {
        $this->model->add_mood($_POST['mood_note'], $_POST['mood_feeling']);
        header('location: ' . URL . 'eat');
    }
    public function delete_mood_log($eats_mood_id) {
        $this->model->delete_mood_log($eats_mood_id);
        header('location: ' . URL . 'eat');
    }


}