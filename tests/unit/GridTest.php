<?php

use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testInitFn()
    {
    	$gridObj = new \App\Grid;

    	$this->assertTrue( is_array($gridObj->init()) );
    } 

    public function testNextFn()
    {
    	$gridObj = new \App\Grid;
    	$grid = $gridObj->init();

    	$this->assertTrue( is_array($gridObj->next($grid)) );
    } 

    public function testNeighborsFn()
    {
    	$gridObj = new \App\Grid;
    	$grid = $gridObj->init();

    	$this->assertTrue( is_integer($gridObj->neighbors($grid, 10, 10)) );
    } 

    public function testPatternsFn()
    {
    	$gridObj = new \App\Grid;

    	$this->assertTrue( is_array($gridObj->patterns("glider_gun")) );
    } 
}

?> 