<?php 
/**
 * Plugin Name: Maqsam Call Widget
 * Plugin URI: https://www.linkedin.com/in/haris-khan-durrani/
 * Description: Maqsam Call Widget Popup Widget Maker With code Functionality where you need to set your settings and create your own call widget by doing some minor settings
 * Version: 1.0
 * Author: Haris khan Durrani
 * Author URI: https://www.linkedin.com/in/haris-khan-durrani/
 */
// function enqueue_scripts_only_if_page_using_shortcode()
// {
//     global $post;
//     $suffix =  mt_rand(1000, 9999);
//     if (has_shortcode($post->post_content, 'Quote_Calculator') && (is_single() || is_page())) {
//         wp_enqueue_style('intlTelInput-css', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.5/build/css/intlTelInput.min.css');
//         wp_enqueue_script('calculator-init', plugin_dir_url(_FILE_) . 'js/calculator-init.js?v123='.$suffix);

        
//         wp_enqueue_script('calculator-step-js', plugin_dir_url(_FILE_) . 'js/calculator-step.js?v123='.$suffix, '', '', true);
//         wp_enqueue_style('calculator-step-css', plugin_dir_url(_FILE_) . 'css/calculator-step.css');
//         wp_enqueue_style('bs5-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css');
//         wp_enqueue_style('calculator-style-css', plugin_dir_url(_FILE_) . 'css/calculator-style.css');
//         wp_enqueue_script('iti-load-utils', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js?v123='.$suffix, '', '', true);
//         wp_enqueue_script('intlTelInput-js', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.5/build/js/intlTelInput.min.js?v123='.$suffix, '', '', true);
//         wp_enqueue_script('calculator-app', plugin_dir_url(_FILE_) . 'js/calculator-app.js?v123='.$suffix, '', '', true);
//         wp_enqueue_script('bs5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js?v123='.$suffix, '', '', true);
//         wp_enqueue_script('jquery');
//     }
// }

// Add the plugin settings page to the WordPress admin menu
add_action('admin_menu', 'my_plugin_settings_page');
  $suffix =  mt_rand(1000, 9999);
function my_plugin_settings_page() {
    add_menu_page(
        'My Plugin Settings',
        'Maqsam Call Widget',
        'manage_options',
        'my-plugin-settings',
        'my_plugin_settings_page_callback'
    );
     add_submenu_page(
        'my-plugin-settings',
        'Maqsam API Settings',
        'Api Settings',
        'manage_options',
        'maqsam-api-settings',
        'maqsam_api_settings_page'
    );
    // Add submenu page for managing agents
// add_submenu_page(
//     'my-plugin-settings', // Parent slug (the slug of the main menu page)
//     'Manage Agents',
//     'Manage Agents',
//     'manage_options',
//     'manage-agents',
//     'manage_agents_page_callback'
// );
// add_submenu_page(
//      'my-plugin-settings',
//     'View Agent',
//     'View Agent',
//     'manage_options',
//     'view-agent',
//     'view_agent_page_callback'
// );
}
// Define the plugin directory path
define( 'MY_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );


// Register a custom post type for Agents
function register_agent_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Maqsam Agents',
        'supports' => array('title'),
         'labels' => array(
            'name' => 'Agents',
            'singular_name' => 'Agent',
            'add_new' => 'Add Agent',
            'add_new_item' => 'Add New Agent',
            'edit_item' => 'Edit Agent',
            'new_item' => 'New Agent',
            'view_item' => 'View Agent',
            'view_items' => 'View Agents',
            'search_items' => 'Search Agents',
            'not_found' => 'No agents found',
            'not_found_in_trash' => 'No agents found in trash',
            'all_items' => 'All Agents',
        ),
        // Add more arguments as needed
    );
    register_post_type('agent', $args);
}
add_action('init', 'register_agent_post_type');

// Add custom meta boxes for Username and Mobile Number
function add_agent_meta_boxes() {
    add_meta_box(
        'agent_username',
        'Username',
        'agent_username_meta_box_callback',
        'agent',
        'normal',
        'default'
    );

    add_meta_box(
        'agent_mobile',
        'Mobile Number',
        'agent_mobile_meta_box_callback',
        'agent',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_agent_meta_boxes');

// Callback function for the Username meta box
function agent_username_meta_box_callback($post) {
    $username = get_post_meta($post->ID, '_agent_username', true);
    ?>
    <label for="agent_username">Username:</label>
    <input type="text" name="agent_username" id="agent_username" value="<?php echo esc_attr($username); ?>">
    <?php
}

// Callback function for the Mobile Number meta box
function agent_mobile_meta_box_callback($post) {
    $mobile = get_post_meta($post->ID, '_agent_mobile', true);
    ?>
    <label for="agent_mobile">Mobile Number:</label>
    <input type="text" name="agent_mobile" id="agent_mobile" value="<?php echo esc_attr($mobile); ?>">
    <?php
}

// Save custom meta box data when saving the post
function save_agent_meta_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'agent' === $_POST['post_type']) {
        if (isset($_POST['agent_username'])) {
            update_post_meta($post_id, '_agent_username', sanitize_text_field($_POST['agent_username']));
        }

        if (isset($_POST['agent_mobile'])) {
            update_post_meta($post_id, '_agent_mobile', sanitize_text_field($_POST['agent_mobile']));
        }
    }
}
add_action('save_post', 'save_agent_meta_data');
// Callback function to display the plugin settings page
function my_plugin_settings_page_callback() {
    ?>
    <div class="wrap">
        <div><img src="https://assets-global.website-files.com/61bf04d065d458b90c69aae4/61bf2e370248ef1f63f0bc9c_maqsam-logo-en-p-500.png" style="width:150px">
        </div>
        <h1>Maqsam caLL Apperance Setting for Widget</h1>
		   Shortcode
        <input type="text" value="[my_shortcode]"/>
        <form method="post" action="options.php">
            <?php
            settings_fields('my_plugin_settings');
            do_settings_sections('my_plugin_settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// Register the plugin settings
add_action('admin_init', 'my_plugin_register_settings');

function my_plugin_register_settings() {
    register_setting(
        'my_plugin_settings',
        'my_plugin_options',
        'my_plugin_sanitize_options'
    );

    add_settings_section(
        'my_plugin_section',
        'Set You Settings Here',
        'my_plugin_section_callback',
        'my_plugin_settings'
    );

    add_settings_field(
        'my_plugin_option_1',
        'Widget Logo URL',
        'my_plugin_option_1_callback',
        'my_plugin_settings',
        'my_plugin_section'
    );



//if you want to add more fields just add these function and with the help of these function you can manage your more fields



 

    add_settings_field(
        'my_plugin_option_4',
        'Base Color',
        'my_plugin_option_4_callback',
        'my_plugin_settings',
        'my_plugin_section'
    );

	
	    add_settings_field(
        'my_plugin_option_5',
        'Powered By',
        'my_plugin_option_5_callback',
        'my_plugin_settings',
        'my_plugin_section'
    );
	
	
	  add_settings_field(
        'my_plugin_option_6',
        'Enable in Whole website',
        'my_plugin_option_6_callback',
        'my_plugin_settings',
        'my_plugin_section'
    );
	
	
	add_settings_field(
        'my_plugin_option_7',
        'Register website',
        'my_plugin_option_7_callback',
        'my_plugin_settings',
        'my_plugin_section'
    );




    // Add more settings fields as needed
}

// Callback function to display the plugin settings section
function my_plugin_section_callback() {
    echo '<p>Enter your plugin settings below:</p>';
}

// Callback function to display the Option 1 field
function my_plugin_option_1_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['option_1']) ? $options['option_1'] : '';
    echo '<input type="text" name="my_plugin_options[option_1]" value="' . esc_attr($value) . '">';
}






function my_plugin_option_4_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['option_4']) ? $options['option_4'] : '';
    echo '<input type="color" name="my_plugin_options[option_4]" value="' . esc_attr($value) . '">';
}

function my_plugin_option_5_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['option_5']) ? $options['option_5'] : '';
    echo '<input type="text" name="my_plugin_options[option_5]" value="' . esc_attr($value) . '">';
}


function my_plugin_option_6_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['option_6']) ? $options['option_6'] : '';
    echo '<input type="text" name="my_plugin_options[option_6]" value="' . esc_attr($value) . '"> (please type yes to enable )';
}



function my_plugin_option_7_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['option_7']) ? $options['option_7'] : '';
    echo '<input type="text" name="my_plugin_options[option_7]" value="' . esc_attr($value) . '"> (please type in this format (https://abc.com) )';
}


// Sanitize the plugin options
function my_plugin_sanitize_options($options) {
    $sanitized_options = array();
    if (isset($options['option_1'])) {
        $sanitized_options['option_1'] = sanitize_text_field($options['option_1']);
    }

   
    
    if (isset($options['option_4'])) {
        $sanitized_options['option_4'] = sanitize_text_field($options['option_4']);
    }
	    if (isset($options['option_5'])) {
        $sanitized_options['option_5'] = sanitize_text_field($options['option_5']);
    }
	
	   if (isset($options['option_6'])) {
        $sanitized_options['option_6'] = sanitize_text_field($options['option_6']);
    }
	
	  if (isset($options['option_7'])) {
        $sanitized_options['option_7'] = sanitize_text_field($options['option_7']);
    }
    // Sanitize more options as needed
    return $sanitized_options;
}

// Save the plugin settings
add_action('admin_init', 'my_plugin_save_settings');

function my_plugin_save_settings() {
    if (isset($_POST['my_plugin_options'])) {
        $options = $_POST['my_plugin_options'];
        update_option('my_plugin_options', $options);
    }
}




//callback function
function my_shortcode_function(  ) {
    // Parse the shortcode attributes
    // $atts = shortcode_atts( array(
    //     'message' => 'Hello, World!',
    //     'color' => '#000000'
    // ), $atts );

    // Generate the output for logo
$options = get_option('my_plugin_options');
$logourl = isset($options['option_1']) ? $options['option_1'] : '';





//generate output for btk
$btk = get_option('my_plugin_options');
$btk = isset($btk['option_3']) ? $btk['option_3'] : '';



//generate output for base color
$basecolor = get_option('my_plugin_options');
$bc = isset($basecolor['option_4']) ? $basecolor['option_4'] : '';
	
	
	
//generate output for base color
$pw = get_option('my_plugin_options');
$pow = isset($pw['option_5']) ? $pw['option_5'] : '';

//echo MY_PLUGIN_DIR_PATH;
require_once  MY_PLUGIN_DIR_PATH . 'callme.php';
    // Return the output
    //return $value;
}

// Register the shortcode
add_shortcode( 'my_shortcode', 'my_shortcode_function' );




function headcode(){
	
//generate output for service id
$options2 = get_option('my_plugin_options');
$sid = isset($options2['option_2']) ? $options2['option_2'] : '';
	
	//generate output for btk
$btk = get_option('my_plugin_options');
$btk = isset($btk['option_3']) ? $btk['option_3'] : '';
	
	

	//generate output for btk
$webrefrer = get_option('my_plugin_options');
$webrefrer = isset($btk['option_7']) ? $btk['option_7'] : '';	
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/js/intlTelInput.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/css/intlTelInput.css" >
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/js/intlTelInput.js"></script>


<script>


// jQuery(document).ready(function(){
//     var input = document.querySelector("#phone");
//   var iti = intlTelInput(input, {
    
//     initialCountry: "ae",


//   });

  //})
  var input = document.querySelector("#phone");
  var iti = intlTelInput(input, {
    
    initialCountry: "ae",


  });

// $("#mymy").intlTelInput({
//   initialCountry: "auto",
// 	separateDialCode: false,
//   formatOnDisplay: true,
// 	nationalMode: false,
// 	// allowDropdown: false,
//   geoIpLookup: function(callback) {
//     $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
//       var countryCode = (resp && resp.country) ? resp.country : "";
//       callback(countryCode);
//     });
//   },
//   utilsScript: "../../build/js/utils.js?1562189064761",
//   utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js",
// 	preferredCountries: [],
// });

//     function resetIntlTelInput() {
//       if (typeof intlTelInputUtils !== 'undefined') { // utils are lazy loaded, so must check
//           var currentText = telInput.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
//           if (typeof currentText === 'string') { // sometimes the currentText is an object :)
//               telInput.intlTelInput('setNumber', currentText); // will autoformat because of formatOnDisplay=true
//           }
//       }
//     }








     jQuery(document).ready(function($) {
        $('.iti__flag-container').click(function() { 
          var countryCode = $('.iti__selected-flag').attr('title');
          var countryCode = countryCode.replace(/[^0-9]/g,'')
          $('#form-field-Mobnum').val("");
          $('#form-field-Mobnum').val("+"+countryCode+" "+ $('#form-field-Mobnum').val());
       });
		    console.log("<?php echo $sid; ?>");
  
	 setTimeout(function(){
jQuery(".Harismodal").removeAttr('style');
		 console.log("%c Quick Call Loaded Successfull %c","font-weight:bold;background:#E4FF1A;color:#00A3FF;font-size:18px","");
},2000);
	 
	 });


    function callnow(){
        
    //here we are going to get ref url
    // Get the title of the current website page
var title = $(document).prop('title');
// Get the current URL
var urll = window.location.href;
var referralUrl = document.referrer;
if(referralUrl==""){
var refu="https://easywaybusiness.ae/";
	 }
		else{
			refu=referralUrl;
		}
// Extract the hostname from the referral URL
var url = new URL(refu);
var hostname = url.hostname;

// Remove the protocol from the hostname
var protocol = `${url.protocol}//`;
var hostWithoutProtocol = hostname.replace(protocol, "");

// Remove the `www` prefix from the hostname
var hostWithoutWww = hostWithoutProtocol.replace(/^www\./, "");

// Remove the extension from the hostname
var hostWithoutExtension = hostWithoutWww.replace(/\.[^/.]+$/, "");

// Log the hostname without the `www` prefix, extension, or protocol to the console
console.log("Referral hostname:", hostWithoutExtension);

//got one


        
        
       //   var input = document.querySelector("#phone");
     //     var iti = intlTelInput(input);
       //console.log("i am Clicked"+input);
        var tl=30;

//create validation code if matched then trigger
var name=jQuery("#widgetModal-clientName").val();
var phon=jQuery('#phone').val();
// var error = iti.getValidationError();
// Get the phone number entered by the user
var phoneNumber = iti.getNumber();

// Check if the phone number is valid
if (iti.isValidNumber() && name!=undefined && name!="") {
  console.log("Valid phone number: " + phoneNumber);
  
 //here we got exact number as we rewuired
 console.log(phoneNumber);
   jQuery('.mainform').html('   <div class="d-flex text-bold justify-content-center align-items-center" id="timer"></div>');
      timerstart(30)
      callact(tl,phoneNumber,name,refu,hostWithoutExtension,title,urll);
   
   
   
} else {
  console.log("Invalid phone number: " + phoneNumber);
  
  error="Invalid Name / Invalid phone number: " + phoneNumber;
jQuery('.errordiv').html('<div class="errormessage">'+error+'</div>');
  
}

// if(name==undefined || name==""){
// error="Please Insert Your Name";
// jQuery('.errordiv').html('<div class="errormessage">'+error+'</div>');
// //alert("yoo");
// }
// else if(phon==undefined || phon===""){
//     error="Please Insert Your Phone Numer";
//     jQuery('.errordiv').html('<div class="errormessage">'+error+'</div>');
// }

//errormessage
// else{
//         callact(tl);
// }


    }

function callact(tl,phoneNumber,name,refu,hostWithoutExtension,title,urll){
  
   // Define possible characters for the code
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

      // Generate a random code of length 8
      var randomCode = '';
      for (var i = 0; i < 8; i++) {
        var randomIndex = Math.floor(Math.random() * characters.length);
        randomCode += characters.charAt(randomIndex);
      }
  
  
    //var time_limit = tl;
  
	    var web="<?php echo $webrefrer; ?>";
    console.log("<?php echo $btk; ?>");
    //here we are going to run our ajax to see what output we are getting 
    jQuery.ajax({
        url: "<?php echo plugin_dir_url(__FILE__).'ajax.php?rt='.$suffix ?>",
      //  url: "https://callback.test/wp-content/plugins/callback/ajax.php",
    
        //http://callback.test/wp-content/plugins/callback/ajax.php
        type: 'post',
       
        data: {
          callinitiate: phoneNumber,
       //   service_id:service_id,
 
			webs:"<?php echo $webrefrer; ?>",
          client_name:name,
          website:urll,
          title:title,
          type:randomCode,
          refu:refu,
          hostWithoutExtension:hostWithoutExtension
        },
        success: function( request ) {

                //  jQuery('.showcontent').html(data);
                  
                  console.log(request+"->"+randomCode);
                  
                  
                  
                  //  $('.mainform').html('<div>'+data+'</div>');

        },
        error : function(request,error)
                {
                    console.log("Request error : "+JSON.stringify(request));
                }
      });
    
    
//});
    
    
    
    
    
    
    
    






}


//In this function we will start timer with call request so whenver call second hit our api will redirect us to callback api so with the help of that api we can see who is receiving the call and call is finished or not
function timerstart(tl){
    
    //here we will change 2 headings
    
    var time_limit = tl;
        var time_out = setInterval(() => {
if(time_limit == 0) {
  $('.mainform').html('<h2 style="text-align:center" class="callrequesid">Hi '+name+'! You will receive a call from our agent shortly</h2>');
} else {
  if(time_limit < 10) {
  //  getagendetail(cid,name,web);
      
    time_limit = 0 + '' + time_limit;
  }
  $('#timer').html('00:' + time_limit);
//  jQuery('#timer').addClass("call"+cid);
  time_limit -= 1; 
}
}, 1000);
    
}

//with the help of timerstart we will shoot cron request so it will insert our request in database so we can see the resul and outcome then we can push ou r request to CRM
function getagendetail(cid,name,web){
     jQuery.ajax({
        url: "<?php echo plugin_dir_url(__FILE__).'ajax.php?rt='.$suffix ?>",
        type: 'post',
       // dataType: "json",
        data: {
          sid_in: cid,
			webs:web,
			btk:"<?php echo $btk; ?>",
			sid:"<?php echo $sid; ?>"
        },
        success: function( data ) {

                //  jQuery('.showcontent').html(data);
                  
                  console.log(data);
                 //  return data;
                   
                    // var agendt= getagendetail(cid);
      if(data!="" && data!=undefined){
           $('.mainform').html('<h2 style="text-align:center" class="callrequesid'+cid+'">Hi '+name+'! '+data+' is calling you.</h2>');
      }
                   
                 //timerstart(tl,data,name)
                  
                  //  $('.mainform').html('<div>'+data+'</div>');

        },
        error : function(request,error)
                {
                    console.log("Request error : "+JSON.stringify(request));
                }
      });
    
}
console.log("Bhaya");
</script>

<?php



}
add_action('wp_footer', 'headcode',10);



function headache(){
    $suffix =  mt_rand(1000, 9999);
    wp_enqueue_style('intlTelInput-css', plugin_dir_url(__FILE__).'style.css?asdas=4546');
           wp_enqueue_script('iti-load-utils', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js?v123='.$suffix, '', '', true);
           wp_enqueue_script('intlTelInput', 'https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/js/intlTelInput.js?v123='.$suffix, '', '', true);
           wp_enqueue_script('intlTelInput-js', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.5/build/js/intlTelInput.min.js?v123='.$suffix, '', '', true);
          // wp_enqueue_script('jqquery', 'https://code.jquery.com/jquery-2.2.4.min.js?v123='.$suffix, '', '', true);
          // wp_enqueue_script('jqquery', 'https://code.jquery.com/jquery-2.2.4.min.js?v123='.$suffix, '', '', true);
   
           
           wp_enqueue_style('intlTelInput-css', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.5/build/css/intlTelInput.min.css');
           wp_enqueue_script('jquery');
}
add_action('wp_footer', 'headache',1);






//condition matched or not
function my_shortcode_in_head() {
	$p = get_option('my_plugin_options');
$data = isset($p['option_6']) ? $p['option_6'] : '';
  //$data = ''; // Set the default value of the data variable
  

  
  // Output the shortcode in the head section if data is available
  if ($data=="yes") {
    add_action('wp_head', function() use ($data) {
      echo do_shortcode('[my_shortcode]');
    });
  }
}
add_action('init', 'my_shortcode_in_head');





// Hook activation function
register_activation_hook(__FILE__, 'loadtablein');

// Activation function
function loadtablein() {
    global $wpdb;

    // Define the table name
    $table_name = $wpdb->prefix . 'callrec';

    // Define the SQL query to create the table
    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        callinit VARCHAR(255) NOT NULL,
        calref VARCHAR(255) NOT NULL,
        agent VARCHAR(255) NOT NULL,
        astatus VARCHAR(255) NOT NULL,
	completelog longtext DEFAULT NULL,
 	callon datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Include the upgrade file
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL query
    dbDelta($sql);
}



function insertagentcall($callinit_value,$callref,$callagnt,$callstatus,$log){
    global $wpdb;
$table_name = $wpdb->prefix.'callrec'; 
$data = array(
    'callinit' => $callinit_value,
    'calref'   => $callref,
    'agent'    => $callagnt,
    'astatus'  => $callstatus,
    'completelog'=>$log,
);
$format = array(
    '%s', // for string
    '%s', // for string
    '%s', // for string
    '%s', // for string
     '%s', // for string
);
$wpdb->insert($table_name, $data, $format);
}



function insertagentcalllog($callinit_value,$log){
    global $wpdb;
$table_name = $wpdb->prefix . 'calllog'; 
$data = array(
    'callid' => $callinit_value,
   
    'callog'=>$log,
);
$format = array(
    '%s', // for string
    '%s', // for string
 
);
$wpdb->insert($table_name, $data, $format);
}


// Step 1: Add a new submenu for displaying the call records
function add_call_records_submenu() {
    add_submenu_page(
        'my-plugin-settings',  // parent slug
        'Call Records',        // page title
        'Call Records',        // menu title
        'manage_options',      // capability
        'call-records',        // menu slug
        'display_call_records' // function to display the page content
    );
}
add_action('admin_menu', 'add_call_records_submenu');

// Step 1: Function to display data from wp_callrec with new columns
function display_call_records() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'callrec';
    $per_page = 10; // Number of records per page
    $page = isset($_GET['paged']) ? max(0, intval($_GET['paged']) - 1) : 0;
    $offset = $page * $per_page;

    // Handle search
    $search_query = isset($_POST['s']) ? esc_sql($_POST['s']) : '';

    // Delete action
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id_to_delete = intval($_GET['id']);
        $wpdb->delete($table_name, ['id' => $id_to_delete]);
        echo '<div class="updated"><p>Record deleted.</p></div>';
    }

    // Search and pagination query
    $query = "SELECT * FROM $table_name";
    if (!empty($search_query)) {
        $query .= " WHERE `callinit` LIKE '%$search_query%' OR `agent` LIKE '%$search_query%'";
    }
    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var($total_query);
    $query .= " LIMIT ${offset}, ${per_page}";
    $results = $wpdb->get_results($query, ARRAY_A);

    // Display search form
    echo '<form method="post">';
    echo '<input type="text" name="s" placeholder="Search calls..." value="' . esc_attr($search_query) . '"/>';
    echo '<input type="submit" value="Search"/>';
    echo '</form>';

    // Display records
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Call Initiated</th><th>Agent</th><th>Status</th><th>Complete Log</th><th>Call On</th><th>Actions</th></tr></thead>';
    echo '<tbody>';

    foreach ($results as $row) {
        $log = json_decode($row['completelog'], true);
        $log_output = '';
        foreach ($log as $key => $value) {
            $log_output .= '<strong>' . $key . '</strong>: ' . $value . '<br>';
        }

        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['callinit'] . '</td>';
        echo '<td>' . $row['agent'] . '</td>';
        echo '<td>' . $row['astatus'] . '</td>';
        echo '<td>' . $log_output . '</td>';
        echo '<td>' . $row['callon'] . '</td>';
        echo '<td><a href="?page=call-records&action=delete&id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';

    // Pagination
    $num_pages = ceil($total / $per_page);
    $page_links = paginate_links(array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'total' => $num_pages,
        'current' => $page + 1
    ));

    echo "<div class='tablenav'><div class='tablenav-pages'>$page_links</div></div>";
}





include 'settings.php';
//include 'agents.php';
?>
