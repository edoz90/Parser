<!-- aggiungi stringa aiuto nelle input per controllo di stringa vuota al momento dell'addinput -->
<form name="insert" id="insert" action="?send=1" method="post">
    <b>Inserisci le produzioni</b><br/>
    <input name="variable0" id="variable0" type="text" size="2"/> &#x2192; 
    <input name="production0" id="production0"  type="text"/><br/>
    <input name="variable1" id="variable1" type="text" size="2"/> &#x2192; 
    <input name="production1" id="production1" type="text" onfocus="addInput();"/><br/>
    <div id="extraInput"></div>

    <p>La variabile di partenza &egrave; <b>S</b><br/>
        Inserisci <b>e</b> per <b>&epsilon;</b>, ogni produzione va disiva con <b>|</b><br/>
        ESEMPIO:<br/> S &#x2192; b A | c B<br/> A &#x2192; id B<br/> B &#x2192; e
        <br/><button type="submit" name="send" value="insert">Inserisci</button>
        <button type="submit" name="send" value="erase">Azzera tutto</button></p>
</form>
<!-- rappresentazione grafica della grammatica come automa (html5: circle, archi, label archi) -->
<script>
    var num = 2;
    // Aggiunge un inputBox al form al momento del click del precedente
    function addInput() {
        // ONFOCUSCHANGE controllo i value dell'ultima riga
        // 
        // Il div dove vado ad aggiungere gli inputBox
        var container = document.getElementById("extraInput");
        // Creo l'elemento e setto i suoi attributi se l'inputBox precedente non è nullo
        var input = document.createElement("input");
        input.type = "text";
        input.name = "variable" + num;
        input.id = "variable" + num;
        input.size = 2;
        container.appendChild(input);
        container.appendChild(document.createTextNode(" " + "\u2192" + " "));
        var input = document.createElement("input");
        input.type = "text";
        input.name = "production" + num;
        input.id = "production" + num;
        input.onfocus = function() {
            // All'evento onfocus incremento num e faccio addInput()
            num++;
            addInput();
        };
        container.appendChild(input);
        // Appendo un line break
        container.appendChild(document.createElement("br"));
    }
</script>
<?php
/* on development */
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
/* * ******* */

include "classes/Grammar.php";
session_start();

if (isset($_SESSION["grammarI"])) {
    $grammar = unserialize($_SESSION["grammarI"]);
} else {
    $grammar = new Grammar();


    /* $grammar->insert("S", "a b A | c B");
      $grammar->insert("A", "id B");
      $grammar->insert("B", "e"); */
    $grammar->insert("S", "n A B c");
    $grammar->insert("S", "B l");
    $grammar->insert("A", "e");
    $grammar->insert("B", "e");
    $_SESSION["grammarI"] = serialize($grammar);
    $grammar->gprint("t");
}

if (isset($_GET['send']) && $_GET['send'] == 1) {
    if ($_POST['send'] == 'erase') {
        $grammar = "";
        session_destroy();
        header("Location: index.php");
    } else {
        if ($_POST["send"] == "insert") {
            $i = 0;
            foreach ($_POST as $post) {
                if (trim($post) != "") {
                    if (isset($_POST["variable" . $i]) && isset($_POST["production" . $i])) {
                        $grammar->insert($_POST["variable" . $i], $_POST["production" . $i]);
                        $i++;
                    }
                }
            }
            $_SESSION["grammarI"] = serialize($grammar);
        }
    }
}

$grammar->gprint("g");


include ("classes/Parsing.php");
$p = new Parsing($grammar);
$p->first();
$p->printFirst();
?>