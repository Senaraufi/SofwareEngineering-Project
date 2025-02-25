<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* partials/footer.html.twig */
class __TwigTemplate_ce7a444055d45583edcc49d3149dc28f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!-- Music Player -->
<!-- References:
- Player controls layout adapted from Tailwind UI Music Player Component: https://tailwindui.com/components/application-ui/media/players
- SVG icons from Heroicons (by Tailwind CSS): https://heroicons.com/
-->
<div class=\"fixed bottom-0 left-0 right-0 bg-gray-900 text-white\">
    <div class=\"max-w-7xl mx-auto\">
        <div class=\"player-controls\">
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 19l-7-7 7-7\"></path>
                </svg>
            </button>
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-12 h-12\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z\"></path>
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path>
                </svg>
            </button>
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                </svg>
            </button>
            <div class=\"flex-1 mx-4\">
                <div class=\"track-slider\"></div>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "partials/footer.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Music Player -->
<!-- References:
- Player controls layout adapted from Tailwind UI Music Player Component: https://tailwindui.com/components/application-ui/media/players
- SVG icons from Heroicons (by Tailwind CSS): https://heroicons.com/
-->
<div class=\"fixed bottom-0 left-0 right-0 bg-gray-900 text-white\">
    <div class=\"max-w-7xl mx-auto\">
        <div class=\"player-controls\">
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 19l-7-7 7-7\"></path>
                </svg>
            </button>
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-12 h-12\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z\"></path>
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path>
                </svg>
            </button>
            <button class=\"hover:text-indigo-400\">
                <svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5l7 7-7 7\"></path>
                </svg>
            </button>
            <div class=\"flex-1 mx-4\">
                <div class=\"track-slider\"></div>
            </div>
        </div>
    </div>
</div>
", "partials/footer.html.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/templates/partials/footer.html.twig");
    }
}
