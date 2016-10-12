
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="test.css" rel="stylesheet">
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <title>PackingSheets - Login</title>
  </head>
  <body>
    <div class="container">
        <?php
        include_once('header.php');
        ?>
        <div class="jumbotron vertical-center">
          <div class="container-fluid">
            <div class="container"><h2>Login <br>
              <small>Log in to access PackingSheets features</small></h2></div>
            </div>
            <div class='container-fluid'>
              <?php
              function get_groups() {
              	// Active Directory server
              	$ldap_host = "172.30.40.190";

              	// Active Directory DN, base path for our querying user
              	$ldap_dn = "OU=Users,OU=BRU,DC=company,DC=corp";

                if(isset($_POST['username']) && isset($_POST['password'])){
                  $username = $_POST['username'];
                  $pass = $_POST['password'];
                  //echo var_dump ($username);
                  //echo var_dump ($pass);

                	// Active Directory user for querying
                	$query_user = "$username"."@company.corp";
                	$password = "$pass";

                	// Connect to AD
                  echo "Connecting as ".$username;
                	$ldap = ldap_connect($ldap_host) or die("Could not connect to LDAP");
                	ldap_bind($ldap,$query_user,$password) or die("Could not bind to LDAP");

                	// Search AD
                	$results = ldap_search($ldap,$ldap_dn,"(samaccountname=$username)",array("memberof","primarygroupid"));
                	$entries = ldap_get_entries($ldap, $results);
                  //echo var_dump ($entries);

                	// No information found, bad user
                	if($entries['count'] == 0) return false;

                	// Get groups and primary group token
                	$output = $entries[0]['memberof'];
                	$token = $entries[0]['primarygroupid'][0];

                	// Remove extraneous first entry
                	array_shift($output);

                	// We need to look up the primary group, get list of all groups
                	$results2 = ldap_search($ldap,$ldap_dn,"(objectcategory=group)",array("distinguishedname","primarygrouptoken"));
                	$entries2 = ldap_get_entries($ldap, $results2);

                	// Remove extraneous first entry
                	array_shift($entries2);

                	// Loop through and find group with a matching primary group token
                	foreach($entries2 as $e) {
                		if($e['primarygrouptoken'][0] == $token) {
                			// Primary group found, add it to output array
                			$output[] = $e['distinguishedname'][0];
                			// Break loop
                			break;
                	   }
                	}
                  $outputStr = implode(' ', $output);
                  //echo $outputStr;

                  if (strpos($outputStr,'OU=PackingSheet') !== false) {echo '<div class="alert alert-success">
                          <strong>Authentication success </strong> Login complete. </div>';}
                  else {echo '<div class="alert alert-warning">
                          <strong>Authentication fail </strong> Please make sure you are allowed to use this software. </div>';}
              }
            }

            // Example Usage
            //print_r(get_groups("a12306"));
            get_groups();
            ?>
            </div>
            <div class="container">
              <form action="#" method="POST">
                <div class="form-group">
                  <label for="username">Username:</label><input id="username" type="text" name="username" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="password">Password:</label><input id="password" type="password" name="password" class="form-control"/>
                </div>
                <div class="checkbox">
                  <label><input type="checkbox"> Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
              </form>
            </div>
          </p>
        <?php
        include_once('footer.php');
        ?>
    </div>
  </body>
</html>
