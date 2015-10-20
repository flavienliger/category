<?php
define('SQL_DSN',  'mysql:dbname=category;host=localhost');
define('SQL_USERNAME', 'root');
define('SQL_PASSWORD', '');

/* constructeur PDO connexion */
class PDO2 extends PDO {
	private static $_instance;

	/* Constructeur : héritage public obligatoire par héritage de PDO */
	public function __construct( ) {}

	public static function getInstance() {
		if (!isset(self::$_instance)) {
			try {
				self::$_instance = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
			} 
			catch (PDOException $e) {
				echo $e;
			}
		} 
		
		return self::$_instance; 
	}
}
?>