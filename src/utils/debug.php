<?php

function dump($params):void{
    echo ('
        <div style="
        display: inline-block;
        background: teal;
        padding: 50px;
        color: red;
        ">
        <pre>
    ');
    print_r($params);
    echo ('</pre></div><br>');
}