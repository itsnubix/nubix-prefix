<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR2' => true,
    'array_indentation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'combine_consecutive_unsets' => true,
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'one',
            'method' => 'one',
            'property' => 'one'
        ]
    ],
    //    'class_attributes_separation' => ['const' => 'one', 'method' => 'one', 'property' => 'one'],
    'multiline_whitespace_before_semicolons' => false,
    'single_quote' => true,
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => null,
            '=' => null
        ],
    ],
    // 'blank_line_after_opening_tag' => true,
    // 'blank_line_before_return' => true,
    'braces' => [
        'allow_single_line_closure' => true,
    ],
    // 'cast_spaces' => true,
    // 'class_definition' => array('singleLine' => true),
    'concat_space' => ['spacing' => 'none'],
    'declare_equal_normalize' => true,
    'function_typehint_space' => true,
    'single_line_comment_style' => ['comment_types' => ['hash']],
    'include' => true,
    'lowercase_cast' => true,
    // 'native_function_casing' => true,
    // 'new_with_braces' => true,
    // 'no_blank_lines_after_class_opening' => true,
    // 'no_blank_lines_after_phpdoc' => true,
    // 'no_empty_comment' => true,
    // 'no_empty_phpdoc' => true,
    // 'no_empty_statement' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'square_brace_block',
            'throw',
            'use',
        ]],
    // 'no_leading_import_slash' => true,
    // 'no_leading_namespace_whitespace' => true,
    // 'no_mixed_echo_print' => array('use' => 'echo'),
    'no_multiline_whitespace_around_double_arrow' => true,
    // 'no_short_bool_cast' => true,
    // 'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_around_offset' => true,
    // 'no_trailing_comma_in_list_call' => true,
    // 'no_trailing_comma_in_singleline_array' => true,
    // 'no_unneeded_control_parentheses' => true,
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    // 'normalize_index_brace' => true,
    'object_operator_without_whitespace' => true,
    // 'php_unit_fqcn_annotation' => true,
    //'phpdoc_align' => true,
    // 'phpdoc_annotation_without_dot' => true,
    // 'phpdoc_indent' => true,
    // 'phpdoc_inline_tag' => true,
    // 'phpdoc_no_access' => true,
    // 'phpdoc_no_alias_tag' => true,
    // 'phpdoc_no_empty_return' => true,
    // 'phpdoc_no_package' => true,
    // 'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_order' => false,
    // 'phpdoc_return_self_reference' => true,
    // 'phpdoc_scalar' => true,
    // 'phpdoc_separation' => true,
    // 'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    // 'phpdoc_to_comment' => true,
    // 'phpdoc_trim' => true,
    // 'phpdoc_types' => true,
    // 'phpdoc_var_without_name' => true,
    // 'pre_increment' => true,
    'return_type_declaration' => ['space_before' => 'one'],
    // 'self_accessor' => true,
    // 'short_scalar_cast' => true,
    'single_blank_line_before_namespace' => true,
    // 'single_class_element_per_statement' => true,
    // 'space_after_semicolon' => true,
    // 'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    // 'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'whitespace_after_comma_in_array' => true,
    'function_declaration' => true,
    'indentation_type' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'not_operator_with_successor_space' => true,
];

$finder = Finder::create()
    ->in([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
