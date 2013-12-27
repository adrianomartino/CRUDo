<?php 
sleep(2);
mysql_connect("localhost", "root", "Attaccatialcazz0") or die('Could not connect to db: '.mysql_error());
mysql_select_db('test');

if(isset($_REQUEST['cap'])):
	$r = mysql_query('SELECT * FROM `_italia` WHERE `cap`='.mysql_real_escape_string($_REQUEST['cap']));
	
	for($data=array(); $row=mysql_fetch_assoc($r); $data[]=$row);

	if(count($data)>0)
		foreach($data as $record):?>
		<?php // The vertical lines are separator for the JS. You should keep them. ?>
		<option value="<?php echo $record['location_id']?>">
			<?php echo $record['comune']?> | (<?php echo $record['provincia']?>) | |
			Fraz. | <?php echo $record['frazione']?> | |
			<?php echo $record['regione']?>|
			<?php echo $record['Lat']?>|<?php echo $record['Lng']?>
			</span>
			
		</option>
		<?php endforeach;?>
<?php endif; ?>
Comune ( Provincia )
Fraz.  Frazione
Regione