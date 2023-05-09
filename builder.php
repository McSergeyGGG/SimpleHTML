<?php



class HtmlBuilder {

    protected $html;



    public function __construct() {

        $this->html = '';

    }



    public function style($selector, $properties) {

        $css = $selector . " {";

        foreach ($properties as $property => $value) {

            $css .= "{$property}: {$value};";

        }

        $css .= "}";

        $this->tag('style', $css);

    }



    public function openTag($tag, $attributes = []) {

        $this->html .= "<$tag";

        foreach ($attributes as $name => $value) {

            $this->html .= " $name=\"$value\"";

        }

        $this->html .= ">";

    }



    public function closeTag($tag) {

        $this->html .= "</$tag>";

    }



    public function addContent($content) {

        $this->html .= htmlspecialchars($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    }



    public function tag($tag, $content = null, $attributes = []) {

        $this->openTag($tag, $attributes);

        if ($content !== null) {

            $this->addContent($content);

        }

        $this->closeTag($tag);

    }



    public function link($url, $text, $attributes = []) {

        $this->tag('a', $text, array_merge(['href' => $url], $attributes));

    }



    public function image($src, $alt = null, $attributes = []) {

        $this->tag('img', null, array_merge(['src' => $src, 'alt' => $alt], $attributes));

    }



    public function listUl($items, $attributes = []) {

        $this->openTag('ul', $attributes);

        foreach ($items as $item) {

            $this->tag('li', $item);

        }

        $this->closeTag('ul');

    }



    public function table($headers, $rows, $attributes = []) {

        $this->openTag('table', $attributes);

        $this->tag('thead');

        $this->tag('tr');

        foreach ($headers as $header) {

            $this->tag('th', $header);

        }

        $this->closeTag('tr');

        $this->closeTag('thead');

        $this->tag('tbody');

        foreach ($rows as $row) {

            $this->tag('tr');

            foreach ($row as $cell) {

                $this->tag('td', $cell);

            }

            $this->closeTag('tr');

        }

        $this->closeTag('tbody');

        $this->closeTag('table');

    }



    public function display() {

        echo $this->html;

    }

}
