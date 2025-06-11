<?php

function minify_css($css) {
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
   
   return $css;
}

function format_price(float $amount) {
    return number_format($amount, 2, thousands_separator: '');
}

function get_random_photo() {
    $blur = scandir(public_path('assets/img/blur'));
    $blur = array_filter($blur, fn ($file) => ! in_array($file, ['.', '..',]));
    $blur = array_values($blur);

    return '/assets/img/blur/' . $blur[rand(0, count($blur)-1)];
}

function convert_quill_list_to_nested_ul($html) {
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $body = $doc->getElementsByTagName('body')->item(0);
    $ulElements = $body->getElementsByTagName('ol');

    if ($ulElements->length === 0) {
        return $html;
    }

    $flatUl = $ulElements->item(0);
    $listItems = [];
    
    foreach ($flatUl->childNodes as $node) {
        if ($node->nodeName === 'li') {
            $indent = 0;
            if ($node->hasAttribute('class')) {
                if (preg_match('/ql-indent-(\d+)/', $node->getAttribute('class'), $matches)) {
                    $indent = (int)$matches[1];
                }
            }
            $listItems[] = ['node' => $node->cloneNode(true), 'indent' => $indent];
        }
    }

    $rootUl = $doc->createElement('ol');
    $stack = [['ol' => $rootUl, 'indent' => -1]];

    foreach ($listItems as $item) {
        $li = $item['node'];
        $indent = $item['indent'];
        $li->removeAttribute('class');

        while ($indent <= $stack[count($stack) - 1]['indent']) {
            array_pop($stack);
        }

        $parentUl = $stack[count($stack) - 1]['ol'];
        $parentUl->appendChild($li);

        $nextIndex = array_search($item, $listItems, true) + 1;
        if (isset($listItems[$nextIndex]) && $listItems[$nextIndex]['indent'] > $indent) {
            $newUl = $doc->createElement('ol');
            $li->appendChild($newUl);
            $stack[] = ['ol' => $newUl, 'indent' => $indent];
        }
    }

    return $doc->saveHTML($rootUl);
}