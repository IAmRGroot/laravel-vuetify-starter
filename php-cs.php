<?php
/**
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer
 */
$excluded_folders = [
    'node_modules',
    'storage',
    'vendor',
    'bootstrap/cache',
];
$finder = PhpCsFixer\Finder::create()
    ->exclude($excluded_folders)
    ->notName('_ide_helper.php')
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setCacheFile(__DIR__ . '/.php-cs.cache')
    ->setRules([
        '@PhpCsFixer'                            => true,
        '@Symfony'                               => true,
        'binary_operator_spaces'                 => ['default' => 'align_single_space'],
        'array_syntax'                           => ['syntax' => 'short'],
        'linebreak_after_opening_tag'            => true,
        'not_operator_with_successor_space'      => true,
        'concat_space'                           => ['spacing' => 'one'],
        'no_superfluous_phpdoc_tags'             => false,
        'single_line_throw'                      => false,
        'multiline_whitespace_before_semicolons' => false,
        'line_ending'                            => false,
    ])->setFinder($finder);
