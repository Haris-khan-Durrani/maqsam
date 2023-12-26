<?php
// Set error reporting to log all errors
error_reporting(E_ALL);
ini_set('display_errors', 0);  // Do not display errors on the web page
ini_set('log_errors', 1);      // Log errors to a file

// Set the path to the error log file
ini_set('error_log', 'error.log');

//header('Content-Type: application/json');
// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
  $path = preg_replace( '/wp-content.*$/', '', __DIR__ );
 require_once( $path . 'wp-load.php' );
 include 'agentround.php';  
// $jk=file_get_contents("https://app.crmsoftware.ae/api/message.php?agent=+971562559270&client=+971562559270&country=AE&message=This hit Perfectly");
// if($jk!=""){
$file2 = 'wa.json';
//$resulto = $_GET;
//$resulto = file_get_contents('php://input').$_GET.$_POST.$_REQUEST;
//$resulto =$_GET['lopio'];
// Get the protocol (http or https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the host
$host = $_SERVER['HTTP_HOST'];

// Get the current script's path
$path = $_SERVER['PHP_SELF'];

// Get the query string
$queryString = $_SERVER['QUERY_STRING'];

// Combine the components to get the complete URL with query string
$fullUrl = $protocol . '://' . $host . $path;

// Check if there is a query string and append it to the URL
if (!empty($queryString)) {
    $fullUrl .= '?' . $queryString;
}
$resulto=$fullUrl;
// Parse the URL to get the query string
$queryString = parse_url($resulto, PHP_URL_QUERY);

// Parse the query string to get individual parameters
parse_str($queryString, $params);
$ret=json_encode($params);
// Now $params contains an associative array of query string parameters
//print_r($params);


//all data feed properly
$t=file_put_contents($file2, $ret.PHP_EOL);

//get data from wa.json that comes from our third party url
$content = file_get_contents($file2);
// Decode JSON data into an associative array
$dataArray = json_decode($content, true);


/*
{"fpur":"busy","fpt":"1","fpc":"false","clientname":"Haris Khan","clientnum":" 971551651588","rcd":"","agnumber":" 971585747791","cback":"https:\/\/positivezone.ae\/wp-content\/plugins\/callback\/myreturn.php","cfid":"746030e497e446cca11dfda6fdce19d4","event":"first-party-unreachable","fst":"awaiting-first-party","tst":"terminated","spc":"false","spt":"0_"}
*/



// Extract the client name
$clientName= $dataArray["clientname"];
$clientnumb = $dataArray["clientnum"];
$firstpartytrials = $dataArray["fpt"];
$firstpartyconnected = $dataArray["fpc"];
$firstpartyunreachablereason = $dataArray["fpur"];
$recordingurl = $dataArray["rcd"];
$callbackurl = $dataArray["cback"];
$cfid = $dataArray["cfid"];
$secondpartyconnected = $dataArray["spc"];
$event = $dataArray["event"];
$callcode = $dataArray["callcode"];
$agnum=$dataArray["agnumber"];
$spt=$dataArray["spt"];

//maqsam round robin limit
$maqr=esc_attr(get_option('maqsam_rr'));
global $wpdb;

    // Define the table name
$table_name = $wpdb->prefix . 'callrec'; 
// Replace 'your_table_name' with the actual table name

// Perform a SELECT COUNT(*) query
//$count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where callinit=$callcode");

// Prepare the SQL query with placeholders
$query = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE callinit = %s", $callcode);

// Execute the query
$count = $wpdb->get_var($query);

//    insertagentcall($response,$callref,$agent,$callstatus)

//if my condition found recording it will stop other condition to run





// $plugin_directory_url = urlencode(plugins_url()."/callback/myreturn.php");
$plugin_directory_url = "https://api.ebmsportal.com/shopify/myfile.php";
//if call initiate then run this code with the help of this code we will get our call Id that ID is going to help in future if office timing is finished and 
//no one receive call it will store data and set cron so if agent receive call next day then it will trigger data to our API so with this we can trigger
//now set the variables to initiate call and store data this will help to summrized our fields and their data
  $apiep=esc_attr(get_option('maqsam_api_endpoint'));
  $apck=esc_attr(get_option('maqsam_access_key'));
  $aps=esc_attr(get_option('maqsam_access_secret'));
  $aptu=esc_attr(get_option('maqsam_tune_url'));
  $apurl=esc_attr(get_option('maqsam_ApologyUrl'));
  $apconf=esc_attr(get_option('maqsam_confirmUrl'));
  $aptiurl=esc_attr(get_option('maqsam_timeoutUrl'));
  //maqsam_CallbackUrl
  $cback=esc_attr(get_option('maqsam_CallbackUrl'));
  
  //push data with recording 
  //ignore this agdet($agent_mobile)
   $prcd=esc_attr(get_option('maqsam_prcd'));
   //push data if not receive by anyone  
   $nrcd=esc_attr(get_option('maqsam_nrcd'));
      //push data if client Terminated3 times 
   $crcd=esc_attr(get_option('maqsam_crcd'));
   
   
 $phone_number=$clientnumb; 
 $agname=$_POST['client_name'];
 //echo $apiep; 
$accessKey = $apck;
$accessSecret = $aps;
// API endpoint for conference requests
$conferenceEndpoint = $apiep;

$agnum = str_replace("+", "", $agnum);
$agent_name=agdet($agnum);








if($recordingurl!="")
{
    $recordingurl=urlencode($recordingurl);
 $jk=file_get_contents("https://app.crmsoftware.ae/api/message.php?agent=+971562559270&client=+971562559270&country=AE&message=$recordingurl Recorded File");   
      insertagentcall($callcode,$cfid,$agnum,"Call Done");
      $agnum = str_replace("+", "", $agnum);
      $agent_name=agdet($agnum);
      file_get_contents("$prcd?cback=$cback&clientname=$clientName&client=$phone_number&argn=$clientnumb&type=$callcode&agentname=$agent_name&agentnumber=$agnum&recordingurl=$recordingurl");
}


//if second party trial is 3 then run this
else if($spt==3){
        $recordingurl=urlencode($recordingurl);
 $jk=file_get_contents("https://app.crmsoftware.ae/api/message.php?agent=+971562559270&client=+971562559270&country=AE&message=$recordingurl Recorded File");   
      insertagentcall($callcode,$cfid,$agnum,"Client Terminated After 3rd time");
      $agnum = str_replace("+", "", $agnum);
      $agent_name=agdet($agnum);
      file_get_contents("$crcd?cback=$cback&clientname=$clientName&client=$phone_number&argn=$clientnumb&type=$callcode&agentname=$agent_name&agentnumber=$agnum&recordingurl=$recordingurl");
}


//else run this on loop

else if($firstpartytrials=="1" && $firstpartyconnected=="false" && $event=="first-party-unreachable")
{
if ($count < $maqr) {    
// Prepare data for the conference request
$agent=around();
$requestData = array(
    "FirstParty" => "$agent",
    "SecondParty" => "$clientnumb",
    "TuneUrl" => "$aptu",
    "ApologyUrl" => "$apurl",
    "ConfirmUrl" => "$apconf",
    "TimeoutUrl" => "$aptiurl",
    "FirstPartyMaxTrials" => "1",
    "CallbackUrl" => "https://api.ebmsportal.com/shopify/myfile.php?cback=$cback&agnm=$clientName&client=$phone_number&agn=$clientnumb&type=$callcode"
);
// Convert request data to x-www-form-urlencoded format
$requestDataString = http_build_query($requestData);
// Initialize cURL session
$ch = curl_init($conferenceEndpoint);
// Set cURL options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the Authorization header
$headers = array(
    'Authorization: Basic ' . base64_encode($accessKey . ':' . $accessSecret),
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Execute cURL session
$response = curl_exec($ch);
// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
// Close cURL session
curl_close($ch);
// Handle the response
if (!empty($response)) {
    if ($response !== null) {
        echo "Conference request successful:", print_r($response, true)." https://api.ebmsportal.com/shopify/myfile.php -> $agent";
    file_get_contents("https://app.crmsoftware.ae/api/message.php?agent=+971562559270&client=+971562559270&country=AE&message=$agent Call $count initiated $response");
        insertagentcall($callcode,$cfid,$agnum,"Unreachable");
    } else {
        echo "Error decoding JSON response";
    }
} else {
    echo "Empty response received";
}


}

else{
 
 //if both condition wont match hit this
    // Define a variable to keep track of whether the URL has been hit
$hasBeenHit = false;

// Check if the URL has not been hit before
if (!$hasBeenHit) {
    // Your original code to make the request
    file_get_contents("$nrcd?cback=$cback&clientname=$clientName&client=$phone_number&argn=$clientnumb&type=$callcode");

    // Set the flag to true to indicate that the URL has been hit
    $hasBeenHit = true;
} else {
    // The URL has already been hit, you can handle this case as needed
    echo "URL has already been hit.";
}
       // insertagentcall($callcode,$cfid,$agnum,"Unreachable");
}


}

//if nothing is match just hit this url for new lead


?>