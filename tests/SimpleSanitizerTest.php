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

class SimpleSanitizerTest extends AbstractSanitizerTest
{
    public function createSanitizer(): SanitizerInterface
    {
        return Sanitizer::create(['extensions' => ['basic']]);
    }

    public function provideFixtures(): array
    {
        return array_merge(parent::provideFixtures(), [

            /*
             * Normal tags
             */

            [
                '<abbr class="foo">Lorem ipsum</abbr>',
                'Lorem ipsum',
            ],
            [
                '<a href="https://trusted.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a href="https://trusted.com" title="Link title">Lorem ipsum</a>',
            ],
            [
                '<a href="https://untrusted.com" title="Link title" class="foo">Lorem ipsum</a>',
                '<a href="https://untrusted.com" title="Link title">Lorem ipsum</a>',
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
                'Lorem ipsum',
            ],
            [
                '<code class="foo">Lorem ipsum</code>',
                'Lorem ipsum',
            ],
            [
                '<dd class="foo">Lorem ipsum</dd>',
                'Lorem ipsum',
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
                'Lorem ipsum',
            ],
            [
                '<dt class="foo">Lorem ipsum</dt>',
                'Lorem ipsum',
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
                '',
            ],
            [
                '<iframe src="/frame/example" width="300" height="300" frameborder="0">Lorem ipsum</iframe>',
                'Lorem ipsum',
            ],
            [
                '<iframe>Lorem ipsum</iframe>',
                'Lorem ipsum',
            ],
            [
                '<img src="/img/example.jpg" alt="Image alternative text" title="Image title" class="foo" />',
                '',
            ],
            [
                '<img src="http://trusted.com/img/example.jpg" alt="Image alternative text" title="Image title" class="foo" />',
                '',
            ],
            [
                '<img />',
                '',
            ],
            [
                '<i class="foo">Lorem ipsum</i>',
                '<i>Lorem ipsum</i>',
            ],
            [
                '<li class="foo">Lorem ipsum</li>',
                'Lorem ipsum',
            ],
            [
                '<ol class="foo">Lorem ipsum</ol>',
                'Lorem ipsum',
            ],
            [
                '<p class="foo">Lorem ipsum</p>',
                '<p>Lorem ipsum</p>',
            ],
            [
                '<pre class="foo">Lorem ipsum</pre>',
                'Lorem ipsum',
            ],
            [
                '<q class="foo">Lorem ipsum</q>',
                '<q>Lorem ipsum</q>',
            ],
            [
                '<rp class="foo">Lorem ipsum</rp>',
                'Lorem ipsum',
            ],
            [
                '<rt class="foo">Lorem ipsum</rt>',
                'Lorem ipsum',
            ],
            [
                '<ruby class="foo">Lorem ipsum</ruby>',
                'Lorem ipsum',
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
                'Lorem ipsum',
            ],
            [
                '<tbody class="foo">Lorem ipsum</tbody>',
                'Lorem ipsum',
            ],
            [
                '<td class="foo">Lorem ipsum</td>',
                'Lorem ipsum',
            ],
            [
                '<tfoot class="foo">Lorem ipsum</tfoot>',
                'Lorem ipsum',
            ],
            [
                '<thead class="foo">Lorem ipsum</thead>',
                'Lorem ipsum',
            ],
            [
                '<th class="foo">Lorem ipsum</th>',
                'Lorem ipsum',
            ],
            [
                '<tr class="foo">Lorem ipsum</tr>',
                'Lorem ipsum',
            ],
            [
                '<ul class="foo">Lorem ipsum</ul>',
                'Lorem ipsum',
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
                '<a href="http://untrusted.com">Test</a>',
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
                '<figure><img src="/img/example.jpg" onclick="alert(\'ok\')" /></figure>',
                '<figure></figure>',
            ],
            [
                '<a href="javascript:alert(\'ok\')">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>',
                '<a>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>',
            ],
            [
                '"><script>...</script><input value="',
                '&#34;&gt;',
            ],
            [
                '<scr<script>ipt>alert(1)</script>',
                '',
            ],
            [
                '<scr<a>ipt>alert(1)</script>',
                '<a>ipt&gt;alert(1)</a>',
            ],

            /*
             * Styles
             */

            [
                '<div>Lorem ipsum dolor sit amet, consectetur.<style>body { background: red; }</style></div>',
                '<div>Lorem ipsum dolor sit amet, consectetur.</div>',
            ],
            [
                '<img src="/img/example.jpg" style="position:absolute;top:0;left:0;width:9000px;height:9000px;" />',
                '',
            ],
            [
                '<a style="font-size: 40px; color: red;">Lorem ipsum dolor sit amet, consectetur.</a>',
                '<a>Lorem ipsum dolor sit amet, consectetur.</a>',
            ],

            /*
             * Ideas extracted from https://github.com/OWASP/java-html-sanitizer
             */

            [
                '<p/b onload=""/',
                '<p></p>',
            ],
            [
                '<p onload=""/b/',
                '<p></p>',
            ],
            [
                '<p onload=""<a href="https://trusted.com/" onload="">first part of the text</> second part',
                '<p><a href="https://trusted.com/">first part of the text second part</a></p>',
            ],
            [
                '<p onload=""<b onload="">Hello',
                '<p><strong>Hello</strong></p>',
            ],
            [
                '<p>Hello world</b style="width:expression(alert(1))">',
                '<p>Hello world</p>',
            ],
            [
                "<A TITLE=\"harmless\0  SCRIPT = javascript:alert(1) ignored = ignored\">",
                '<a title="harmless  SCRIPT &#61; javascript:alert(1) ignored &#61; ignored"></a>',
            ],
            [
                '<div style1="expression(\'alert(1)">Hello</div>',
                '<div>Hello</div>',
            ],
            [
                '<a title="``onmouseover=alert(1337)">Hello</a>',
                '<a title="&#96;&#96;onmouseover&#61;alert(1337) ">Hello</a>',
            ],

        ]);
    }
}
