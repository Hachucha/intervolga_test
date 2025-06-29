<?php

/* 
функция обрезает фрагмент HTML до указанного количества слов, 
но не оборачивает body и теряет head, т.к. это экзотические случаи, 
но можно вставить проверку
*/
function truncateHtmlWords(string $html, int $wordLimit): string {
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $body = $doc->getElementsByTagName('body')->item(0);
    $currentCount = 0;
    $reachedLimit = false;

    $truncated = new DOMDocument();
    $fragment = $truncated->createDocumentFragment();

    function recurseNodes($node, $parent, &$currentCount, $limit, &$reachedLimit, $truncated) {
        foreach ($node->childNodes as $child) {
            if ($reachedLimit) break;

            if ($child->nodeType === XML_TEXT_NODE) {
                // Разбиваем текст на слова и разделители
                $words = preg_split('/(\s+)/u', $child->nodeValue, -1, PREG_SPLIT_DELIM_CAPTURE);
                $buffer = '';
                foreach ($words as $word) {
                    // Если слово (а не разделитель)
                    if (preg_match('/\S/u', $word)) {
                        if ($currentCount >= $limit) {
                            $reachedLimit = true;
                            break;
                        }
                        $currentCount++;
                    }
                    $buffer .= $word;
                }
                // Добавляем содержимое в родительский элемент
                $parent->appendChild($truncated->createTextNode($buffer));
            } elseif ($child->nodeType === XML_ELEMENT_NODE) {
                // Переносим узел со всеми атрибутами
                $newEl = $truncated->createElement($child->nodeName);
                foreach ($child->attributes as $attr) {
                    $newEl->setAttribute($attr->nodeName, $attr->nodeValue);
                }
                $parent->appendChild($newEl);
                // Запускаем эту функцию(это рекурсия) от этого узла
                recurseNodes($child, $newEl, $currentCount, $limit, $reachedLimit, $truncated);
            }
        }
    }

    recurseNodes($body, $fragment, $currentCount, $wordLimit, $reachedLimit, $truncated);
    $truncated->appendChild($fragment);

    $html = $truncated->saveHTML();
    // Убираем <html><body>, которое добавляет loadHTML и добавляем многоточие
    $html = preg_replace('~^<!DOCTYPE.+?<body>|</body></html>$~s', '', $html);
    return trim($html). ($reachedLimit ? '…' : '');
}
