<?php

class Cate
{
	private $bdd;
	private $table_name;
    private $left_border;
    private $right_border;
	
	public function __construct($bdd, $table="table", $left="left_border", $right="right_border"){
		$this->bdd = PDO2::getInstance();
		$this->table_name = $table;
        $this->left_border = $left;
        $this->right_border = $right;
	}
    
	public function getAll(){
		$sql = 'SELECT *
				FROM '.$this->table_name.'
				ORDER BY '.$this->left_border;
		$req = $this->bdd->query($sql);
		return($req ->fetchAll());
	}
	
	public function arb(){
		$all = $this->getAll();
		$level = 0;
		echo '<ul>';
		for($a=0, $x=count($all); $a<$x; $a++){
			// > décalage
			if($all[$a]['level']>$level){
				$level +=1;
				echo '<ul>';
				echo '<li>'.$all[$a]['name'].'</li>';
			}
			
			// - suite
			else if($all[$a]['level']==$level){
				echo '<li>'.$all[$a]['name'].'</li>';
			}
			
			// < recul d'un
			else if($all[$a]['level']-1==$level){
				$level -=1;
				echo '</ul>';
				echo '<li>'.$all[$a]['name'].'</li>';
			}
			
			// <<< recul de plusieurs
			else{
				$diff = $level-$all[$a]['level'];
				$level = $all[$a]['level'];
				for($b=0; $b<$diff; $b++){
					echo '</ul>';
				}
				echo '<li>'.$all[$a]['name'].'</li>';
			}		
		}
		echo '</ul>';
	}
	
	public function getByLevel($id, $level){
		$id = intval($id);
		$level = intval($level);
		
		// récupère borne gauche et droite de la sélection
		$sql = 'SELECT '.$this->left_border.', '.$this->right_border.' 
				FROM  '.$this->table_name.' 
				WHERE id="'.$id.'"';
			
		$donnee = $this->bdd->query($sql);
		$donnee = $donnee->fetch();
		
		$leftBorder = $donnee[$this->left_border];
		$rightBorder = $donnee[$this->right_border];

		// récupère les informations du niveau supérieur
		$req = $this->bdd->query('SELECT * 
								FROM '.$this->table_name.'
								WHERE level = "'.($level+1).'" 
									AND '.$this->left_border.' > "'.$leftBorder.'" 
									AND '.$this->right_border.' < "'.$rightBorder.'" 
								ORDER BY name');
							
		return($req ->fetchAll());
	}
	
	public function getRoot(){
		$sql = 'SELECT * 
				FROM '.$this->table_name.' 
				WHERE level = 0 
				ORDER BY name';
		$req = $this->bdd->query($sql);
		
		return($req ->fetchAll());
	}
	
	public function add($level, $add, $idCate){
		$level = intval($level);
		
		if($level == 0){
			// max
			$sql = '	SELECT MAX('.$this->left_border.') AS max 
						FROM '.$this->table_name;
			$req = $this->bdd->query($sql);
			$donnee = $req->fetch();
			$leftBorder = $donnee['max'];
			
			// ajoute après le max la valeur
			$sql = 'INSERT INTO '.$this->table_name.'
						VALUE("", 
								"'.$level.'", 
								"'.($leftBorder+2).'", 
								"'.($leftBorder+3).'", 
								"'.$add.'")';
		}

		// catégorie > 0
		else{

			$sql = 'SELECT '.$this->left_border.' FROM cat_dl WHERE id='.$idCate;
			$req = $this->bdd->query($sql);
			$donnee = $req->fetch();
			$leftBorder = $donnee[''.$this->left_border.''];
			
			// mise à jour bornes
			$sqlPrep = 'UPDATE '.$this->table_name.' 
						SET '.$this->left_border.' = '.$this->left_border.' + 2 
						WHERE '.$this->left_border.'>'.$leftBorder;
			$sqlPrep2 = 'UPDATE '.$this->table_name.' 
						SET '.$this->right_border.' = '.$this->right_border.' + 2 
						WHERE '.$this->right_border.'>='.$leftBorder;
			
			// insertion
			$sql = 'INSERT INTO '.$this->table_name.' 
					VALUE("", 
						"'.$level.'", 
						"'.($leftBorder+1).'", 
						"'.($leftBorder+2).'", 
						"'.$add.'")';

			// traitement sql
			$this->bdd->query($sqlPrep);
			$this->bdd->query($sqlPrep2);
		}
		
		$req = $this->bdd->prepare($sql);
		$req->execute();
	}
	
	public function edit($id, $new){
		$id = intval($id);
		
		$sql = 'UPDATE '.$this->table_name.' 
				SET name="'.$new.'" 
				WHERE id ='.$id;
		$req = $this->bdd->prepare($sql);
		$req->execute();
	}
	
	public function remove($id){
		$id = intval($id);
		
		$sql = 'SELECT '.$this->left_border.', '.$this->right_border.' 
				FROM '.$this->table_name.'
				WHERE id='.$id;
		$req = $this->bdd->query($sql);
		$donnee = $req->fetch();
		$leftBorder = $donnee[''.$this->left_border.''];
		$rightBorder = $donnee[''.$this->right_border.''];
		
		// feuille
		if(($rightBorder-$leftBorder) == 1){
			$del = 'DELETE FROM '.$this->table_name.' 
					WHERE '.$this->left_border.' = '.$leftBorder;
			$sql1 = 'UPDATE '.$this->table_name.' 
					SET '.$this->left_border.' = '.$this->left_border.' - 2 
					WHERE '.$this->left_border.' >= '.$leftBorder;
			$sql2 = 'UPDATE '.$this->table_name.'  
					SET '.$this->right_border.' = '.$this->right_border.' -2 W
					HERE '.$this->right_border.' >= '.$rightBorder;
		}
		
		// noeud
		else{
			$del = 'DELETE FROM '.$this->table_name.'
					WHERE '.$this->left_border.'>='.$leftBorder.' AND '.$this->right_border.'<= '.$rightBorder;
			$sql1 = 'UPDATE '.$this->table_name.' 
					SET '.$this->left_border.' = '.$this->left_border.' - '.(($rightBorder-$leftBorder)+1).' 
					WHERE '.$this->left_border.' > '.$leftBorder;
			$sql2 = 'UPDATE '.$this->table_name.' 
					SET '.$this->right_border.' = '.$this->right_border.' - '.(($rightBorder-$leftBorder)+1).' 
					WHERE '.$this->right_border.' > '.$rightBorder;
			
		}

		$this->bdd->query($del);
		$this->bdd->query($sql1);
		$this->bdd->query($sql2);
	}
}

?>