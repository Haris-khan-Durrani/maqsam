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
    
     
//include 'db.php';
//Functionality done By HARIS KHAN DURRANI 
//here we are going to define call initiation how call intacts and how functions work here
//as you know call back24 have a lots of glitches so on that senerio we need some tables to work with so we can reassure our data works properly 
//lets initiate the call then hit with cron and intervals by using service id make one setting tabel as well where you can define setting for future
if($_POST['callinitiate'])
{
    $path = preg_replace( '/wp-content.*$/', '', __DIR__ );
 require_once( $path . 'wp-load.php' );
 include 'agentround.php';
 //https://positivezone.ae/api/myreturn.php
 
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
 $phone_number=$_POST['callinitiate']; 
 $agname=$_POST['client_name'];
  $type=$_POST['type'];
 //echo $apiep; 
 
$accessKey = $apck;
$accessSecret = $aps;

// API endpoint for conference requests
$conferenceEndpoint = $apiep;
$agent=around();
// Prepare data for the conference request
$requestData = array(
    "FirstParty" => "$agent",
    "SecondParty" => "$phone_number",
    "TuneUrl" => "$aptu",
    "ApologyUrl" => "$apurl",
    "ConfirmUrl" => "$apconf",
    "TimeoutUrl" => "$aptiurl",
    "FirstPartyMaxTrials" => "1",
    "CallbackUrl" => "https://api.ebmsportal.com/shopify/myfile.php?cback=$cback&agnm=$agname&client=$phone_number&agn=$agent&type=$type"
 
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
   // $decodedResponse = json_decode($response, true);
    if ($response !== null) {
        // Handle success, e.g., show a success message to the user
        echo "Conference request successful:", print_r($response, true);
    insertagentcall($type,$response,$agent,"Initiated");
        //file_get_contents("https://app.crmsoftware.ae/api/message.php?agent=+971562559270&client=+971562559270&country=AE&message=Hi+there  callback $plugin_directory_url");

    } else {
        // Handle error decoding JSON response
        echo "Error decoding JSON response";
    }
} else {
    // Handle empty response
    echo "Empty response received";
}

 
 
 
// //variable define
// $service_id=$_POST['service_id'];
// $phone_number=$_POST['callinitiate'];
// $cliname=$_POST['client_name'];

// $webiste=$_POST['website'];
// $titlewn=$_POST['title']; /* to get output show client name as well so it would be more easy to understand */
// $type=$_POST['type']; /* for example type = call */
    
// //referel URL
// $refu=$_POST['refu'];
// 	$webs=$_POST['webs'];
// $btk=$_POST['btk'];
// $hostWithoutExtension=$_POST['hostWithoutExtension'];    
    
// $params=array(
    
     
//     'service_id' => $service_id,
//      'phone_number' => "$phone_number",
//     'website' => "$webiste",
//     'title' => "$titlewn"."-".$cliname,
//     'type' => "$type",
  
//     'group' => null
// );
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, 'https://panel.callback24.io/api/v1/phoneCalls/addPhoneCall');
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Origin: '.$webs,
//     'Referer: https://easywaybusiness.ae',
//     'X-API-TOKEN: '.$btk,
// ));
// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

// // Send the request and get the response
// $response = curl_exec($curl);
// $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// // Check if there was an error
// if ($response === false) {
//     echo 'cURL Error: ' . curl_error($curl);
// } else if ($status_code !== 200) {
//     echo 'Error: HTTP Status Code ' . $status_code;
// } else {
//     // Handle the response
//   // echo "<pre>".$response."</pre>";
// $t=json_decode($response,true);
//     $cid=$t['id'];
//     $cn=$t['phone_num'];
//     //website
//      $web=$t['website'];
//      // Set the timezone to GMT+4
// $date = new DateTime('now', new DateTimeZone('GMT+4'));

// // Format the date and time
// $date_string = $date->format('Y-m-d H:i:s');

// // Output the date and time
// //echo "Current time in GMT+4: " . $date_string;
//     // $query="INSERT INTO `callin`(`callid`, `servid`, `clientname`, `number`, `website`, `ref`, `datettim`, `cpstat`) VALUES ('$cid','$service_id','$cliname','$cn','$web','$refu','$date_string','callinit')";
//   //   $run=mysqli_query($con,$query);
     
//     echo $cid;
// }

// // Close cURL session
// curl_close($curl);
// //var_dump($params);




    
    
    
}

//check call request if we got any id from calling widget then we will proceed with this ajax json request and will record in database as well also will apply condition
//if condition matched then will add tht query and create one lead in our crm
// if($_POST['sid_in']){
    
//     //get service id
//     $sid=$_POST['sid_in'];
	
//     $seid=$_POST['sid'];
// $webs=$_POST['webs'];
// $btk=$_POST['btk'];



// $params=array(
    
     
//     'call_id' => $sid
// );
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, 'https://panel.callback24.io/api/v1/phoneCalls/getCallInfo?call_id='.$sid);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Origin: '.$webs,
//     'Referer: https://easywaybusiness.ae',
//     'X-API-TOKEN: '.$btk,
// ));
// //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

// // Send the request and get the response
// $response = curl_exec($curl);
// $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// //echo $response;    
// $t=json_decode($response,true);    
//  //$t=json_decode($t);   
//   // print_r($t);
// //here we are getting user info
//   $crcvuser=$t['data']['user_id'];  
    
    
// //lets first fetch user data

// $curl2 = curl_init();
// curl_setopt($curl2, CURLOPT_URL,'https://panel.callback24.io/api/v1/users/get?id='.$crcvuser);
// curl_setopt($curl2, CURLOPT_GET, true);
// curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl2, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'X-API-TOKEN: '.$btk
// ));
// //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

// // Send the request and get the response
// $response2 = curl_exec($curl2);
// $status_code2 = curl_getinfo($curl2, CURLINFO_HTTP_CODE);

// //echo $response;    
// $t2=json_decode($response2,true);  

// //print_r($t2);

// echo $t2['first_name'];
    
    
// //lets create some cron job rows what we can do we will store data in our database to see sessoin is completed if there is user then status us call accept or reject 
// // with the help of this data we can trigger our cron and it is going to be very unique the we will trigger our push request
// // if($crcvuser!="")
// // {
    
    
// // }



    
    
// }







?>