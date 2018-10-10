<?php

namespace HtmlPurifier\Sanitizer;

/**
 * @internal
 */
class AHrefSanitizer implements SanitizerInterface
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

        if (is_array($allowedHosts)) {
            // Pre-split the hosts for hosts checks
            $this->allowedHosts = [];
            foreach ($allowedHosts as $allowedHost) {
                $this->allowedHosts[] = array_reverse(explode('.', $allowedHost));
            }
        }
    }

    public function sanitize(string $input): ?string
    {
        $url = parse_url($input);
        if (!is_array($url)) {
            // Malformed URL
            return null;
        }

        // Local link
        if ($this->isLocalUrl($url)) {
            return $input;
        }

        // mailto
        if (isset($url['scheme']) && $url['scheme'] === 'mailto') {
            if (!$this->allowMailTo || empty($url['path'])) {
                return null;
            }

            if (mb_strpos($url['path'], '@') === false || mb_strpos($url['path'], '.') === false) {
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

        return $input;
    }
}
