<?php

namespace HtmlPurifier\Node;

trait AttributesTrait
{
    /**
     * @var array
     */
    private $attributes = [];

    public function getAttribute(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    public function setAttribute(string $name, string $value)
    {
        $this->attributes[$name] = $value;
    }

    private function renderAttributes(): string
    {
        $rendered = [];
        foreach ($this->attributes as $name => $value) {
            $rendered[] = $name.'="'.$value.'"';
        }

        return $rendered ? ' '.implode(' ', $rendered) : '';
    }
}
