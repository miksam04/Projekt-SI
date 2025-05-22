<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('var')
    ->exclude('data')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR1' => true,     
        '@PSR2' => true,     
        '@PSR12' => true,    
    ])
    ->setFinder($finder)
;
