<?php
    require("../connect.php");
    $insert_query = <<<QUERY
    INSERT INTO winter_handicaps
    (player_name, handicap)
    VALUES
    ('Aiden McCormack', '1'),
    ('Alan Bergin', '0'),
    ('Alan O Conor', '0'),
    ('Brian Smithers', '0'),
    ('Colm Kelly', '1'),
    ('Dave Bergin Jnr', '0'),
    ('Dave Heary', '0'),
    ('Des McCormack', '0'),
    ('Eddie Finn', '2'),
    ('George Coombes', '0'),
    ('Ivan Cosgrave', '0'),
    ('Jimmy Murphy', '1'),
    ('Jonathan Doyle', '0'),
    ('Kevin Halpin', '0'),
    ('Kieran Fitzmaurice', '0'),
    ('Liam Lynch', '0'),
    ('Martin Doyle', '1'),
    ('Marty Crawford', '0'),
    ('Mick Fetherston', '0'),
    ('MJ Fetherston', '0'),
    ('Owen Doyle', '0'),
    ('Padraic Brennan', '0'),
    ('Richie O Brian', '0'),
    ('Wayne Osborne', '1');    
QUERY;

@mysqli_query($database, $insert_query);
?>