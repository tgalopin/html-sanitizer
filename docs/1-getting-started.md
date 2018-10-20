# Getting started

- [Installation](#installation)
- [Basic usage](#basic-usage)
- [Extensions](#extensions)
- [Filtering images and iframes hosts](#filtering-images-and-iframes-hosts)
- [Forcing HTTPS on images and iframes source hosts](#forcing-https-on-images-and-iframes-source-hosts)
- [Configuring allowed attributes](#configuring-allowed-attributes)

## Installation

html-sanitizer requires PHP 7.1+.

You can install the library using the following command:

```
composer require tgalopin/html-sanitizer
```

## Basic usage

The main entry point to the sanitizer is the `HtmlSanitizer\Sanitizer` class. It requires
an array of configuration:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create(['extensions' => ['basic']]);
$safeHtml = $sanitizer->sanitize($untrustedHtml);
```

The sanitizer works using *extensions*. Extensions are a set of features that you can easily
enable to allow specific tags in the content (read the next part to learn more about them). 

> Note that the sanitizer is working using a strict whitelist of allowed tags: in the previous example,
> the sanitizer would allow **only** the basic HTML5 tags (`strong`, `a`, `div`, etc., ).

## Extensions

Extensions are a way to quickly add sets of tags to the whitelist of allowed tags.
There are 7 core extensions that you can enable by adding them in your configuration:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['basic', 'code', 'image', 'list', 'table', 'iframe', 'extra'],
]);
$safeHtml = $sanitizer->sanitize($untrustedHtml);
```

Here is the list of tags each extension allow:

- **basic** allows the insertion of basic HTML elements:
  `a`, `b`, `br`, `blockquote`, `div`, `del`, `em`, `figcaption`, `figure`, `h1`, `h2`, `h3`, `h4`, `h5`, 
  `h6`, `i`, `p`, `q`, `small`, `span`, `strong`, `sub`, `sup`
- **list** allows the insertion of lists: 
  `dd`, `dl`, `dt`, `li`, `ol`, `ul`
- **table** allows the insertion of tables: 
  `table`, `thead`, `tbody`, `tfoot`, `tr`, `td`, `th`
- **image** allows the insertion of images: `img`
- **code** allows the insertion of code blocks: `pre`, `code`
- **iframe** allows the insertion of iframes: `iframe`
- **extra** allows the insertion of the following tags: `abbr`, `caption`, `hr`, `rp`, `rt`, `ruby`

## Filtering images and iframes hosts

The sanitizer image and iframe extensions provide a feature to filter hosts, which can be useful 
to avoid connecting to external websites that may, for instance, track your website views.

To enable this feature, you need to enable the `image` and/or `iframe` extension and configure the tag:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['image', 'iframe'],
    'tags' => [
        'img' => [
            /*
            * If an array is provided, all the images relying on other hosts than one in this array
            * will be disabled (the `src` attribute will be blank). This can be useful if you want
            * to prevent images contacting external websites.
            *
            * Any allowed domain also includes its subdomains.
            *
            *      'allowed_hosts' => ['trusted1.com', 'google.com'],
            */
            'allowed_hosts' => null,
            
            /*
            * If true, images data-uri URLs will be accepted.
            */
            'allow_data_uri' => false,
        ],
        
        'iframe' => [
            /*
            * If an array is provided, all the iframes relying on other hosts than one in this array
            * will be disabled (the `src` attribute will be blank). This can be useful if you want
            * to prevent iframes contacting external websites.
            *
            * Any allowed domain also includes its subdomains.
            *
            *      'allowed_hosts' => ['trusted1.com', 'google.com'],
            */
            'allowed_hosts' => null,
        ],
    ],
]);
```

## Forcing HTTPs on images and iframes source hosts

The sanitizer image and iframe extensions provide a feature to force HTTPs on targeted hosts.

To enable this feature, you need to enable the `image` and/or `iframe` extension and configure the tag:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['image', 'iframe'],
    'tags' => [
        'img' => [
            /*
             * If true, all images URLs using the HTTP protocol will be rewritten to use HTTPS instead.
             */
            'force_https' => false,
        ],
        
        'iframe' => [
            /*
             * If true, all iframes URLs using the HTTP protocol will be rewritten to use HTTPS instead.
             */
            'force_https' => false,
        ],
    ],
]);
```

## Configuring allowed attributes

The core extensions define sensible default allowed attributes for each tag, which mean you usually won't need
to change them. However, if you want to customize which attributes are allowed on specific tags, you can use
a tag-specific configuration for them. 

For instance, to allow the `class` attribute on the `div` and `img` tags, you can use the following configuration:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['basic'],
    'tags' => [
        'div' => [
            'allowed_attributes' => ['class'],
        ],
        'img' => [
            'allowed_attributes' => ['src', 'alt', 'title', 'class'],
        ],
    ],
]);
```
