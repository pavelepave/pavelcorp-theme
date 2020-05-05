<?php 
foreach (glob(__DIR__ . '/custom/autoload/**/*.php') as $filename)
{
    include_once $filename;
}
foreach (glob(__DIR__ . '/custom/autoload/*.php') as $filename)
{
    include_once $filename;
}