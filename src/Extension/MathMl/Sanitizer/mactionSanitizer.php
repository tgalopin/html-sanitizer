<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\MathMl\Sanitizer;

use HtmlSanitizer\Sanitizer\UrlSanitizerTrait;

/**
 * @internal
 */
class MactionSanitizer
{
    use UrlSanitizerTrait;

    private $allowedSchemes;
    private $allowedHosts;
    private $allowMailTo;
    private $forceHttps;

    public function __construct(array $allowedSchemes, ?array $allowedHosts, bool $allowMailTo, bool $forceHttps)
    {
        $this->allowedSchemes = $allowedSchemes;
        $this->allowedHosts = $allowedHosts;
        $this->allowMailTo = $allowMailTo;
        $this->forceHttps = $forceHttps;
    }

    public function sanitize(?string $input): ?string
    {
        $allowedSchemes = $this->allowedSchemes;
        $allowedHosts = $this->allowedHosts;

        if ($this->allowMailTo) {
            $allowedSchemes[] = 'mailto';

            if (\is_array($this->allowedHosts)) {
                $allowedHosts[] = null;
            }
        }

        if (!$sanitized = $this->sanitizeUrl($input, $allowedSchemes, $allowedHosts, $this->forceHttps)) {
            return null;
        }

        // Basic validation that it's an e-mail
        if (0 === strpos($sanitized, 'mailto:') && (false === strpos($sanitized, '@') || false === strpos($sanitized, '.'))) {
            return null;
        }

        return $sanitized;
    }
}
