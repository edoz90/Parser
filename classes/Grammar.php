<?php

/* Classe per la gestione della grammatica:
 * - inserimento delle produzioni
 * - cancellazione della grammatica (prova a fare il singleton)
 * - estrazione dei terminali e delle variabili
 * - stampa */

// classifica la grammatica (solo le rightmost in DFA?)
class Grammar {

    private $grammar;
    private $variables;
    private $terminals;

    // costruttore
    public function __construct() {
        $this->grammar = array();
        $this->variables = array();
        $this->terminals = array();
    }

    // inserisce una produzione nella grammatica
    public function insert($var, $prod) {
        $var = trim(htmlspecialchars($var, ENT_QUOTES, "UTF-8"));
        if ($var && $prod) {
            if (!in_array($var, $this->variables)) {
                $this->variables[] = $var;
            }
            $prod = explode("|", $prod);
            foreach ($prod as $productions) {
                $productions = trim(htmlspecialchars($productions, ENT_QUOTES, "UTF-8"));
                $this->grammar[$var][] = $productions;
            }
        }
        $this->extract_terminals();
    }

    // cerca e salva i terminali
    public function extract_terminals() {
        $terminals = "";
        if (isset($this->grammar) && $this->grammar) {
            // per ogni produzione cerco i terminali
            foreach ($this->variables as $var) {
                foreach ($this->grammar[$var] as $productions) {
                    $productions = trim($productions);
                    $productions = str_replace($this->variables, "", $productions);
                    $productions = str_replace(",", "&#44;", $productions);
                    $prod = explode(" ", $productions);
                    foreach ($prod as $p) {
                        // aggiungo il token trovato all'array dei terminali
                        if ($p) {
                            if (!$terminals) {
                                $terminals = trim($p);
                            } else {
                                $terminals .= "," . trim($p);
                            }
                        }
                    }
                }
            }
            // pulisco e compatto l'array
            $terminals = explode(",", $terminals);
            $terminals = array_unique($terminals);
            //$terminals = array_filter($terminals);
            $terminals = array_values($terminals);
            $this->terminals = $terminals;
        }
    }

    // stampa la grammatica o i vari componenti
    public function gprint($what) {
        echo "<link rel='stylesheet' href='classes/css/grammar.css'>";
        echo "<div id='grammar'>";
        switch ($what) {
            case "g": {
                    if (isset($this->grammar) && $this->grammar) {
                        foreach ($this->variables as $var) {
                            echo "<div class='variable'>" . $var . "</div>" .
                            "<div class='arrow'>&#x2192;</div>";
                            echo "<div class='production'>";
                            for ($i = 0; $i < count($this->grammar[$var]); $i++) {
                                if ($i + 1 < count($this->grammar[$var])) {
                                    echo $this->grammar[$var][$i] . " | ";
                                } else {
                                    echo $this->grammar[$var][$i];
                                }
                            }
                            echo "</div><br/>";
                        }
                    }
                }
                break;
            case "v": {
                    if (isset($this->variables) && $this->variables) {
                        for ($i = 0; $i < count($this->variables); $i++) {
                            if ($i + 1 < count($this->variables)) {
                                echo $this->variables[$i] . ", ";
                            } else {
                                echo $this->variables[$i];
                            }
                        }
                    }
                }
                break;
            case "t": {
                    //$this->extract_terminals();
                    if (isset($this->terminals) && $this->terminals) {
                        for ($i = 0; $i < count($this->terminals); $i++) {
                            if ($i + 1 < count($this->terminals)) {
                                echo $this->terminals[$i] . ", ";
                            } else {
                                echo $this->terminals[$i];
                            }
                        }
                    }
                }
                break;
        }
        echo "</div>";
    }

    // metodo get per le variabili private
    public function getItem($what) {
        switch ($what) {
            case "g": {
                    if (isset($this->grammar) && $this->grammar) {
                        return $this->grammar;
                    }
                }
                break;
            case "v": {
                    if (isset($this->variables) && $this->variables) {
                        return $this->variables;
                    }
                }
                break;
            case "t": {
                    if (isset($this->terminals) && $this->terminals) {
                        return $this->terminals;
                    }
                }
                break;
            default : return FALSE;
        }
    }

}
?>

