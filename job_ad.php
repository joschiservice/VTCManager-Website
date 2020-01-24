<?php 
//GET request parameters
$requested_ad_id = $_GET['id'];

//connect to DB
$host = 'localhost:3306';
$conn = mysqli_connect($host, "system_user_vtc", "8rh98w23nrfubsediofnm<pbi9ufuoipbgiwtFFF","vtcmanager"); 
if(! $conn )  
{
	die("Can't connect to database");  
}  

//hole Informationen der Stellenanzeige
$sql = "SELECT * FROM job_market WHERE AdID=$requested_ad_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$byCompanyID = $row["byCompanyID"];
		$AdID = $row["AdID"];
		$rank = $row["rank"];
		
		//hole Firmenname der Stellenanzeige
		$sql2 = "SELECT * FROM company_information_table WHERE id=$byCompanyID";
		$result2 = $conn->query($sql2);
		if ($result2->num_rows > 0) {
			while($row = $result2->fetch_assoc()) {
				$byCompanyname = $row["name"];
			}
		}?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<title><?php echo $byCompanyname; ?> - VTCManager</title>
		<?php include 'basis_header.php'; ?>  
	</head>
	<body>
		<?php include 'navbar.php'; ?>  
		<footer class="footer">
			<div class="container">
				<?php 
		//lade Beschreibung der Stellenanzeige
		$job_desc = file_get_contents("https://vtc.northwestvideo.de/media/articles/ad_description/".$AdID.'.txt');
		//Ausgabe der gesamten Stellenanzeige
		echo <<<EOT
		<h2>$byCompanyname - $rank gesucht!</h2>
		<p>$job_desc</p>
		EOT;
	}
}?>
				<button type="button" class="btn btn-success" onclick="location.href = 'https://vtc.northwestvideo.de/company/apply?ad_id=<?php echo $AdID;?>';">Bewerben</button>
				<hr>
				<br>
				<p>Seite neu laden um weitere Ergebnisse zu sehen.</p>
				<br>
            <div class="col-md-9 social-media">
                <p class="pull-left">
                    <a href="https://vtc.northwestvideo.de/impressum">Impressum</a>|
                    <a href="https://vtc.northwestvideo.de/datenschutz">Datenschutz &amp; Nutzungsbedingungen</a>
                </p>
            </div>
            <div class="col-md-3">
                <p class="pull-right">© NorthWestMedia 2019-2020</p>
            </div>
                    </div>
    </footer>
  </body>
</html>
