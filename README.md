# html-sanitizer

> This package is in beta for now, until we are confident that every aspect of security related to HTML
> sanitization is appropriately covered.

[![Build Status](https://travis-ci.org/tgalopin/html-sanitizer.svg?branch=master)](https://travis-ci.org/tgalopin/html-sanitizer)

[![SymfonyInsight](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b/big.svg)](https://insight.symfony.com/projects/befd5a5b-574c-4bea-9c4f-3ad202729a1b)

html-sanitizer is a library aiming at handling, cleaning and sanitizing HTML sent by external users
(who you cannot trust), allowing you to store it and display it safely. It has sensible defaults
to provide a great developer experience while still being entirely configurable.

Internally, the sanitizer has a deep understanding of HTML: it parses the input and create a tree of
DOMNode objects, which it uses to keep only the safe elements from the content. By using this
technique, it is safe (it works with a strict whitelist), fast and easily extensible.

It also provides useful features such as the possibility to transform images or iframes URLs to HTTPS.

## Symfony integration

This library is also available as [a Symfony bundle](https://github.com/tgalopin/html-sanitizer-bundle).

## Documentation

1. [Getting started](https://github.com/tgalopin/html-sanitizer/blob/master/docs/1-getting-started.md)
2. [Creating an extension to allow custom tags](https://github.com/tgalopin/html-sanitizer/blob/master/docs/2-creating-an-extension-to-allow-custom-tags.md)
3. [Configuration reference](https://github.com/tgalopin/html-sanitizer/blob/master/docs/3-configuration-reference.md)

## Security Issues

If you discover a security vulnerability within Symfony, please follow
[our disclosure procedure](https://github.com/tgalopin/html-sanitizer/blob/master/docs/A-security-disclosure-procedure.md).

## Thanks

Many thanks to:
- [The Open Web Application Security Project](https://www.owasp.org/index.php/OWASP_Java_HTML_Sanitizer_Project) 
  from which many of the tests of this library are extracted (more specifically from
  [OWASP/java-html-sanitizer](https://github.com/OWASP/java-html-sanitizer)) ;
- [Masterminds/html5-php](https://github.com/Masterminds/html5-php) which is a great HTML5 parser, used by default
  in this library ;
- [The PHP League URI parser](http://uri.thephpleague.com/) which allows this library to filter hosts safely ;
