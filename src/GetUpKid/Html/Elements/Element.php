<?php

namespace GetUpKid\Html\Elements;

abstract class Element
{
    protected $attributes = [];

    protected $content;

    protected $element;

    protected $close;

    protected function setAttribute($attribute, $value = null)
    {
        if (is_null($value)) {
            return;
        }

        $this->attributes[$attribute] = $value;
    }

    protected function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);
    }

    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

    public function data($attribute, $value = null)
    {
        if (is_array($attribute)) {
            foreach ($attribute as $key => $val) {
                $this->setAttribute('data-' . $key, $val);
            }
        } else {
            $this->setAttribute('data-' . $attribute, $value);
        }

        return $this;
    }

    public function attribute($attribute, $value)
    {
        $this->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * Set the content of the element.
     * 
     * @param  string  $content This could be any string or another element injected into the method.
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * A wrapper for $this->content(). Does the same thing.
     * 
     * @param  string  $text This could be any string or another element injected into the method.
     */
    public function text($text)
    {
        $this->content = $text;
        return $this;
    }

    /**
     * Provides a fluent option to close the element.
     * 
     * @param  string  $text This could be any string or another element injected into the method.
     */
    public function close()
    {
        $this->close = "</{$this->element}>";
        return $this;
    }

    public function clear($attribute)
    {
        if (!isset($this->attributes[$attribute])) {
            return $this;
        }

        $this->removeAttribute($attribute);

        return $this;
    }

    public function addClass($class)
    {
        if (isset($this->attributes['class'])) {
            $class = $this->attributes['class'] . ' ' . $class;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    public function removeClass($class)
    {
        if (!isset($this->attributes['class'])) {
            return $this;
        }

        $class = trim(str_replace($class, '', $this->attributes['class']));
        if ($class == '') {
            $this->removeAttribute('class');
            return $this;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    public function id($id)
    {
        $this->setId($id);

        return $this;
    }

    protected function setId($id)
    {
        $this->setAttribute('id', $id);
    }

    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }

    protected function renderAttributes()
    {
        list($attributes, $values) = $this->splitKeysAndValues($this->attributes);

        return implode(array_map(function ($attribute, $value) {
            return sprintf(' %s="%s"', $attribute, $this->escape($value));
        }, $attributes, $values));
    }

    protected function splitKeysAndValues($array)
    {
        // Disgusting crap because people might have passed a collection
        $keys = [];
        $values = [];

        foreach ($array as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
        }

        return [$keys, $values];
    }

    protected function setBooleanAttribute($attribute, $value)
    {
        if ($value) {
            $this->setAttribute($attribute, $attribute);
        } else {
            $this->removeAttribute($attribute);
        }
    }

    protected function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    public function __call($method, $params)
    {
        $params = count($params) ? $params : [$method];
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }
}
