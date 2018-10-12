<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier\Sanitizer;

/**
 * @internal
 */
class IframeSrcSanitizer
{
    use UrlSanitizerTrait;

    /**
     * @var bool
     */
    private $forceHttps;

    public function __construct(?array $allowedHosts, bool $forceHttps)
    {
        $this->allowedHosts = $allowedHosts;
        $this->forceHttps = $forceHttps;

        if (is_array($allowedHosts)) {
            // Pre-split the hosts for hosts checks
            $this->allowedHosts = [];
            foreach ($allowedHosts as $allowedHost) {
                $this->allowedHosts[] = array_reverse(explode('.', $allowedHost));
            }
        }
    }

    public function sanitize(?string $input): ?string
    {
        if ($input === null) {
            return $input;
        }

        $url = parse_url($input);
        if (!is_array($url)) {
            // Malformed URL
            return null;
        }

        // Local frame
        if ($this->isLocalUrl($url)) {
            return $input;
        }

        // URL
        if (!filter_var($input, FILTER_VALIDATE_URL)) {
            // Invalid URL
            return null;
        }

        if (!$this->isAllowedHost($url['host'])) {
            return null;
        }

        if ($this->forceHttps && isset($url['scheme']) && $url['scheme'] === 'http') {
            return 'https'.mb_substr($input, 4);
        }

        return $input;
    }
}
