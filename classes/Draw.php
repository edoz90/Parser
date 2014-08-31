<?php

class Draw {

    public function __construct() {
        
    }

    public function DFA($grammar) {
        $variables = $grammar->getItem("v");
        $prod = $grammar->getItem("g");
        $terminals = $grammar->getItem("t");
    }

}
?>

<svg height='540' width='540'>
<circle cx='27' cy='27' r='25' stroke='black' stroke-width='4' fill='#567890'/>
<text x='18' y='37' font-family='Verdana' font-size='28' fill='black' >S</text>



<defs><marker id="myMarker" viewBox="0 0 10 10" refX="1" refY="5" 
              markerUnits="strokeWidth" orient="auto"
              markerWidth="5" markerHeight="5">
    <polyline points="0,0 10,5 0,10 1,5" fill="black" />
</marker></defs>
<line x1="20" y1="10" x2="130" y2="140" stroke="black" 
      stroke-width="2" marker-end="url(#myMarker)" />
<text x="80" y="60" font-family="Verdana" font-size="20">b</text>
</svg>


<svg height="400" width="450">
<path id="lineAB" d="M 100 350 l 150 -300" stroke="red"
      stroke-width="3" fill="none" />
<path id="lineBC" d="M 250 50 l 150 300" stroke="red"
      stroke-width="3" fill="none" />
<path d="M 175 200 l 150 0" stroke="green" stroke-width="3"
      fill="none" />
<path d="M 100 350 q 150 -300 300 0" stroke="blue"
      stroke-width="5" fill="none" />

<!-- Mark relevant points -->
<g stroke="black" stroke-width="3" fill="black">
<circle id="pointA" cx="100" cy="350" r="3" />
<circle id="pointB" cx="250" cy="50" r="3" />
<circle id="pointC" cx="400" cy="350" r="3" />
</g>
<!-- Label the points -->
<g font-size="30" font="sans-serif" fill="black" stroke="none"
   text-anchor="middle">
<text x="100" y="350" dx="-30">A</text>
<text x="250" y="50" dy="-10">B</text>
<text x="400" y="350" dx="30">C</text>
</g>
</svg> 
