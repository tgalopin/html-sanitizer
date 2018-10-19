<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Basic\Sanitizer;

use HtmlSanitizer\Sanitizer\UrlSanitizerTrait;

/**
 * @internal
 */
class AHrefSanitizer
{
    use UrlSanitizerTrait;

    /**
     * @var bool
     */
    private $allowMailTo;

    public function __construct(?array $allowedHosts, bool $allowMailTo)
    {
        $this->allowedHosts = $allowedHosts;
        $this->allowMailTo = $allowMailTo;
    }

    public function sanitize(?string $input): ?string
    {
        $url = $this->parseAndCleanUrl($input, ['https', 'http', 'mailto']);
        if (!$url) {
            return null;
        }

        // Local URL
        if ($this->isLocalUrl($url)) {
            return $this->buildUrl($url);
        }

        // mailto
        if ($url['scheme'] === 'mailto') {
            if (!$this->allowMailTo || empty($url['path'])) {
                return null;
            }

            // Simple check that the e-mail is valid
            if (mb_strpos($url['path'], '@') === false || mb_strpos($url['path'], '.') === false) {
                return null;
            }

            return $this->buildUrl($url);
        }

        // Absolute URL: check host
        if (!$url['host'] || !$this->isAllowedHost($url['host'])) {
            return null;
        }

        // Allowed: rebuild a clean URL
        return $this->buildUrl($url);
    }
}
