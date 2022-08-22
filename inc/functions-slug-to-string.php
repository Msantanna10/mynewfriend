<?php
################### States and Cities slug to non-slug. Example: united-states -> United States
function slugToString($place) {
$places = json_get_content(get_bloginfo('template_url') . "/states_cities.json");

$estados_lista = array();
$cidades_lista = array();
$validPlace = false; // Default

// Cada estado com suas cidades...
foreach ($places as $key => $value){

    $estado = $value['name'];
    $cidades = $value['cities'];
    
    // Lista dos estados com e sem acentos
    $estados_lista[sanitize_title($estado)] = array();
    $estados_lista[sanitize_title($estado)]['state-with-accents'] = $estado;
    $estados_lista[sanitize_title($estado)]['place_type'] = 'state';

    // Valid place? (State)
    if(sanitize_title($estado) == $place) $validPlace = true;

    // List of all cities with accent
    foreach($cidades as $cidade_single) {
    $cidades_lista[sanitize_title($cidade_single)] = array();
    $cidades_lista[sanitize_title($cidade_single)]['city-with-accents'] = $cidade_single; 
    $cidades_lista[sanitize_title($cidade_single)]['state-with-accents'] = $estado; 
    $cidades_lista[sanitize_title($cidade_single)]['state-slug'] = sanitize_title($estado);     
    $cidades_lista[sanitize_title($cidade_single)]['place_type'] = 'city';      

    // Valid place? (City)
    if(sanitize_title($cidade_single) == $place) $validPlace = true;
    }

}

// Check if place is valid
if($validPlace) {
    if (isset($estados_lista[$place])) { return $estados_lista[$place]; } // Valid State
    else if (isset($cidades_lista[$place])) { return $cidades_lista[$place]; } // Or Valid City
}  
else {
    return false; // Invalid Place
}

}
?>