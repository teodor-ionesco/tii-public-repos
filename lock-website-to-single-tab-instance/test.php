<?php

// STEP I: Define globals
$mysql  = new mysqli("localhost", "mysqli username", "mysqli password", "mysqli database name"); // MySQLi object
$ip     = $_SERVER["REMOTE_ADDR"];								// Client IP
$hash   = password_hash(time(). $ip, PASSWORD_DEFAULT);						// Generate unique key per request; check http://php.net/password_hash

if(isset($_GET["drop_key"]) && $_GET["drop_key"] == true)
{
	$mysql -> query("DELETE FROM test_keys WHERE test_keys.ip = '$ip';");	// Expire old keys;
	
	header("Cache-Contro: no-cache, no-store", true);	// Do not cache redirect
	header("Location: http://www.google.com", true, 301);	// Redirect to google aka exit website
}

if(isset($_GET["_key"]) && $_GET["_key"])	// Check if _key is defined and is not null in GET request
{
    $key = $mysql -> real_escape_string($_GET["_key"]);		// Prevent SQL injections
    $fetched = $mysql -> query("SELECT * FROM test_keys WHERE test_keys._key = '$key' AND test_keys.ip = '$ip';");// Retrieve the row which has assigned the _key and the client IP
    
    if($fetched -> num_rows > 0)	// If row has been retrieved, it means the client has accessed the site at least once;
					// A uniques key already exist; but we will inject a new one and expire the old one.
    {
        $mysql -> query("DELETE FROM test_keys WHERE test_keys.ip = '$ip';");	// Expire old keys;
        $mysql -> query("INSERT INTO test_keys(_key, ip) VALUES('$hash', '$ip');");	// Inject the new key
        
        die("<a href=\"?_key=$hash\">Access this instance only.</a> Try now to access your site in another tab :)<br><a href=\"?_key=$hash&drop_key=true\">Drop key.</a>");	// As you can see, href="?_key" where _key = the new generated key
    }
    else
    {
        die("Client attempted to access site from another instance. Operation dropped. <a href=\"?_key=$hash&drop_key=true\">Drop key and retry.</a>");	//  If no result is returned, but has a _key has been provided 
																			// maybe client is trying to access the site either with an expired key, either with a forged one;
																			// In either case, drop the operation;
    }
}
else	// STEP II: Inject unique key
{
    $fetched = $mysql -> query("SELECT * FROM test_keys WHERE test_keys.ip = '$ip';"); // Check if IP is registered into database;
    
    if($fetched -> num_rows > 0)	// If IP is registered into database, it means the client already accessed this site but provides no key;
					// We don't allow new site instances, therefore we drop this operation
    {
        die("Client attempted to access site from another instance. Operation dropped. <a href=\"?_key=$hash&drop_key=true\">Drop key and retry.</a>");
    }
    else
    {
        $mysql -> query("INSERT INTO test_keys(_key, ip) VALUES('$hash', '$ip');"); 	// Inject new key

        die("<a href=\"?_key=$hash\">Access this instance only.</a>  Try now to access your site in another tab :) <br> <a href=\"?_key=$hash&drop_key=true\">Drop key.</a>"); // As you can see, href="?_key" where _key = the new generated key
    }
}

