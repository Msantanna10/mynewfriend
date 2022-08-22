<?php
################### Contact Form 7 - Change recipient email (based on the pet's author on the single pet page)
add_action( 'wpcf7_before_send_mail', 'cf7_change_email_by_single_pet'); // Hooking into wpcf7_before_send_mail
function cf7_change_email_by_single_pet($contact_form) {

   global $cf7AdoptionFormID;

   if($contact_form->id() == $cf7AdoptionFormID) {
    // Create our function to be used in the above hook
    $submission = WPCF7_Submission::get_instance(); // Create instance of WPCF7_Submission class
    $posted_data = $submission->get_posted_data(); // Get all of the submitted form data

    $page_id = $posted_data['current-pet']; // Pet page ID
    $author_id = get_post_field('post_author', $page_id); // Author ID by post
    $author_email = get_user_by( 'id', $author_id )->user_email; // Author email

    // set the email address to recipient
    $mailProp = $contact_form->get_properties('mail');
    $mailProp['mail']['recipient'] = $author_email; // Sets new email

    // update the form properties
    $contact_form->set_properties(array('mail' => $mailProp['mail']));
   }
}
?>