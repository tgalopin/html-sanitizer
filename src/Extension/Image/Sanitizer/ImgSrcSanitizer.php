<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlSanitizer\Extension\Image\Sanitizer;

use HtmlSanitizer\Sanitizer\UrlSanitizerTrait;

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
    }

    public function sanitize(?string $input): ?string
    {
        $url = $this->parseAndCleanUrl($input, ['https', 'http', 'mailto', 'data']);
        if (!$url) {
            return null;
        }

        // Local URL
        if ($this->isLocalUrl($url)) {
            return $this->buildUrl($url);
        }

        // data
        if ($url['scheme'] === 'data') {
            if (!$this->allowDataUri || empty($url['path'])) {
                return null;
            }

            // Allow only images as content type
            if (mb_strpos($url['path'], 'image/') !== 0) {
                return null;
            }

            return $this->buildUrl($url);
        }

        // Absolute URL: check host
        if (!$url['host'] || !$this->isAllowedHost($url['host'])) {
            return null;
        }

        // Force HTTPS
        if ($this->forceHttps && $url['scheme'] === 'http') {
            $url['scheme'] = 'https';
        }

        // Allowed: rebuild a clean URL
        return $this->buildUrl($url);
    }
}
