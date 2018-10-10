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

    public function setAttribute(string $name, ?string $value)
    {
        $this->attributes[$name] = $value;
    }

    private function renderAttributes(): string
    {
        $rendered = [];
        foreach ($this->attributes as $name => $value) {
            if ($value === null) {
                // Tag should be removed as a sanitizer found suspect data inside
                continue;
            }

            $attr = $name;
            if ($value !== '') {
                $attr .= '="'.$value.'"';
            }

            $rendered[] = $attr;
        }

        return $rendered ? ' '.implode(' ', $rendered) : '';
    }
}
