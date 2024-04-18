<?php
// // Add a menu item in the admin menu
// function maqsam_api_settings_menu() {
//     add_menu_page(
//         'Maqsam API Settings',
//         'Call Back 24',
//         'manage_options',
//         'maqsam-api-settings',
//         'maqsam_api_settings_page'
//     );
// }

//     // add_menu_page(
//     //     'My Plugin Settings',
//     //     'Call Back 24',
//     //     'manage_options',
//     //     'my-plugin-settings',
//     //     'my_plugin_settings_page_callback'
//     // );

// add_action('admin_menu', 'maqsam_api_settings_menu');
// Function to get the total quantity of Agents
function get_agents_quantity() {
    $args = array(
        'post_type'      => 'agent',
        'posts_per_page' => -1, // Retrieve all posts
    );

    $query = new WP_Query($args);

    // Return the total quantity
    return $query->found_posts;
}


// Settings page content
function maqsam_api_settings_page() {
    
 

// Example usage
//$urlToEncode = 'https://storage.googleapis.com/msgsndr/VNVqH23zHTa4IKJeheIy/media/658942a90e13486030c30f25.pdf';
//generateQRCode($urlToEncode);


// include 'agentround.php';
// echo around();
    
    ?>
    <div class="wrap">
         <div><img src="https://assets-global.website-files.com/61bf04d065d458b90c69aae4/61bf2e370248ef1f63f0bc9c_maqsam-logo-en-p-500.png" style="width:150px">
        </div>
        <h2>Maqsam API Settings</h2>
      <h3>Total Maqsam Registered Users <?php echo get_agents_quantity(); ?> To Register More User <a href="./edit.php?post_type=agent">Click Here</a></h3>
        <form method="post" action="options.php">
            <?php settings_fields('maqsam-api-settings-group'); ?>
            <?php do_settings_sections('maqsam-api-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Maqsam API Endpoint</th>
                    <td><input type="text" name="maqsam_api_endpoint" value="<?php echo esc_attr(get_option('maqsam_api_endpoint')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Maqsam Access Key</th>
                    <td><input type="text" name="maqsam_access_key" value="<?php echo esc_attr(get_option('maqsam_access_key')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Maqsam Access Secret</th>
                    <td><input type="text" name="maqsam_access_secret" value="<?php echo esc_attr(get_option('maqsam_access_secret')); ?>" /></td>
                </tr>
                
                  <tr valign="top">
                    <th scope="row">Tune URL</th>
                    <td><input type="text" name="maqsam_tune_url" value="<?php echo esc_attr(get_option('maqsam_tune_url')); ?>" /></td>
                </tr>
                      <tr valign="top">
                    <th scope="row">Apology Url</th>
                    <td><input type="text" name="maqsam_ApologyUrl" value="<?php echo esc_attr(get_option('maqsam_ApologyUrl')); ?>" /></td>
                </tr>
                
                
                   <tr valign="top">
                    <th scope="row">Confirm Url</th>
                    <td><input type="text" name="maqsam_confirmUrl" value="<?php echo esc_attr(get_option('maqsam_confirmUrl')); ?>" /></td>
                </tr>
                
                       <tr valign="top">
                    <th scope="row">Timeout Url</th>
                    <td><input type="text" name="maqsam_timeoutUrl" value="<?php echo esc_attr(get_option('maqsam_timeoutUrl')); ?>" /></td>
                </tr>
                
                  <tr valign="top">
                    <th scope="row">Round Robin (Define number agents to round)</th>
                    <td><input type="text" name="maqsam_rr" value="<?php echo esc_attr(get_option('maqsam_rr')); ?>" /></td>
                </tr>
                 <tr valign="top">
                     <td colspan=2><h3>Try To Use Inbound Webhook URL In Push Fields</h3></td>
                 </tr>
                
                  <tr valign="top">
                    <th scope="row">After Call Done Push Data To this URL With Recordings</th>
                    <td><input type="text" name="maqsam_prcd" value="<?php echo esc_attr(get_option('maqsam_prcd')); ?>" /></td>
                </tr>
                    <tr valign="top">
                    <th scope="row">If No One Received Push Data To this URL</th>
                    <td><input type="text" name="maqsam_nrcd" value="<?php echo esc_attr(get_option('maqsam_nrcd')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">If Client Terminate 3 times Push Data To this URL</th>
                    <td><input type="text" name="maqsam_crcd" value="<?php echo esc_attr(get_option('maqsam_crcd')); ?>" /></td>
                </tr>
                     <tr valign="top">
                    <th scope="row">Hit Everyevent Data To this URL</th>
                    <td><input type="text" name="maqsam_hedt" value="<?php echo esc_attr(get_option('maqsam_hedt')); ?>" /></td>
                </tr>
                
                    <tr valign="top" style="display:none">
                    <th scope="row">Callback Url</th>
                    <?php // Get the plugin directory URL
$plugin_directory_url = plugins_url()."/callback/myreturn.php"; ?>
                    <td><input type="text" name="maqsam_CallbackUrl" value="<?php echo $plugin_directory_url ?>" />
                    
                    </td>
                </tr>
                
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
function maqsam_api_register_settings() {
    register_setting('maqsam-api-settings-group', 'maqsam_api_endpoint');
    register_setting('maqsam-api-settings-group', 'maqsam_access_key');
    register_setting('maqsam-api-settings-group', 'maqsam_access_secret');
        register_setting('maqsam-api-settings-group', 'maqsam_tune_url');
        //ApologyUrl
             register_setting('maqsam-api-settings-group', 'maqsam_ApologyUrl');
               register_setting('maqsam-api-settings-group', 'maqsam_confirmUrl');
                 register_setting('maqsam-api-settings-group', 'maqsam_timeoutUrl');
                 register_setting('maqsam-api-settings-group', 'maqsam_CallbackUrl');
                                  register_setting('maqsam-api-settings-group', 'maqsam_rr');
                                  register_setting('maqsam-api-settings-group', 'maqsam_prcd');
                                                                    register_setting('maqsam-api-settings-group', 'maqsam_nrcd');
                                                                      register_setting('maqsam-api-settings-group', 'maqsam_crcd');
                                                                       register_setting('maqsam-api-settings-group', 'maqsam_hedt');
}

add_action('admin_init', 'maqsam_api_register_settings');

?>