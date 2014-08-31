<?php
// controlla ed elimina produzioni epsilon dalla grammatica
function e_production() {
    $grammar = $_SESSION["grammar"];
    $variables = $_SESSION["variables"];
    foreach ($variables as $var) {
        // se è annullabile devo cambiare le produzioni
        if (is_nullable($var))
            delete_epsilon($var);
    }
}

// elimina le produzioni epsilon per una variabile annullabile
function delete_epsilon($epsilon) {
    $grammar = $_SESSION["grammar"];
    $variables = $_SESSION["variables"];
    // cancello la produzione epsilon dalla grammatica
    $grammar[$epsilon] = str_replace("e", "", $grammar[$epsilon]);
    $grammar[$epsilon] = array_unique($grammar[$epsilon]);
    // scorro tutte le produzioni alla ricerca della variabile annullabile
    foreach ($variables as $var) {
        $grammar[$var] = array_filter($grammar[$var]);
        foreach ($grammar[$var] as $prod) {
            // se nella produzione c'è una variabile annullabile aggiorno la grammatica
            if (strstr($prod, $epsilon)) {
                $grammar[$var][] = str_replace($epsilon, "", $prod);
            }
        }
    }
    // compatto la grammatica
    $grammar = array_filter($grammar);
    // cerco se ho eliminato variabili
    for ($i = 0; $i < count($variables); $i++) {
        if (!(isset($grammar[$variables[$i]]) && $grammar[$variables[$i]]))
            unset($variables[$i]);
    }
    $variables = array_values($variables);
}
?>
