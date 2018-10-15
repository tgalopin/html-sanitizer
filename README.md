# html-sanitizer

[![Build Status](https://travis-ci.org/tgalopin/html-sanitizer.svg?branch=master)](https://travis-ci.org/tgalopin/html-sanitizer)
[![SymfonyInsight](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b/mini.png)](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b)

html-sanitizer is a library aiming at handling, cleaning and sanitizing HTML sent by external users
(who you cannot trust), allowing you to store it and display it safely. It has sensible defaults
to provide a great developer experience while still being entirely configurable.

Internally, the sanitizer has a deep understanding of HTML: it parses the input and create a tree of
DOMNode objects, which it uses to keep only the safe elements from the content. By using this
technique, it is safe (it works with a strict whitelist), fast and easily extensible.

It also provides useful features such as the possibility to transform images URLs to HTTPS, or 
to add a `target="_blank"` attribute on all the links to external websites.

- [Installation](#installation)
- [Basic usage](#basic-usage)
- [Extensions](#extensions)
- [Filtering images hosts](#filtering-images-hosts)
- [Filtering links targets, opening external links in a new window](#filtering-links-targets-opening-external-links-in-a-new-window)
- [Configuring allowed attributes](#configuring-allowed-attributes)
- [Creating an extension to allow custom tags](#creating-an-extension-to-allow-custom-tags)
- [Configuration reference](#configuration-reference)

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

## Filtering images hosts

The sanitizer image extension provides a feature to filter images hosts, which can be useful 
to avoid connecting to external websites that may, for instance, track your website views.

To enable this feature, you need to enable the `image` extension and configure the `img` tag:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['image'],
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
            
            /*
            * If true, all images URLs using the HTTP protocol will be rewritten to use HTTPS instead.
            */
            'force_https' => false,
        ],
    ],
]);
```

## Filtering links targets, opening external links in a new window

The sanitizer basic extension provides a feature to filter and manipulate links in order to
avoid your users to leave your website for potentially dangerous external pages.

To enable this feature, you need to enable the `basic` extension and configure the `a` tag:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    'extensions' => ['basic'],
    'tags' => [
        'a' => [
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

## Creating an extension to allow custom tags

If you want to use additional tags than the one present in the sanitizer core extensions, you can create your
own extension.

There are two steps in the creation of an extension to handle additional tags: creating the node visitor which
will handle the custom tag, and registering it using an extension.

You can also have a look at the custom tag extension in the tests to better understand how to create your own:
https://github.com/tgalopin/html-sanitizer/tree/master/tests/Extension. 

### Creating a node and a node visitor

A node visitor is a class able to handle DOMNode instances of a certain type. It needs to implement the
`HtmlSanitizer\Visitor\VisitorInterface`.

A node visitor is responsible of adding a node to the tree of safe HTML by filtering the DOMNode
it's given. Thus, for an example `my-tag` custom tag, we need to create two classes: a Node and 
a NodeVisitor.

The node could look like this:

```php
namespace App\Sanitizer;

use HtmlSanitizer\Node\AbstractTagNode;
use HtmlSanitizer\Node\HasChildrenTrait;

class MyTagNode extends AbstractTagNode
{
    use HasChildrenTrait; // Or IsChildlessTrait

    public function getTagName(): string
    {
        return 'my-tag';
    }
}
```

A simple visitor for a `my-tag` custom tag could look like this:

```php
namespace App\Sanitizer;

use HtmlSanitizer\Model\Cursor;
use HtmlSanitizer\Node\NodeInterface;
use HtmlSanitizer\Visitor\AbstractNodeVisitor;
use HtmlSanitizer\Visitor\HasChildrenNodeVisitorTrait;

class MyTagNodeVisitor extends AbstractNodeVisitor
{
    use HasChildrenNodeVisitorTrait; // Or IsChildlessTagVisitorTrait

    protected function getDomNodeName(): string
    {
        return 'my-tag';
    }

    public function getDefaultAllowedAttributes(): array
    {
        return [
            'class', 'width', 'height'
        ];
    }

    public function getDefaultConfiguration(): array
    {
        return [
            'custom_config' => null,
        ];
    }

    protected function createNode(\DOMNode $domNode, Cursor $cursor): NodeInterface
    {
        // You need to pass the current node as your node parent
        $node = new MyTagNode($cursor->node);
        
        // You can use $this->config['custom_config'] to access the user-defined configuration

        return $node;
    }
}
```

To learn more on how to create a node and a node visitor suiting your needs, we recommend you to read
the existing [nodes](https://github.com/tgalopin/html-sanitizer/tree/master/src/Node) 
and [visitors](https://github.com/tgalopin/html-sanitizer/tree/master/src/Visitor).

### Registering the node visitor with an extension

Once you created a node and a node visitor, you need to use an extension to register the visitor in the
sanitizer.

An extension is a class implementing the `HtmlSanitizer\Extension\ExtensionInterface` interface, which requires
two methods:

- `getName()` which should return the name to use in the configuration (`basic`, `list`, etc.) ;
- and `createNodeVisitors()` which should return a list of node visitors associated to the tag the visit ;

For our node visitor, this could look like this:

```php
namespace App\Sanitizer;

use HtmlSanitizer\Extension\ExtensionInterface;

class MyTagExtension implements ExtensionInterface
{
    public function getName(): string
    {
        return 'my-tag';
    }

    public function createNodeVisitors(array $config = []): array
    {
        return [
            'my-tag' => new MyTagNodeVisitor($config['tags']['my-tag'] ?? []),
            
            // You can also override previous extensions tags here, for instance:
            // 'img' => new MyCustomImgVisitor(),
        ];
    }
}
```

Then, you can use the builder to create a Sanitizer that include this extension:

```php
$builder = new HtmlSanitizer\SanitizerBuilder();
$builder->registerExtension(new HtmlSanitizer\Extension\BasicExtension());
$builder->registerExtension(new HtmlSanitizer\Extension\ListExtension());
// Add the other core ones you need

$builder->registerExtension(new App\Sanitizer\MyTagExtension());

$sanitizer = $builder->build([
    'extensions' => ['basic', 'list', 'my-tag'],
});
```

## Configuration reference

Here is the configuration default values with annotations describing the specific configuration keys:

```php
$sanitizer = HtmlSanitizer\Sanitizer::create([
    /*
     * List of extensions to enable on this sanitizer.
     */
    'extensions' => ['basic', 'list', 'table', 'image', 'code', 'iframe', 'extra'],

    /*
     * Configuration for specific tags.
     */
    'tags' => [
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
             * If true, all images URLs using the HTTP protocol will be rewritten to use HTTPS instead.
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

Thanks to the contributors of the Masterminds great HTML5 parser on which this sanitizer depends on:
[Masterminds/html5-php](https://github.com/Masterminds/html5-php)!
