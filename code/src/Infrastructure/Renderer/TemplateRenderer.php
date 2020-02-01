<?php

namespace BestThor\ScrappingMaster\Infrastructure\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class TemplateRenderer
 *
 * @package BestThor\ScrappingMaster\Infrastructure\Renderer
 * @author  Ismael Moral <jastertdc@gmail.com>
 */
final class TemplateRenderer
{
    /**
     * @var string
     */
    protected $templateDir;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Environment
     */
    protected $templateRenderer;

    /**
     * TemplateRenderer constructor.
     *
     * @param string $templateDir
     * @param array $options
     */
    public function __construct(
        string $templateDir,
        array $options
    ) {
        $this->templateDir = $templateDir;
        $this->options = $options;

        $loader = new FilesystemLoader($this->templateDir);

        $this->templateRenderer = new Environment(
            $loader,
            $this->options
        );
    }

    /**
     * @return Environment
     */
    public function getTemplateRenderer(): Environment
    {
        return $this->templateRenderer;
    }
}
