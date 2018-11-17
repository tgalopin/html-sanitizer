<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Iframe\Sanitizer;

use HtmlSanitizer\Sanitizer\UrlSanitizerTrait;

/**
 * @internal
 */
class IframeSrcSanitizer
{
    use UrlSanitizerTrait;

    private $allowedHosts;
    private $forceHttps;

    public function __construct(?array $allowedHosts, bool $forceHttps)
    {
        $this->allowedHosts = $allowedHosts;
        $this->forceHttps = $forceHttps;
    }

    public function sanitize(?string $input): ?string
    {
        return $this->sanitizeUrl($input, ['http', 'https'], $this->allowedHosts, $this->forceHttps);
    }
}
