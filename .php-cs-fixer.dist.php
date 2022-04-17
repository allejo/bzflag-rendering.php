<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests')
;

$license = <<<HEADER
(c) Vladimir "allejo" Jimenez <me@allejo.io>

For the full copyright and license information, please view the
LICENSE.md file that was distributed with this source code.
HEADER;

$config = new PhpCsFixer\Config();
$config
    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => false,
        'braces' => [
            'position_after_control_structures' => 'next',
        ],
        'cast_spaces' => [
            'space' => 'none'
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true,
        'header_comment' => [
            'header' => $license,
            'comment_type' => 'comment',
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ],
        'echo_tag_syntax' => ['format' => 'long'],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_imports' => [
            'imports_order' => [
                'const',
                'class',
                'function',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => true,
        ],
        'phpdoc_no_empty_return' => false,
        'phpdoc_order' => true,
        'phpdoc_to_comment' => [
            'ignored_tags' => ['var'],
        ],
        'phpdoc_var_without_name' => false,
        'php_unit_fqcn_annotation' => false,
        'ternary_to_null_coalescing' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
        PhpCsFixerCustomFixers\Fixer\CommentSurroundedBySpacesFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\DataProviderNameFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\DataProviderReturnTypeFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\DataProviderStaticFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\DeclareAfterOpeningTagFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\MultilineCommentOpeningClosingAloneFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\NoDuplicatedImportsFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\NoDoctrineMigrationsGeneratedCommentFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\NoUselessDoctrineRepositoryCommentFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\NoUselessParenthesisFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpUnitAssertArgumentsOrderFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpUnitDedicatedAssertFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpUnitNoUselessReturnFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpdocNoIncorrectVarAnnotationFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpdocParamTypeFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpdocSelfAccessorFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\PhpdocTypesTrimFixer::name() => true,
        PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer::name() => true,
    ])
    ->setFinder($finder)
;

return $config;
