<?php
class Eat_Model extends Model {
    public $errors = array();
    public function __construct(){ parent::__construct(); }

	// get calories today
    public function getCaloriesToday(){
        $sql = "
			select 
				COALESCE(sum(calories * log.serving),0) as total 
			from eats_foods as foods,
				eats_log as log
			where 
				foods.id = log.eats_foods_id
				and date_format(post_date, '%Y-%m-%d') = date_format(NOW(), '%Y-%m-%d')
				and log.eats_people_id = :user_id
			group by date_format(post_date, '%Y-%m-%d')
			;";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        $result = $sth->fetch();
        
        if ($result && $result->total > 0) {
			return $result->total;                    
        } else {
			return 0;
		}
    }
    
	// get water today
    public function getWaterToday(){
    	$sql = "
			select 
				sum(log.serving) as total
			from eats_foods as foods,
				eats_log as log
			where 
				foods.id = log.eats_foods_id
				and date_format(post_date, '%Y-%m-%d') = CURDATE()
				and name = 'water'
				and log.eats_people_id = :user_id
			";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        $result = $sth->fetch();
        if ($result->total > 0) {
			return $result->total;                    
        } else {
			return 0;
		}
	}


	// get calories for the last 2 weeks
    public function getCaloriesTwoweeks(){
		$sql = "
			select 
				sum(calories * log.serving) as total,
				date_format(post_date, '%Y-%m-%d') as simple_date,
				date_format(post_date, '%M %d') as human_date,
				date_format(post_date, '%e') as day
			from eats_foods as foods,
				eats_log as log
			where 
				foods.id = log.eats_foods_id
				and post_date >= DATE_SUB(CURDATE(), INTERVAL 12 DAY)
				and log.eats_people_id = :user_id
			group by date_format(post_date, '%Y-%m-%d')
			order by post_date
			";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}


	// get recently eaten foods
    public function getRecentlyEaten(){
		$sql = "
		select 
			log.id,
			name, 
			log.serving as serving, 
			foods.calories as calories,
			post_date,
			date_format(post_date, '%l:%i%p') as human_time,
			log.serving * foods.calories as total
		from eats_foods as foods,
			eats_log as log
		where 
			foods.id = log.eats_foods_id
			and post_date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
			and (log.eats_people_id = :user_id or log.eats_people_id = '0')
		order by post_date desc 
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}


	// get fave foods
    public function getFaveFoods(){
		$sql = "
			select 
				id, 
				name,
				category 
			from eats_foods
			where 
				visible = 'yes' 
				and (eats_people_id = :user_id or eats_people_id = 0)
			order by category, name
			";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}


	// get feelings object for the year
    public function getFeelingsYear(){
		$month = date('m');
		$year = date('Y');
		$sql = "
		select 
			round(avg(feeling)) as feeling,
			date_format(post_date, '%Y-%m-%d') as short_date 
		from eats_moods 
		where 
			eats_people_id = :user_id
			and post_date >= DATE_SUB(now(), INTERVAL 365 DAY)
		group by short_date 
		order by post_date desc, feeling
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}

	// get moods log for this month
    public function getMoodsThisMonth(){
		$sql = "
		select 
			*, 
			date_format(post_date, '%M %d') as human_date, 
			date_format(post_date, '%D') as human_day, 
			date_format(post_date, '%l %p') as human_time, 
			date_format(post_date, '%W') as day 
		from eats_moods 
		where 
			eats_people_id = :user_id
			and month(post_date) = month(curdate())
			and year(post_date) = year(curdate())
		order by post_date desc
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}




// food
    public function add_food($food_name, $food_calories, $food_category){
    	$sql = "INSERT INTO eats_foods
                                   (name, calories, category, eats_people_id)
                                   VALUES (:food_name, :calories, :category, :user_id);";
       $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':food_name' => $_POST['food_name'],
            ':calories' => $_POST['food_calories'],
            ':category' => $_POST['food_category'],
            ':user_id' => $_SESSION['user_id']));   
		return true;
    }
    public function delete_food($food_id) {
        $sth = $this->db->prepare("DELETE FROM eats_foods WHERE id = :food_id AND eats_people_id = :user_id;");
        $sth->execute(array(
            ':food_id' => $food_id,
            ':user_id' => $_SESSION['user_id']));
        return true;
    }
    public function eat_food($eats_foods_id){
        $sth = $this->db->prepare("INSERT INTO eats_log
                                   (eats_foods_id, eats_people_id)
                                   VALUES (:eats_foods_id, :user_id);");
        $sth->execute(array(
            ':eats_foods_id' => $eats_foods_id,
            ':user_id' => $_SESSION['user_id']));   
		return true;
    }
    public function delete_eat_log($eats_log_id) {
        $sth = $this->db->prepare("DELETE FROM eats_log WHERE id = :eats_log_id AND eats_people_id = :user_id;");
        $sth->execute(array(
            ':eats_log_id' => $eats_log_id,
            ':user_id' => $_SESSION['user_id']));
        return true;
    }

// mood
    public function add_mood($eats_moods_id){
        $sth = $this->db->prepare("INSERT INTO eats_moods
                                   (note, feeling, eats_people_id)
                                   VALUES (:note, :feeling, :user_id);");
        $sth->execute(array(
			':note' => $_POST['mood_note'],
			':feeling' => $_POST['mood_feeling'],
            ':user_id' => $_SESSION['user_id']));   
		return true;
    }
    public function delete_mood_log($eats_mood_id) {
        $sth = $this->db->prepare("DELETE FROM eats_moods WHERE id = :eats_mood_id AND eats_people_id = :user_id;");
        $sth->execute(array(
            ':eats_mood_id' => $eats_mood_id,
            ':user_id' => $_SESSION['user_id']));
        return true;
    }




}