<?php
class Moods_Model extends Model {
    public $errors = array();
    public function __construct(){ parent::__construct(); }

	// get waters total
    public function getMoodTotals(){
		$sql = "
		select 
			count(*) as cnt,
			feeling
		from eats_moods 
		where 
			eats_people_id = :user_id
		group by feeling 
		order by cnt desc
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
    }
    

	// get feelings object for the year
    public function getFeelingsAll(){
		$sql = "
		select 
			round(avg(feeling)) as feeling,
			date_format(post_date, '%Y-%m-%d') as short_date 
		from eats_moods 
		where 
			eats_people_id = :user_id
		group by short_date 
		order by post_date desc, feeling
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}

	// get moods log for this month
    public function getMoodsYear(){
		$sql = "
		select 
			*, 
			date_format(post_date, '%M %d') as human_date, 
			date_format(post_date, '%D') as human_day, 
			date_format(post_date, '%l %p') as human_time, 
			month(post_date) as month, 
			year(post_date) as year, 
			date_format(post_date, '%W') as day 
		from eats_moods 
		where 
			eats_people_id = :user_id
		order by post_date desc
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
	}



}