<?php
##################### Page IDs
global $pageAbout, $pageProducts, $pageSearchPage, $pageHelp, $pageContact, $pageNewPet, $pageEditPet, $pageEditProfile, $pageSignUp, $pageLogIn, $pageResponsibleAdoption, $cf7AdoptionFormID, $cf7ContactFormID;
// Create those pages and set their ID (INT) so they can be used across the website
$pageAbout = 2; // About page (default page.php)
$pageProducts = 8; // Products page, for affiliate products (Select custom template)
$pageSearchPage = 10; // Search page, where orange form leads to (Select custom template)
$pageHelp = 12; // Help us page (Select custom template)
$pageContact = 14; // Contact us (Select custom template)
$pageNewPet = 16; // Add new pet (Select custom template)
$pageEditPet = 18; // Edit pet (Select custom template)
$pageEditProfile = 20; // Edit profile (Select custom template)
$pageSignUp = 22; // Create an account (Select custom template)
$pageLogIn = 24; // Login page (Select custom template)
$pageResponsibleAdoption = 26; // Responsible adoption page (default page.php)
$cf7ContactFormID = 28; // CF7 ID used on the contact us form
$cf7AdoptionFormID = 29; // CF7 ID used on the single pet page

##################### CODE FOR CONTACT FORM 7 (CONTACT US PAGE)
/*
[text* name placeholder "Name"]
[email* email placeholder "Email"]
[tel* phone class:telefone placeholder "WhatsApp or phone"]
[textarea* message placeholder "Message"]
[submit "Send"]
*/

##################### CODE FOR CONTACT FORM 7 (SINGLE PET PAGE)
/*
[hidden current-pet]
[text* name placeholder "Nome"]
[email* email placeholder "Email"]
[tel* phone class:telefone placeholder "Phone"]
[textarea message placeholder "Message (optional)"]
[submit "Send"]
*/

?>