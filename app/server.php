<?php 
namespace App;
include './Grid.php';

$grid;
$cols = 38; 
$rows = 38;
$gridObj = new Grid($cols, $rows);
$grid = $gridObj->init(); 

if ( !empty($_POST['data']) )
{
    $data = $_POST['data'];
    $grid = json_decode($data);
    // 
    $next = $gridObj->next($grid);
    echo( json_encode($next) ); exit;
}
elseif ( !empty($_POST['pattern']) )
{
    $next = $gridObj->patterns($_POST['pattern']);
    echo( json_encode($next) ); exit;
}
else 
{
    for ($i=0; $i < $cols; $i++) { 
        for ($j=0; $j < $rows; $j++) { 
            $grid[$i][$j] = mt_rand(0,1);
        }
    }
    
    $next = $gridObj->next($grid); 
    echo( json_encode($next) ); exit;
}