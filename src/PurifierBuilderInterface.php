<?php

namespace HtmlPurifier;

use HtmlPurifier\Extension\ExtensionInterface;

/**
 * Create a purifier using purifier extensions and configuration.
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
