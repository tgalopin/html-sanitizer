# html-purifier

[![SymfonyInsight](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b/mini.png)](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b)
[![Build Status](https://travis-ci.org/tgalopin/html-purifier.svg?branch=master)](https://travis-ci.org/tgalopin/html-purifier)

html-purifier is a library aiming at handling, cleaning and sanitizing HTML sent by external users
(that you cannot trust), allowing you to store it and display it safely. It has sensible defaults
aiming at proving a great developer experience while still being entierely configurable.

Internally, the purifier has a deep understanding of HTML: it parses the input and create a tree of
DOMNode objects

It also provides useful features such as the possibility to tranform images URLs to HTTPS or 
to add a `target="_blank"` attribute on all your links targeting different websites.

- [1. Installation](#installation)
- [2. Basic usage](#basic-usage)
- [3. Presets](#presets)
- [4. Configuring allowed tags](#configuring-allowed-tags)
- [5. Configuring allowed attributes](#configuring-allowed-attributes)
- [6. Configuration reference](#configuration-reference)

## Installation

html-purifier requires PHP 7.1+ and the `ext-dom` extension.

You can install the library using the following command:

```
composer require tgalopin/html-purifier
```

## Basic usage

The main entrypoint to the purifier is the `HtmlPurifier\Purifier` class. It requires
an array of configuration that will be used for all the features of the purifier.

The purifier works on a whitelist basis: you will need to tell it every tags and every
attribute you would like to allow in the HTML. Fortunately, the library also provides
what we call presets, to improve developer experience: a preset is a list of pre-configured
tags and attributes that you can easily use out of the box to get a Purifier up and running
quickly. 

Thus a simple first example using the `basic` preset could look like this:

```php
<?php

$purifier = new HtmlPurifier\Purifier(['presets' => ['basic']]);
$safeHtml = $purifier->purify($untrustedHtml);
```

## Presets

There are 7 presets available, which add allowed tags and attributes and configure the purifier
accordingly:

- `basic` allows the insertion of basic HTML elements, corresponding to the following tags:
    - `a`
    - `b`
    - `br`
    - `blockquote`
    - `div`
    - `del`
    - `em`
    - `figcaption`
    - `figure`
    - `h1`
    - `h2`
    - `h3`
    - `h4`
    - `h5`
    - `h6`
    - `i`
    - `p`
    - `q`
    - `small`
    - `span`
    - `strong`
    - `sub`
    - `sup`
- `list` allows the insertion of lists, corresponding to the following tags:
    - `dd`
    - `dl`
    - `dt`
    - `li`
    - `ol`
    - `ul`
- `table` allows the insertion of tables, corresponding to the following tags:
    - `table`
    - `thead`
    - `tbody`
    - `tfoot`
    - `tr`
    - `td`
    - `th`
- `image` allows the insertion of images, corresponding to the `img` tag
- `code` allows the insertion of code blocks, corresponding to the `pre` and `code` tags
- `iframe` allows the insertion of images, corresponding to the `iframe` tag
- `extra` allows the insertion of tables, corresponding to the following tags:
    - `abbr`
    - `caption`
    - `hr`
    - `rp`
    - `rt`
    - `ruby`

You can use all the presets to allow for rich content to be inserted in your application:

```php
<?php

$purifier = new HtmlPurifier\Purifier(['presets' => ['basic', 'list', 'table', 'image', 'code', 'iframe', 'extra']]);
$safeHtml = $purifier->purify($untrustedHtml);
```

## Configuring allowed tags

In addition (or instead of) presets, you can configure specific tags, either to allow more attributes on
them, to configure specific features or simply to allow them in the input.

> **Note**: if you configure custom tags this way, they won't be taken into account.
> Instead, you should create a purifier extension (TODO: create the extension system).  

For instance, if you want only the basic tags and unordered lists:

```php
<?php

$purifier = new HtmlPurifier\Purifier([
    'presets' => ['basic'],
    'allowed_tags' => [
        'ul' => [],
        'li' => [],
    ],
]);
```

Technically speaking, presets are only a preconfigured list of allowed tags and attributes. Therefore you can
customize as you wish the purifier if you want too by removing all the presets. However, it also means you have
to explicitely allow all the tags you need:

```php
<?php

// Allow ONLY strong, em and br (this configuration will remove all the other tags) 
$purifier = new HtmlPurifier\Purifier([
    'allowed_tags' => [
        'strong' => [],
        'em' => [],
        'br' => [],
    ],
]);
```

## Configuring allowed attributes

In each allowed tag, you can pass dedicated configuration to this tag in the array associated to the tag name.
All the tags have sensible default allowed attributes but you can override them using the `allowed_attributes` key.

For instance, to allow the `class` attribute on a `div` tag, you can use the following configuration:

```php
<?php

$purifier = new HtmlPurifier\Purifier([
    'presets' => ['basic'],
    'allowed_tags' => [
        'div' => [
            'allowed_attributes' => ['class'],
        ],
    ],
]);
```

## Configuration reference

Here is the configuration default values with annotations describing the specific configuration keys:

```php
<?php

$purifier = new HtmlPurifier\Purifier([
    'presets' => ['basic', 'list', 'table', 'image', 'code', 'iframe', 'extra'],
    'allowed_tags' => [
        'abbr' => [
            'allowed_attributes' => [],
        ],
        'a' => [
            'allowed_attributes' => ['href', 'title'],
            
            /*
            * If an array is provided, all the links targeting other hosts than one in this array
            * will be disabled (the `href` attribute will be blank). This can be useful if you want
            * to prevent links to target external websites.
            *
            * Any allowed domain also includes its subdomains.
            *
            *      'allowed_hosts' => ['trusted1.com', 'google.com'],
            */
            'allowed_hosts' => null,
            
            /*
            * If false, all links containing a mailto target will be disabled (the `href` attribute
            * will be blank).
            */
            'allow_mailto' => true,
            
            /*
            * If an array is provided, a `target="_blank"` attribute will be added to all the links.
            * You can also provide a list of excluded hosts for this rule using the `except_hosts` key.
            *
            * Any excluded host also includes its subdomains.
            *
            *      'force_target_blank' => [], // All links
            *      'force_target_blank' => ['except_hosts' => ['trusted1.com']], // All links except trusted1.com
            */
            'force_target_blank' => null,
        ],
        'blockquote' => [
            'allowed_attributes' => [],
        ],
        'br' => [
            'allowed_attributes' => [],
        ],
        'caption' => [
            'allowed_attributes' => [],
        ],
        'code' => [
            'allowed_attributes' => [],
        ],
        'dd' => [
            'allowed_attributes' => [],
        ],
        'del' => [
            'allowed_attributes' => [],
        ],
        'div' => [
            'allowed_attributes' => [],
        ],
        'dl' => [
            'allowed_attributes' => [],
        ],
        'dt' => [
            'allowed_attributes' => [],
        ],
        'em' => [
            'allowed_attributes' => [],
        ],
        'figcaption' => [
            'allowed_attributes' => [],
        ],
        'figure' => [
            'allowed_attributes' => [],
        ],
        'h1' => [
            'allowed_attributes' => [],
        ],
        'h2' => [
            'allowed_attributes' => [],
        ],
        'h3' => [
            'allowed_attributes' => [],
        ],
        'h4' => [
            'allowed_attributes' => [],
        ],
        'h5' => [
            'allowed_attributes' => [],
        ],
        'h6' => [
            'allowed_attributes' => [],
        ],
        'hr' => [
            'allowed_attributes' => [],
        ],
        'iframe' => [
            'allowed_attributes' => ['src', 'width', 'height', 'frameborder', 'title', 'allow', 'allowfullscreen'],
        
            /*
            * If an array is provided, all the frames relying on other hosts than one in this array
            * will be disabled (the `src` attribute will be blank). This can be useful if you want
            * to prevent frames from external websites.
            *
            * Be careful: some website integrations rely in frames and may break if you use this
            * configuration key.
            *
            * Any allowed domain also includes its subdomains.
            *
            *      'allowed_hosts' => ['trusted1.com', 'google.com'],
            */
            'allowed_hosts' => null,
            
            /*
            * If true, all frames URLS using the HTTP protocol will be rewritten to use HTTPS instead.
            */
            'force_https' => false,
        ],
        'img' => [
            'allowed_attributes' => ['src', 'alt', 'title'],
            
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
            
            /*
            * If true, all images URLs using the HTTP ptocol will be rewritten to use HTTPS instead.
            */
            'force_https' => false,
        ],
        'i' => [
            'allowed_attributes' => [],
        ],
        'li' => [
            'allowed_attributes' => [],
        ],
        'ol' => [
            'allowed_attributes' => [],
        ],
        'pre' => [
            'allowed_attributes' => [],
        ],
        'p' => [
            'allowed_attributes' => [],
        ],
        'q' => [
            'allowed_attributes' => [],
        ],
        'rp' => [
            'allowed_attributes' => [],
        ],
        'rt' => [
            'allowed_attributes' => [],
        ],
        'ruby' => [
            'allowed_attributes' => [],
        ],
        'small' => [
            'allowed_attributes' => [],
        ],
        'span' => [
            'allowed_attributes' => [],
        ],
        'strong' => [
            'allowed_attributes' => [],
        ],
        'sub' => [
            'allowed_attributes' => [],
        ],
        'sup' => [
            'allowed_attributes' => [],
        ],
        'table' => [
            'allowed_attributes' => [],
        ],
        'tbody' => [
            'allowed_attributes' => [],
        ],
        'td' => [
            'allowed_attributes' => [],
        ],
        'tfoot' => [
            'allowed_attributes' => [],
        ],
        'thead' => [
            'allowed_attributes' => [],
        ],
        'th' => [
            'allowed_attributes' => [],
        ],
        'tr' => [
            'allowed_attributes' => [],
        ],
        'ul' => [
            'allowed_attributes' => [],
        ],
    ],
]);
```

## Thanks

Thanks to the contributors of the Masterminds great HTML5 parser on which this purifier depends on:
[Masterminds/html5-php](https://github.com/Masterminds/html5-php)!
