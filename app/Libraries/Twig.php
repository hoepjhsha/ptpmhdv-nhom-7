<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 13/11/2024
 * @time 18:49
 */

namespace App\Libraries;

use Config\Services;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class Twig.
 *
 * This lib implements the Twig template engine.
 */
class Twig
{
    /**
     * @var array Paths to Twig templates
     */
    private array $paths;

    /**
     * @var array Twig Environment Options
     */
    private array $config;

    /**
     * @var array Functions to add to Twig
     */
    private array $asisFunctions = [
        'base_url',
        'site_url',
    ];

    /**
     * @var array Filters to add to Twig
     */
    private array $filters = [];

    /**
     * @var array Functions with `is_safe` option
     */
    private array $safeFunctions = [
        'form_open',
        'form_close',
        'form_error',
        'form_hidden',
        'set_value',
        'csrf_field',
        'form_open_multipart',
        'form_upload',
        'form_submit',
        'form_dropdown',
        'set_radio',
        'set_select',
        'set_checkbox',
    ];

    /**
     * @var bool Whether functions are added or not
     */
    private bool $addedFunctions = false;

    /**
     * @var bool Whether filters are added or not
     */
    private bool $addedFilters = false;

    /**
     * @var Environment|null Stores the Twig configuration and renders
     *                       templates
     */
    private ?Environment $twig = null;

    /**
     * @var FilesystemLoader|null Loads template from the filesystem
     */
    private ?FilesystemLoader $loader = null;

    /**
     * Constructor.
     */
    public function __construct(array $params = [])
    {
        if (! empty($params['functions'])) {
            $this->asisFunctions = array_unique(
                array_merge($this->asisFunctions, $params['functions'])
            );

            unset($params['functions']);
        }

        if (! empty($params['safeFunctions'])) {
            $this->safeFunctions = array_unique(
                array_merge(
                    $this->safeFunctions,
                    $params['safeFunctions']
                )
            );

            unset($params['safeFunctions']);
        }

        if (! empty($params['filters'])) {
            $this->filters = array_unique(
                array_merge($this->filters, $params['filters'])
            );

            unset($params['filters']);
        }

        if (! empty($params['paths'])) {
            $this->paths = $params['paths'];

            unset($params['paths']);
        } else {
            $this->paths = [APPPATH . 'Views/'];
        }

        $this->config = [
            'cache'      => ! empty($params['cache']) ? $params['cache'] : WRITEPATH . 'cache/twig',
            'debug'      => ENVIRONMENT !== 'production',
            'autoescape' => 'html',
        ];

        $this->config = array_merge($this->config, $params);
    }

    /**
     * Reset twig.
     */
    protected function resetTwig(): void
    {
        $this->twig = null;
        $this->createTwig();
    }

    /**
     * Create twig instance.
     */
    protected function createTwig(): void
    {
        if ($this->twig !== null) {
            return;
        }

        if ($this->loader === null) {
            $this->loader = new FilesystemLoader($this->paths);
        }

        $twig = new Environment($this->loader, $this->config);

        if ($this->config['debug']) {
            $twig->addExtension(new DebugExtension());
        }

        $this->twig = $twig;
    }

    /**
     * Set loader.
     */
    protected function setLoader(FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * Registers a Global
     *
     * @param string $name  The global name
     * @param mixed  $value The global value
     */
    public function addGlobal(string $name, mixed $value): void
    {
        $this->createTwig();
        $this->twig->addGlobal($name, $value);
    }

    /**
     * Renders Twig Template and Outputs
     *
     * @param string $view   Template filename without `.twig`
     * @param array  $params Array of parameters to pass to the template
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function display(string $view, array $params = []): void
    {
        echo $this->render($view, $params);
    }

    /**
     * Renders Twig Template and Returns as String
     *
     * @param string $view   Template filename without `.twig`
     * @param array  $params Array of parameters to pass to the template
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = []): string
    {
        $this->createTwig();
        $this->addFunctions();
        $this->addFilters();

        $view .= '.twig';

        return $this->twig->render($view, $params);
    }

    /**
     * Add filters.
     */
    protected function addFilters(): void
    {
        if ($this->addedFilters) {
            return;
        }

        foreach ($this->filters as $filter) {
            if (function_exists($filter)) {
                $this->twig->addFilter(
                    new TwigFilter($filter, $filter)
                );
            }
        }

        $this->addedFilters = true;
    }

    /**
     * Add functions.
     */
    protected function addFunctions(): void
    {
        if ($this->addedFunctions) {
            return;
        }

        foreach ($this->asisFunctions as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new TwigFunction($function, $function)
                );
            }
        }

        foreach ($this->safeFunctions as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new TwigFunction(
                        $function,
                        $function,
                        ['is_safe' => ['html']]
                    )
                );
            }
        }

        $this->addCustomizedFunctions();

        $this->addedFunctions = true;
    }

    /**
     * Add customized functions.
     */
    protected function addCustomizedFunctions(): void
    {
        $functions = array_merge(
            $this->asisFunctions,
            $this->safeFunctions
        );

        if (! in_array(
            'anchor',
            $functions,
            true
        ) && function_exists('anchor')) {
            $this->twig->addFunction(
                new TwigFunction(
                    'anchor',
                    [$this, 'safeAnchor'],
                    ['is_safe' => ['html']]
                )
            );
        }

        if (! in_array('validateListErrors', $functions, true)) {
            $this->twig->addFunction(
                new TwigFunction(
                    'validateListErrors',
                    [$this, 'validateListErrors'],
                    ['is_safe' => ['html']]
                )
            );
        }
    }

    /**
     * Safe anchor.
     *
     * @param array $attributes only array is acceptable
     */
    public function safeAnchor(
        string $uri = '',
        string $title = '',
        array $attributes = []
    ): string {
        $uri   = esc($uri, 'url');
        $title = esc($title);

        $new_attr = [];

        foreach ($attributes as $key => $val) {
            $new_attr[esc($key)] = $val;
        }

        return anchor($uri, $title, $new_attr);
    }

    /**
     * Validate the list errors.
     */
    public function validateListErrors(): string
    {
        return Services::validation()->listErrors();
    }

    /**
     * Get Twig instance.
     */
    public function getTwig(): Environment
    {
        $this->createTwig();

        return $this->twig;
    }
}
