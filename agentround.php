<?php

function around(){
// Assuming you are working within a WordPress environment

// Step 1: Get all posts of the specified post type ('agent')
$args = array(
    'post_type' => 'agent',
    'posts_per_page' => -1, // Retrieve all posts
);

$agents_query = new WP_Query($args);
// Initialize an array to store agent post IDs
$agent_ids = array();

// Check if there are any agents
if ($agents_query->have_posts()) {
    while ($agents_query->have_posts()) {
        $agents_query->the_post();
        $agent_ids[] = get_the_ID(); // Store the post ID in the array
    }

    // Reset post data to the main loop
    wp_reset_postdata();

    // Print a random agent post ID
    $random_agent_id = $agent_ids[array_rand($agent_ids)];
    $agent_mobile = get_post_meta($random_agent_id, '_agent_mobile', true);
    return $agent_mobile;
    
} else {
    return "No agents found.";
}
// // Step 2: Fetch posts in a round-robin manner
// if ($agents_query->have_posts()) {
//     $agents = $agents_query->posts;

//     // Implement round-robin logic
//     $current_agent_index = get_option('current_agent_index', 0);
//     $selected_agent = $agents[$current_agent_index];

//     // Update the index for the next request
//     $next_agent_index = ($current_agent_index + 1) % count($agents);
//     update_option('current_agent_index', $next_agent_index);

//     // Fetch custom field values
//     $agent_username = get_post_meta($selected_agent->ID, '_agent_username', true);
//     $agent_mobile = get_post_meta($selected_agent->ID, '_agent_mobile', true);

//     // Now, $selected_agent contains the agent post for the current request
//     // You can access the post data using $selected_agent->ID, $selected_agent->post_title, etc.

//     // Output the agent information, including custom fields
//     // echo '<h2>' . esc_html($selected_agent->post_title) . '</h2>';
//     // echo '<p>Username: ' . esc_html($agent_username) . '</p>';
// //    echo '<p>Mobile: ' . esc_html($agent_mobile) . '</p>';
//      return esc_html($agent_mobile);
// } else {
//     // No agents found
//     echo 'No agents found.';
// }

// // Reset query to restore the original loop
// wp_reset_postdata();
    
}



//get agent detail by agent number
function agdet($agent_mobile){
 

// Assuming you are working within a WordPress environment

// Step 1: Get the agent details by mobile number
//$agent_mobile = 'your_target_mobile_number'; // Replace with the actual mobile number

$args = array(
    'post_type' => 'agent',
    'meta_query' => array(
        array(
            'key' => '_agent_mobile', // Replace with the actual meta key for mobile number
            'value' => $agent_mobile,
            'compare' => '=',
        ),
    ),
);

$agent_query = new WP_Query($args);

// Step 2: Fetch agent details
if ($agent_query->have_posts()) {
    $agent = $agent_query->posts[0]; // Assuming there is only one matching agent

    // Fetch additional custom field values
    $agent_username = get_post_meta($agent->ID, '_agent_username', true);
    $agent_mobile = get_post_meta($agent->ID, '_agent_mobile', true);

    // Output agent information
return $agent_username;
} else {
    // No agent found with the specified mobile number
    echo 'No agent found with the specified mobile number.';
}

// Reset query to restore the original loop
wp_reset_postdata();


    
}




?>