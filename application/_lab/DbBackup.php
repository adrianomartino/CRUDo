

<?php




class DbBackup{
    
    /*
     copied from http://davidwalsh.name/backup-mysql-database-php
     adn adapted to this library
    */
    
    
    public function __construct($host=DB_HOST,$user=DB_USER,$pass=DB_PASSWORD,$name=DB,$tables = '*'){
	
        $return=false;
        
        
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		

		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                
                //add if not exists option
                $row2 =
                str_replace(
                            'CREATE TABLE `'.$table.'` ('
                            ,
                            'CREATE TABLE IF NOT EXISTS `'.$table.'` ('
                            ,
                            $row2
                           );
                            
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT IGNORE INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n",PHP_EOL,$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('backups/DbBackups/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

        
        
        
        
    }
    
    
    