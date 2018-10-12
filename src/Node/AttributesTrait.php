<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Node;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
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
        // Always use only the first declaration (ease sanitization)
        if (!array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $value;
        }
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
