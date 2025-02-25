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

/* partials/header.html.twig */
class __TwigTemplate_fc266e094c906e4317141559108f8386 extends Template
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
        echo "<!-- Header -->
<!-- References:
- Navigation layout adapted from Tailwind UI Navigation Component: https://tailwindui.com/components/application-ui/navigation/navbars
- Search bar design inspired by Tailwind UI Search Component: https://tailwindui.com/components/application-ui/forms/input-groups
- Shopping cart icon from Heroicons: https://heroicons.com/
-->
<header class=\"header\">
    <nav class=\"main-nav\">
        <div class=\"flex items-center space-x-8\">
            <h1 class=\"text-2xl font-bold\">";
        // line 10
        echo twig_escape_filter($this->env, ((array_key_exists("site_name", $context)) ? (_twig_default_filter(($context["site_name"] ?? null), "TalkTempo")) : ("TalkTempo")), "html", null, true);
        echo "</h1>
            <div class=\"space-x-6\">
                <a href=\"/\" class=\"nav-link";
        // line 12
        if ((($context["active_page"] ?? null) == "home")) {
            echo " active";
        }
        echo "\">Home</a>
                <a href=\"/browse\" class=\"nav-link";
        // line 13
        if ((($context["active_page"] ?? null) == "browse")) {
            echo " active";
        }
        echo "\">Browse</a>
                <a href=\"/albums\" class=\"nav-link";
        // line 14
        if ((($context["active_page"] ?? null) == "albums")) {
            echo " active";
        }
        echo "\">Albums</a>
                <a href=\"/artists\" class=\"nav-link";
        // line 15
        if ((($context["active_page"] ?? null) == "artists")) {
            echo " active";
        }
        echo "\">Artists</a>
                <a href=\"/about\" class=\"nav-link";
        // line 16
        if ((($context["active_page"] ?? null) == "about")) {
            echo " active";
        }
        echo "\">About</a>
            </div>
        </div>
        <div class=\"flex items-center space-x-6\">
            <input type=\"search\" placeholder=\"Search music...\" class=\"search-bar\">
            <button class=\"relative\">
                <svg class=\"w-6 h-6 text-gray-300\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
                </svg>
                <span class=\"cart-badge\">";
        // line 25
        echo twig_escape_filter($this->env, ((array_key_exists("cart_count", $context)) ? (_twig_default_filter(($context["cart_count"] ?? null), 0)) : (0)), "html", null, true);
        echo "</span>
            </button>
        </div>
    </nav>
</header>
";
    }

    public function getTemplateName()
    {
        return "partials/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 25,  77 => 16,  71 => 15,  65 => 14,  59 => 13,  53 => 12,  48 => 10,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Header -->
<!-- References:
- Navigation layout adapted from Tailwind UI Navigation Component: https://tailwindui.com/components/application-ui/navigation/navbars
- Search bar design inspired by Tailwind UI Search Component: https://tailwindui.com/components/application-ui/forms/input-groups
- Shopping cart icon from Heroicons: https://heroicons.com/
-->
<header class=\"header\">
    <nav class=\"main-nav\">
        <div class=\"flex items-center space-x-8\">
            <h1 class=\"text-2xl font-bold\">{{ site_name|default('TalkTempo') }}</h1>
            <div class=\"space-x-6\">
                <a href=\"/\" class=\"nav-link{% if active_page == 'home' %} active{% endif %}\">Home</a>
                <a href=\"/browse\" class=\"nav-link{% if active_page == 'browse' %} active{% endif %}\">Browse</a>
                <a href=\"/albums\" class=\"nav-link{% if active_page == 'albums' %} active{% endif %}\">Albums</a>
                <a href=\"/artists\" class=\"nav-link{% if active_page == 'artists' %} active{% endif %}\">Artists</a>
                <a href=\"/about\" class=\"nav-link{% if active_page == 'about' %} active{% endif %}\">About</a>
            </div>
        </div>
        <div class=\"flex items-center space-x-6\">
            <input type=\"search\" placeholder=\"Search music...\" class=\"search-bar\">
            <button class=\"relative\">
                <svg class=\"w-6 h-6 text-gray-300\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
                </svg>
                <span class=\"cart-badge\">{{ cart_count|default(0) }}</span>
            </button>
        </div>
    </nav>
</header>
", "partials/header.html.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/templates/partials/header.html.twig");
    }
}
