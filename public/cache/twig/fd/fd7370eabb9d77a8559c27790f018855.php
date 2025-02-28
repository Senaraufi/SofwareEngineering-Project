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

/* header.twig */
class __TwigTemplate_43131e49ac86c769a0c662a5d9393637 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link rel=\"stylesheet\" href=\"/css/style.css\">
</head>
<body class=\"bg-gray-50\">
    <!-- Header -->
    <header class=\"header\">
        <nav class=\"main-nav\">
            <div class=\"flex items-center space-x-8\">
                <h1 class=\"text-2xl font-bold\">TalkTempo</h1>
                <div class=\"space-x-6\">
                    <a href=\"index.html\" class=\"nav-link ";
        // line 16
        echo (((($context["current_page"] ?? null) == "home")) ? ("text-white") : (""));
        echo "\">Home</a>
                    <a href=\"browse.html\" class=\"nav-link ";
        // line 17
        echo (((($context["current_page"] ?? null) == "browse")) ? ("text-white") : (""));
        echo "\">Browse</a>
                    <a href=\"albums.html\" class=\"nav-link ";
        // line 18
        echo (((($context["current_page"] ?? null) == "albums")) ? ("text-white") : (""));
        echo "\">Albums</a>
                    <a href=\"artists.html\" class=\"nav-link ";
        // line 19
        echo (((($context["current_page"] ?? null) == "artists")) ? ("text-white") : (""));
        echo "\">Artists</a>
                    <a href=\"about.html\" class=\"nav-link ";
        // line 20
        echo (((($context["current_page"] ?? null) == "about")) ? ("text-white") : (""));
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
        // line 29
        echo twig_escape_filter($this->env, ((array_key_exists("cart_count", $context)) ? (_twig_default_filter(($context["cart_count"] ?? null), 0)) : (0)), "html", null, true);
        echo "</span>
                </button>
            </div>
        </nav>
    </header>
    <!-- Main Content Container -->
    <main class=\"max-w-7xl mx-auto pt-24 px-6\">
";
    }

    // line 6
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "TalkTempo - Music Store";
    }

    public function getTemplateName()
    {
        return "header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 6,  86 => 29,  74 => 20,  70 => 19,  66 => 18,  62 => 17,  58 => 16,  45 => 6,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{% block title %}TalkTempo - Music Store{% endblock %}</title>
    <link rel=\"stylesheet\" href=\"/css/style.css\">
</head>
<body class=\"bg-gray-50\">
    <!-- Header -->
    <header class=\"header\">
        <nav class=\"main-nav\">
            <div class=\"flex items-center space-x-8\">
                <h1 class=\"text-2xl font-bold\">TalkTempo</h1>
                <div class=\"space-x-6\">
                    <a href=\"index.html\" class=\"nav-link {{ current_page == 'home' ? 'text-white' : '' }}\">Home</a>
                    <a href=\"browse.html\" class=\"nav-link {{ current_page == 'browse' ? 'text-white' : '' }}\">Browse</a>
                    <a href=\"albums.html\" class=\"nav-link {{ current_page == 'albums' ? 'text-white' : '' }}\">Albums</a>
                    <a href=\"artists.html\" class=\"nav-link {{ current_page == 'artists' ? 'text-white' : '' }}\">Artists</a>
                    <a href=\"about.html\" class=\"nav-link {{ current_page == 'about' ? 'text-white' : '' }}\">About</a>
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
    <!-- Main Content Container -->
    <main class=\"max-w-7xl mx-auto pt-24 px-6\">
", "header.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/public/includes/templates/header.twig");
    }
}
