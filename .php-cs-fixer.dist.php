<?php

$finder = (new PhpCsFixer\Finder)
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

// do not enable self_accessor as it breaks pimcore models relying on get_called_class()
return (new PhpCsFixer\Config)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP82Migration' => true,
        '@DoctrineAnnotation' => true,
        '@PHPUnit84Migration:risky' => true,
        'blank_line_after_opening_tag' => false,
        'declare_strict_types' => true,
        'single_line_throw' => false,
        'concat_space' => ['spacing' => 'one'],
        'php_unit_method_casing' => false,
        'php_unit_test_annotation' => ['style' => 'annotation'],
        'phpdoc_summary' => false,
        'ordered_traits' => false,
        'single_line_empty_body' => true,
        'array_push' => true,
        'combine_consecutive_unsets' => true,
        'heredoc_to_nowdoc' => true,
        'heredoc_indentation' => ['indentation' => 'same_as_start'],
        'no_extra_blank_lines' => [
            'tokens' => [
                'break',
                'continue',
                'extra',
                'return',
                'throw',
                'use',
                'parenthesis_brace_block',
                'square_brace_block',
                'curly_brace_block',
            ],
        ],
        'mb_str_functions' => true,
        'new_with_braces' => false,
        'linebreak_after_opening_tag' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'class_definition' => ['single_item_single_line' => true],
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'ordered_class_elements' => true,
        'php_unit_strict' => false,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_order' => true,
        'simple_to_complex_string_variable' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
        'method_chaining_indentation' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'return_assignment' => true,
        'simplified_if_return' => true,
        'no_null_property_initialization' => true,
        'native_constant_invocation' => [
            'fix_built_in' => false,
            'include' => [
                'DIRECTORY_SEPARATOR',
                'PHP_INT_SIZE',
                'PHP_SAPI',
                'PHP_VERSION_ID',
            ],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        'native_function_invocation' => [
            'include' => [
                '@compiler_optimized',
            ],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        'trailing_comma_in_multiline' => [
            'elements' => [
                'arguments',
                'arrays',
                'match',
                'parameters',
            ],
        ],
    ])
    ->setFinder($finder);
