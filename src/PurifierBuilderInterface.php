<?php

/*
 * This file is part of the HTML sanitizer project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlPurifier;

use HtmlPurifier\Extension\ExtensionInterface;

/**
 * Create a purifier using purifier extensions and configuration.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface PurifierBuilderInterface
{
    /**
     * Register an extension to use in the purifier being built.
     *
     * @param ExtensionInterface $extension
     *
     * @return void
     */
    public function registerExtension(ExtensionInterface $extension);

    /**
     * Build the purifier using the given configuration.
     *
     * @param array $config
     *
     * @return PurifierInterface
     */
    public function build(array $config): PurifierInterface;
}
