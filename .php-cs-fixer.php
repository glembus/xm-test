<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor', 'node_modules'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PHP80Migration:risky' => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setFinder($finder)
    ;
