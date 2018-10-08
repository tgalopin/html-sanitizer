<?php

namespace HtmlPurifier\Node;

trait TagNodeTrait
{
    use AttributesTrait;

    abstract public function getTagName(): string;

    abstract public function canHaveChildren(): bool;

    public function render(): string
    {
        $tag = $this->getTagName();

        if ($this->canHaveChildren()) {
            return '<'.$tag.$this->renderAttributes().'>'.$this->renderChildren().'</'.$tag.'>';
        }

        return '<'.$tag.$this->renderAttributes().' />';
    }
}
