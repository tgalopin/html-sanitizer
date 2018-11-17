<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\HtmlSanitizer;

use HtmlSanitizer\Sanitizer;
use HtmlSanitizer\SanitizerInterface;

class FullSanitizerTest extends AbstractSanitizerTest
{
    public function createSanitizer(): SanitizerInterface
    {
        return Sanitizer::create([
            'extensions' => ['basic', 'code', 'image', 'list', 'table', 'iframe', 'extra'],
            'tags' => [
                'a' => [
                    'allowed_hosts' => ['trusted.com', 'external.com'],
                ],
                'img' => [
                    'allowed_hosts' => ['trusted.com'],
                    'force_https' => true,
                ],
                'iframe' => [
                    'allowed_hosts' => ['trusted.com'],
                    'force_https' => true,
                ],
            ],
        ]);
    }

    public function provideFixtures(): array
    {
        return array_merge(parent::provideFixtures(), [

            /*
             * Normal tags
             */

            [
                '<abbr class="foo">Lorem ipsum</abbr>',
                '<abbr>Lorem ipsum</abbr>',
            ],
            [
                '<a href="https://trusted.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a href="https://trusted.com" title="Link title">Lorem ipsum</a>',
            ],
            [
                '<a href="https://untrusted.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a title="Link title">Lorem ipsum</a>',
            ],
            [
                '<a href="https://external.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a href="https://external.com" title="Link title">Lorem ipsum</a>',
            ],
            [
                '<a href="mailto:test&#64;gmail.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a href="mailto:test&#64;gmail.com" title="Link title">Lorem ipsum</a>',
            ],
            [
                '<blockquote class="foo">Lorem ipsum</blockquote>',
                '<blockquote>Lorem ipsum</blockquote>',
            ],
            [
                'Lorem ipsum <br class="foo">dolor sit amet <br class="foo" />consectetur adipisicing.',
                'Lorem ipsum <br />dolor sit amet <br />consectetur adipisicing.',
            ],
            [
                '<caption class="foo">Lorem ipsum</caption>',
                '<caption>Lorem ipsum</caption>',
            ],
            [
                '<code class="foo">Lorem ipsum</code>',
                '<code>Lorem ipsum</code>',
            ],
            [
                '<dd class="foo">Lorem ipsum</dd>',
                '<dd>Lorem ipsum</dd>',
            ],
            [
                '<del class="foo">Lorem ipsum</del>',
                '<del>Lorem ipsum</del>',
            ],
            [
                '<div class="foo">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>',
                '<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>',
            ],
            [
                '<dl class="foo">Lorem ipsum</dl>',
                '<dl>Lorem ipsum</dl>',
            ],
            [
                '<dt class="foo">Lorem ipsum</dt>',
                '<dt>Lorem ipsum</dt>',
            ],
            [
                '<em class="foo">Lorem ipsum</em>',
                '<em>Lorem ipsum</em>',
            ],
            [
                '<figcaption class="foo">Lorem ipsum</figcaption>',
                '<figcaption>Lorem ipsum</figcaption>',
            ],
            [
                '<figure class="foo">Lorem ipsum</figure>',
                '<figure>Lorem ipsum</figure>',
            ],
            [
                '<h1 class="foo">Lorem ipsum</h1>',
                '<h1>Lorem ipsum</h1>',
            ],
            [
                '<h2 class="foo">Lorem ipsum</h2>',
                '<h2>Lorem ipsum</h2>',
            ],
            [
                '<h3 class="foo">Lorem ipsum</h3>',
                '<h3>Lorem ipsum</h3>',
            ],
            [
                '<h4 class="foo">Lorem ipsum</h4>',
                '<h4>Lorem ipsum</h4>',
            ],
            [
                '<h5 class="foo">Lorem ipsum</h5>',
                '<h5>Lorem ipsum</h5>',
            ],
            [
                '<h6 class="foo">Lorem ipsum</h6>',
                '<h6>Lorem ipsum</h6>',
            ],
            [
                '<hr class="foo" />',
                '<hr />',
            ],
            [
                '<iframe src="/frame/example" width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
                '<iframe width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
            ],
            [
                '<iframe src="http://trusted.com/frame/example" width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
                '<iframe src="https://trusted.com/frame/example" width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
            ],
            [
                '<iframe src="http://untrusted.com/frame/example" width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
                '<iframe width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
            ],
            [
                '<iframe>Lorem ipsum</iframe>',
                '<iframe>Lorem ipsum</iframe>',
            ],
            [
                '<img src="/img/example.jpg" alt="Image alternative text" title="Image title" class="foo">',
                '<img alt="Image alternative text" title="Image title" />',
            ],
            [
                '<img src="http://trusted.com/img/example.jpg" alt="Image alternative text" title="Image title" class="foo" />',
                '<img src="https://trusted.com/img/example.jpg" alt="Image alternative text" title="Image title" />',
            ],
            [
                '<img src="http://untrusted.com/img/example.jpg" alt="Image alternative text" title="Image title" class="foo" />',
                '<img alt="Image alternative text" title="Image title" />',
            ],
            [
                '<img />',
                '<img />',
            ],
            [
                '<img title="" />',
                '<img title />',
            ],
            [
                '<i class="foo">Lorem ipsum</i>',
                '<i>Lorem ipsum</i>',
            ],
            [
                '<li class="foo">Lorem ipsum</li>',
                '<li>Lorem ipsum</li>',
            ],
            [
                '<ol class="foo">Lorem ipsum</ol>',
                '<ol>Lorem ipsum</ol>',
            ],
            [
                '<p class="foo">Lorem ipsum</p>',
                '<p>Lorem ipsum</p>',
            ],
            [
                '<pre class="foo">Lorem ipsum</pre>',
                '<pre>Lorem ipsum</pre>',
            ],
            [
                '<q class="foo">Lorem ipsum</q>',
                '<q>Lorem ipsum</q>',
            ],
            [
                '<rp class="foo">Lorem ipsum</rp>',
                '<rp>Lorem ipsum</rp>',
            ],
            [
                '<rt class="foo">Lorem ipsum</rt>',
                '<rt>Lorem ipsum</rt>',
            ],
            [
                '<ruby class="foo">Lorem ipsum</ruby>',
                '<ruby>Lorem ipsum</ruby>',
            ],
            [
                '<small class="foo">Lorem ipsum</small>',
                '<small>Lorem ipsum</small>',
            ],
            [
                '<span class="foo">Lorem ipsum</span>',
                '<span>Lorem ipsum</span>',
            ],
            [
                '<strong class="foo">Lorem ipsum</strong>',
                '<strong>Lorem ipsum</strong>',
            ],
            [
                '<b class="foo">Lorem ipsum</b>',
                '<strong>Lorem ipsum</strong>',
            ],
            [
                '<sub class="foo">Lorem ipsum</sub>',
                '<sub>Lorem ipsum</sub>',
            ],
            [
                '<sup class="foo">Lorem ipsum</sup>',
                '<sup>Lorem ipsum</sup>',
            ],
            [
                '<table class="foo">Lorem ipsum</table>',
                '<table>Lorem ipsum</table>',
            ],
            [
                '<tbody class="foo">Lorem ipsum</tbody>',
                '<tbody>Lorem ipsum</tbody>',
            ],
            [
                '<td class="foo">Lorem ipsum</td>',
                '<td>Lorem ipsum</td>',
            ],
            [
                '<tfoot class="foo">Lorem ipsum</tfoot>',
                '<tfoot>Lorem ipsum</tfoot>',
            ],
            [
                '<thead class="foo">Lorem ipsum</thead>',
                '<thead>Lorem ipsum</thead>',
            ],
            [
                '<th class="foo">Lorem ipsum</th>',
                '<th>Lorem ipsum</th>',
            ],
            [
                '<tr class="foo">Lorem ipsum</tr>',
                '<tr>Lorem ipsum</tr>',
            ],
            [
                '<ul class="foo">Lorem ipsum</ul>',
                '<ul>Lorem ipsum</ul>',
            ],

            /*
             * Links
             */

            [
                '<a href="mailto:test&#64;gmail.com">Test</a>',
                '<a href="mailto:test&#64;gmail.com">Test</a>',
            ],
            [
                '<a href="mailto:alert(\'ok\')">Test</a>',
                '<a>Test</a>',
            ],
            [
                '<a href="javascript:alert(\'ok\')">Test</a>',
                '<a>Test</a>',
            ],
            [
                '<a href="javascript://%0Aalert(document.cookie)">Test</a>',
                '<a>Test</a>',
            ],
            [
                '<a href="http://untrusted.com" onclick="alert(\'ok\')">Test</a>',
                '<a>Test</a>',
            ],
            [
                '<a href="https://trusted.com">Test</a>',
                '<a href="https://trusted.com">Test</a>',
            ],
            [
                '<a>Lorem ipsum</a>',
                '<a>Lorem ipsum</a>',
            ],
            [
                '<a href="&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;&#39;&#88;&#83;&#83;&#39;&#41;">Lorem ipsum</a>',
                '<a>Lorem ipsum</a>',
            ],
            [
                '<a href="http://trusted.com/index.html#this:stuff">Lorem ipsum</a>',
                '<a href="http://trusted.com/index.html#this:stuff">Lorem ipsum</a>',
            ],
            [
                '<a href="java\0&#14;\t\r\n script:alert(\\\'foo\\\')">Lorem ipsum</a>',
                '<a>Lorem ipsum</a>',
            ],
            [
                '<a href= onmouseover="alert(\\\'XSS\\\');">Lorem ipsum</a>',
                '<a>Lorem ipsum</a>',
            ],

            /*
             * Scripts
             */

            [
                '<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit.<script>alert(\'ok\');</script></div>',
                '<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>',
            ],
            [
                '<figure><img src="https://trusted.com/img/example.jpg" onclick="alert(\'ok\')" /></figure>',
                '<figure><img src="https://trusted.com/img/example.jpg" /></figure>',
            ],
            [
                '<a href="javascript:alert(\'ok\')">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>',
                '<a>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>',
            ],
            [
                '<img src= onmouseover="alert(\'XSS\');" />',
                '<img />',
            ],
            [
                '<<img src="javascript:evil"/>img src="javascript:evil"/>',
                '<img />img src&#61;&#34;javascript:evil&#34;/&gt;',
            ],
            [
                '<<a href="javascript:evil"/>a href="javascript:evil"/>',
                '<a>a href&#61;&#34;javascript:evil&#34;/&gt;</a>',
            ],
            [
                '!<textarea>&lt;/textarea&gt;&lt;svg/onload=prompt`xs`&gt;</textarea>!',
                '!&lt;/textarea&gt;&lt;svg/onload&#61;prompt&#96;xs&#96;&gt;!',
            ],
            [
                '<iframe src= onmouseover="alert(\'XSS\');" />',
                '<iframe></iframe>',
            ],
            [
                '<<iframe src="javascript:evil"/>iframe src="javascript:evil"/>',
                '<iframe>iframe src&#61;&#34;javascript:evil&#34;/&gt;</iframe>',
            ],

            /*
             * Styles
             */

            [
                '<div>Lorem ipsum dolor sit amet, consectetur.<style>body { background: red; }</style></div>',
                '<div>Lorem ipsum dolor sit amet, consectetur.</div>',
            ],
            [
                '<img src="https://trusted.com/img/example.jpg" style="position:absolute;top:0;left:0;width:9000px;height:9000px;" />',
                '<img src="https://trusted.com/img/example.jpg" />',
            ],
            [
                '<a style="font-size: 40px; color: red;">Lorem ipsum dolor sit amet, consectetur.</a>',
                '<a>Lorem ipsum dolor sit amet, consectetur.</a>',
            ],

        ]);
    }
}
