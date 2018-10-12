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
trait UrlSanitizerTrait
{
    /**
     * @var string[][]
     */
    private $allowedHosts;

    private function isLocalUrl(array $url): bool
    {
        return !isset($url['scheme']) && !isset($url['host']) && !isset($url['port'])
            && !isset($url['user']) && !isset($url['pass']);
    }

    private function isAllowedHost(string $host): bool
    {
        if ($this->allowedHosts === null) {
            return true;
        }

        $parts = array_reverse(explode('.', $host));

        foreach ($this->allowedHosts as $trustedParts) {
            if ($this->matchAllowedHostParts($parts, $trustedParts)) {
                return true;
            }
        }

        return false;
    }

    private function matchAllowedHostParts(array $uriParts, array $trustedParts): bool
    {
        // Check each chunk of the domain is either stricly equal or a wildcard
        foreach ($trustedParts as $key => $trustedPart) {
            if ($uriParts[$key] !== $trustedPart && '*' !== $trustedPart) {
                return false;
            }
        }

        return true;
    }
}
