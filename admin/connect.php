<?php
class Database 
{
    // Une variable static => Permet d'accéder aux  variables sans avoir besoin d'instancier la classe,
    // Le $this n'éxiste pas, car la classe n'est pas instancié

    private static $dbHost = "localhost";   // Nom de l'hôte
    private static $dbName = "garage_la_feltiere"; // Nom de la base de données DBS
    private static $dbUser = "root"; // Nom d'utilisateur DBU(ser)
    private static $dbUserPassword = ""; // mdp de la BDD
    private static $connection = null;

    /** Methodes **/
    public static function connect()
    {
        try{
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=".self::$dbName, self::$dbUser, self::$dbUserPassword );
        }
        //  self => ne représent pas une variable, mais la classe elle même
        //  :: => Opérateur de résolution de portée, permet d'accéder aux membres static de la classe
        catch(Exception $e){
            die($e->getMessage());
        }
        return self::$connection;  
    }

    public static function disconnect()
    {
        self::$connection = null;
    }

}

 Database::connect();

?>