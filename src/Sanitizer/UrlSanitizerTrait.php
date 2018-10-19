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

use function League\Uri\build;
use League\Uri\Exception as UriException;
use function League\Uri\parse;

/**
 * @internal
 */
trait UrlSanitizerTrait
{
    /**
     * @var string[]
     */
    private $allowedHosts;

    private function parseAndCleanUrl(?string $input, array $allowedSchemes): ?array
    {
        if ($input === null) {
            return null;
        }

        // Remove invalid characters
        $input = str_replace(["\n", "\t", "\r", chr(0)], '', $input);

        try {
            $url = parse($input);
        } catch (UriException $e) {
            return null;
        }

        // Malformed URL
        if (!is_array($url) || !$url) {
            return null;
        }

        // Invalid scheme
        if (!in_array($url['scheme'], array_merge($allowedSchemes, [null]), true)) {
            return null;
        }

        return $url;
    }

    private function isLocalUrl(array $url): bool
    {
        return $url['scheme'] === null && $url['host'] === null && $url['port'] === null
            && $url['user'] === null && $url['pass'] === null;
    }

    private function isAllowedHost(string $host): bool
    {
        if ($this->allowedHosts === null) {
            return true;
        }

        $parts = array_reverse(explode('.', $host));

        foreach ($this->allowedHosts as $allowedHost) {
            if ($this->matchAllowedHostParts($parts, array_reverse(explode('.', $allowedHost)))) {
                return true;
            }
        }

        return false;
    }

    private function matchAllowedHostParts(array $uriParts, array $trustedParts): bool
    {
        // Check each chunk of the domain is valid
        foreach ($trustedParts as $key => $trustedPart) {
            if ($uriParts[$key] !== $trustedPart) {
                return false;
            }
        }

        return true;
    }

    private function buildUrl(array $url): string
    {
        return build($url);
    }
}
