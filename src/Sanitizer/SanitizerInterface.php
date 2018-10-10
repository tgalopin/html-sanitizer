<?php

namespace HtmlPurifier\Sanitizer;

interface SanitizerInterface
{
    /**
     * Sanitie a given string to return a trustable value.
     * Returns null if the sanitizer could not find a trustable value to extract from the input.
     *
     * @param null|string $input
     *
     * @return null|string
     */
    public function sanitize(?string $input): ?string;
}
