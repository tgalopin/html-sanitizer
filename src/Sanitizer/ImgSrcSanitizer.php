<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Sanitizer;

/**
 * @internal
 */
class ImgSrcSanitizer
{
    use UrlSanitizerTrait;

    /**
     * @var bool
     */
    private $allowDataUri;

    /**
     * @var bool
     */
    private $forceHttps;

    public function __construct(?array $allowedHosts, bool $allowDataUri, bool $forceHttps)
    {
        $this->allowedHosts = $allowedHosts;
        $this->allowDataUri = $allowDataUri;
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

        // Local image
        if ($this->isLocalUrl($url)) {
            return $input;
        }

        // Data-URI
        if (isset($url['scheme']) && $url['scheme'] === 'data') {
            if (!$this->allowDataUri || empty($url['path'])) {
                return null;
            }

            if (mb_strpos($url['path'], 'image/') !== 0) {
                // Allow only images as content type
                return null;
            }

            return $input;
        }

        if (!isset($url['host'])) {
            // If there is no host and it's also not a local image nor a data-uri, this is an invalid string
            return null;
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
