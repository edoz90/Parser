<?php

class Parsing {

    private $grammar;
    private $variables;
    private $terminals;
    private $first = array();

    public function __construct($g) {
        $this->grammar = $g->getItem("g");
        $this->variables = $g->getItem("v");
        $this->terminals = $g->getItem("t");
    }

    public function first() {
        if (isset($this->grammar) && $this->grammar) {
            // calcolo il first per ogni variabile
            foreach ($this->variables as $var) {
                $first = $this->firstCompute($var);
                $first = explode(",", $first);
                $first = array_unique($first);
                // creo l'array first
                $this->first[$var] = array_values($first);
            }
            // se la produzione S contiente una epsilon la elimino
            if (isset($this->first["S"]) && $this->first["S"]) {
                $key = array_search("e", $this->first["S"]);
                if (isset($key) && count($this->first["S"]) > 1) {
                    unset($this->first["S"][$key]);
                    $this->first["S"] = array_values($this->first["S"]);
                }
            }
        }
        return $this->first;
    }

    // calcola il first per una variabile
    private function firstCompute($var) {
        $first = "";
        // per ogni produzione a destra della variabile devo calcolare il FIRST
        for ($i = 0; $i < count($this->grammar[$var]); $i++) {
            // espolodo le produzioni
            $prod = explode(" ", $this->grammar[$var][$i]);
            // se la produzione è un terminale soltanto la inserisco nel FIRST
            if (in_array($prod[0], $this->terminals)) {
                if (!isset($first) || !$first) {
                    $first = $prod[0];
                } else {
                    $first .= "," . $prod[0];
                }
            } else {
                if ($prod[0] != $var) {
                    // controllo se è annullabile
                    if ($this->is_nullable($prod[0])) {
                        // se è annullabile prendo il token successivo
                        if (in_array($prod[1], $this->variables)) {
                            // se è una variabile ne calcolo il FIRST
                            if (!isset($first) || !$first) {
                                $first = $this->firstCompute($prod[1]);
                            } else {
                                $first .= "," . $this->firstCompute($prod[1]);
                            }
                        } else {
                            // altrimenti il token è un terminale
                            if (!isset($first) || !$first) {
                                $first = $prod[1];
                            } else {
                                $first .= "," . $prod[1];
                            }
                        }
                    }
                    if (!isset($first) || !$first) {
                        $first = $this->firstCompute($prod[0]);
                    } else {
                        $first .= "," . $this->firstCompute($prod[0]);
                    }
                } else {
                    // se il token è una variabile
                    if ($this->is_nullable($prod[0])) {
                        // se è annullabile procedo come sopra
                        if (in_array($prod[1], $variables)) {
                            if (!isset($first) || !$first) {
                                $first = $this->firstCompute($prod[1]);
                            } else {
                                $first .= "," . $this->firstCompute($prod[1]);
                            }
                        } else {
                            if (!isset($first) || !$first) {
                                $first = $prod[1];
                            } else {
                                $first .= "," . $prod[1];
                            }
                        }
                    }
                }
            }
        }
        return $first;
    }

    // controlla se la variabile è annullabile
    private function is_nullable($var) {
        // per ogni produzione della variabile controllo se ce ne è una epsilon
        foreach ($this->grammar[$var] as $prod) {
            if (trim($prod) == "e")
                return TRUE;
            else {
                // se incontro una variabile controllo che non sia annulabile quella variabile
                if (in_array($prod, $this->variables)) {
                    return is_nullable($prod);
                } else
                // è un insieme di simboli (due terminali, due variabili e combinazioni)
                return FALSE;
            }
        }
    }

    // stampa il first per tutte le variabili
    public function printFirst() {
        if (!isset($this->first) && !$this->first) {
            $this->first;
        }
        echo "<p>";
        if (isset($this->first) && $this->first) {
            foreach ($this->variables as $var) {
                echo "FIRST(<b>" . $var . "</b>) = {";
                if (count($this->first[$var]) == 0)
                    echo "}<br/>";
                for ($i = 0; $i < count($this->first[$var]); $i++) {
                    if ($i + 1 < count($this->first[$var])) {
                        echo $this->first[$var][$i] . ", ";
                    } else {
                        echo $this->first[$var][$i] . "}<br/>";
                    }
                }
            }
            echo "</p>";
        }
    }

}
