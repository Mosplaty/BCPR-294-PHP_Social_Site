<?php
/*
   MySQL Database Connection Class
*/

class MySQL {
  protected $host;
  protected  $dbUser;
  protected  $dbPass;
  protected  $dbName;
  protected  $dbConn;
  protected  $dbconnectError;


	function __construct( $host, $dbUser, $dbPass, $dbName ) {
		$this->host   = $host;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;
		$this->dbName = $dbName;
		$this->connectToServer();
	}


	function connectToServer() {
		$this->dbConn = mysqli_connect( $this->host, $this->dbUser, $this->dbPass );
		if ( !$this->dbConn ) {
		   trigger_error('could not connect to server' );
		   $this->dbconnectError = true;
		}
		else {
			echo "<script>console.log('connected to server')</script>";
		}
	}

    function selectDatabase()
    {
    if (! mysqli_select_db( $this->dbConn, $this->dbName ) ) {
              trigger_error( 'could not select database' );  
              $this->dbconnectError = true;                     
           }
           else {
				echo "<script>console.log('$this->dbName  database selected')</script>";
           }
      }
     

    function dropDatabase()
    {
		$sql = "drop database $this->dbName";
        echo "<br> $sql  <br>";
		if ( $this->query($sql) )
		{
			echo "<script>console.log('the $this->dbName database was dropped')</script>";
		}
		else
		{
			echo "<script>console.log('the $this->dbName database was not dropped')</script>";
		}
    }


    function createDatabase()
    {
		$sql = "create database if not exists $this->dbName ";
		echo "<br> $sql  <br>";
		if ( $this->query($sql) )
		   {
				echo "<script>console.log('the $this->dbName database was created')</script>";
		   }
			else
		   {
				echo "<script>console.log('the $this->dbName database was not created')</script>";
		   }
    }


   function isError()
   {
      if  ( $this->dbconnectError )
      {
         return true;
      }
      $error = mysqli_error( $this->dbConn );
      if (empty ($error))
      {
           return false;
      }
      else
      {
           return true;   
      }
   }

   
   	function createTable($table, $sql )
	{
		$result = $this->query($sql);
		if ( $result == True )
		{
			echo "<script>console.log('$table was added')</script>";
		}
		else
		{
			echo "<script>console.log('$table was not added')</script>";
		}
   }
   

	function query( $sql )
	{
		mysqli_query( $this->dbConn, "set character_set_results='utf8'"); 
		 if (!$queryResource = mysqli_query($this->dbConn, $sql ))
		 {
			trigger_error ( 'Query Failed: <br>' . mysqli_error($this->dbConn ) . '<br> SQL: ' . $sql );
			return false;
		 }
	 
		 return new MySQLResult( $this, $queryResource ); 
   }
   
}


class MySQLResult 
{
   protected $mysql;
   protected $query;

   function __construct( &$mysql, $query )
   {
     $this->mysql = &$mysql;
     $this->query = $query;
   }

    function size()
    {
        return mysqli_num_rows($this->query);
    }

    function fetch()
    {
		if ( $row = mysqli_fetch_array( $this->query , MYSQLI_ASSOC ))
		{
		   return $row;
		}
			   else if ( $this->size() > 0 )
       {
           mysqli_data_seek ( $this->query , 0 );
           return false;
       }
       else
       {
           return false;
       }         
    }

    function insertID()
    {
            /**
            * returns the ID of the last row inserted
            * @return  int
            * @access  public
            */
          return mysqli_insert_id($this->mysql->dbConn);
    }


   function isError()
   {
        return $this->mysql->isError();
   }
}