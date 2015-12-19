<?php
class Foods_Model extends Model {
    public $errors = array();
    public function __construct(){ parent::__construct(); }

	// get waters total
    public function getTotalWaters(){
		$sql = "
		select 
			round(sum(serving)) as total
		from eats_log 
		where 
			eats_foods_id = '21' 
			and eats_people_id = :user_id
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        $result = $sth->fetch();
        if ($result && $result->total > 0) {
			return $result->total;                    
        } else {
			return 0;
		}
    }
    
    
	// get foods today
    public function getTotalFoods(){
		$sql = "
		select 
			round(sum(log.serving)) as eaten,
			category 
		from eats_log log left join eats_foods foods on log.eats_foods_id = foods.id
		where 
			name is not NULL 
			and log.eats_people_id = :user_id
		group by category 
		order by eaten desc
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
    }
    

	// get foods today
    public function getTotalEaten(){
		$sql = "
		select 
			round(sum(log.serving)) as eaten,
			foods.name as name,
			foods.category 
		from eats_log log left join eats_foods foods on log.eats_foods_id = foods.id
		where 
			name is not NULL 
			and name != 'water'
			and log.eats_people_id = :user_id
		group by eats_foods_id 
		order by eaten desc
		";
		$sth = $this->db->prepare($sql);
		$sth->execute(array(':user_id' => $_SESSION['user_id']));    
        return $sth->fetchAll();
    }
    



}