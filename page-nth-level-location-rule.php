<?php 
add_filter('acf/location/rule_types', function ($choices) {
    $choices['Page']['page_level'] = 'Page Level';
    return $choices;
});

add_filter('acf/location/rule_operators', function ($choices) {
    $new_choices = [
        '<' => 'is less than',
        '<=' => 'is less than or equal to',
        '>=' => 'is greater than or equal to',
        '>' => 'is greater than'
    ];
    foreach ($new_choices as $key => $value) {
        $choices[$key] = $value;
    }
    return $choices;
});


add_filter('acf/location/rule_values/page_level', function ($choices) {
    for ($i = 1; $i <= 4; $i++) {
        $choices[$i] = $i;
    }
    return $choices;
});


add_filter('acf/location/rule_match/page_level', function($match, $rule, $options) {

    if (!isset($options['post_id'])) {
        return $match;
    }

    $page_level = count(get_post_ancestors($options['post_id'])) + 1;
    $operator = $rule['operator'];
    $value = intval($rule['value']);

    switch ($operator) {
        case '==':
            $match = ($page_level === $value);
            break;
        case '!=':
            $match = ($page_level !== $value);
            break;
        case '<':
            $match = ($page_level < $value);
            break;
        case '<=':
            $match = ($page_level <= $value);
            break;
        case '>=':
            $match = ($page_level >= $value);
            break;
        case '>':
            $match = ($page_level > $value);
            break;
    }

    return $match;

}, 10, 3);
