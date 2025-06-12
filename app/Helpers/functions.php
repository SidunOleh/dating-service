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

function convert_quill_flat_lists_to_nested($html) {
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML(mb_convert_encoding("<div>$html</div>", 'HTML-ENTITIES', 'UTF-8'));

    $wrapper = $doc->getElementsByTagName('div')->item(0);
    $newWrapper = $doc->createElement('div');

    foreach (iterator_to_array($wrapper->childNodes) as $node) {
        if ($node->nodeType !== XML_ELEMENT_NODE) {
            $newWrapper->appendChild($doc->importNode($node, true));
            continue;
        }

        $tag = $node->nodeName;
        if (($tag === 'ul' || $tag === 'ol') && hasQuillIndentClasses($node)) {
            $nestedList = convert_flat_list_to_nested($doc, $node);
            $newWrapper->appendChild($nestedList);
        } else {
            $newWrapper->appendChild($doc->importNode($node, true));
        }
    }

    $result = '';
    foreach ($newWrapper->childNodes as $child) {
        $result .= $doc->saveHTML($child);
    }

    return $result;
}

function hasQuillIndentClasses(DOMElement $list) {
    foreach ($list->childNodes as $child) {
        if ($child->nodeType === XML_ELEMENT_NODE && $child->hasAttribute('class')) {
            if (preg_match('/ql-indent-\d+/', $child->getAttribute('class'))) {
                return true;
            }
        }
    }
    return false;
}

function convert_flat_list_to_nested(DOMDocument $doc, DOMElement $flatList) {
    $tagName = $flatList->tagName;
    $listItems = [];

    foreach ($flatList->childNodes as $node) {
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

    $rootList = $doc->createElement($tagName);
    $stack = [ ['list' => $rootList, 'indent' => -1] ];

    foreach ($listItems as $index => $item) {
        $li = $item['node'];
        $indent = $item['indent'];
        $li->removeAttribute('class');

        while ($indent <= $stack[count($stack) - 1]['indent']) {
            array_pop($stack);
        }

        $parentList = $stack[count($stack) - 1]['list'];
        $parentList->appendChild($li);

        $next = $listItems[$index + 1] ?? null;
        if ($next && $next['indent'] > $indent) {
            $newList = $doc->createElement($tagName);
            $li->appendChild($newList);
            $stack[] = ['list' => $newList, 'indent' => $indent];
        }
    }

    return $rootList;
}