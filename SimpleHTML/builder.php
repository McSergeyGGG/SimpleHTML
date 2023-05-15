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

    public function br($count = null) {
        if ($count === null) {
            $this->openTag('br');
        } else {
            for ($i = 0; $i < $count; $i++) {
                $this->openTag('br');
            }
        }
        return $this;
    }

    public function form($action = null, $method = 'post', $attributes = []) {
        $attributes = array_merge(['action' => $action, 'method' => $method], $attributes);
        $this->openTag('form', $attributes);
        return $this;
    }

    public function button($text, $type = 'button', $attributes = []) {
        $attributes = array_merge(['type' => $type], $attributes);
        $this->tag('button', $text, $attributes);
        return $this;
    }

    public function input($name, $type = 'text', $attributes = []) {
        $attributes = array_merge(['name' => $name, 'type' => $type], $attributes);
        $this->tag('input', null, $attributes);
        return $this;
    }

    public function textarea($name, $value = null, $attributes = []) {
        $attributes = array_merge(['name' => $name], $attributes);
        $this->openTag('textarea', $attributes);
        $this->addContent($value);
        $this->closeTag('textarea');
        return $this;
    }

    public function select($name, $options, $attributes = [], $multiple = false) {
        $attributes = array_merge(['name' => $name], $attributes);
        if ($multiple === true) {
            $attributes['multiple'] = 'multiple';
        }
        $this->openTag('select', $attributes);
        foreach ((array)$options as $value => $text) {
            if (is_array($text)) {
                $attrs = $text;
                $text = $attrs['text'];
                unset($attrs['text']);
            } else {
                $attrs = ['value' => $value];
            }
            if ($value === '' && $text === '') {
                $attrs['value'] = '';
            }
            $selected = '';
            if (isset($_POST[$name])) {
                if (is_array($_POST[$name])) {
                    $selected = in_array($attrs['value'], $_POST[$name]) ? 'selected' : '';
                } else {
                    $selected = ($_POST[$name] == $attrs['value']) ? 'selected' : '';
                }
            }
            $this->tag('option', $text, array_merge($attrs, ['selected' => $selected]));
        }
        $this->closeTag('select');
        return $this;
    }

    public function display() {
        echo $this->html;
    }
}
