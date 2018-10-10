<?php

namespace HtmlPurifier;

interface PurifierInterface
{
    /**
     * Purify a given untrusted HTML source string to return a trustable one.
     * This usually includes removal of all the sources of XSS, and may also includes
     * additional protections like images sources and links targets filters.
     *
     * @param string $html
     *
     * @return string
     */
    public function purify(string $html): string;
}
