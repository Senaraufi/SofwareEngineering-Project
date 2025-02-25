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

/* base.html.twig */
class __TwigTemplate_c61259cd24f98edc99a77f82d389280c extends Template
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
            'stylesheets' => [$this, 'block_stylesheets'],
            'content' => [$this, 'block_content'],
            'javascripts' => [$this, 'block_javascripts'],
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
    ";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 9
        echo "</head>
<body class=\"bg-gray-50\">
    ";
        // line 11
        $this->loadTemplate("partials/header.html.twig", "base.html.twig", 11)->display($context);
        // line 12
        echo "
    <main class=\"max-w-7xl mx-auto pt-24 px-6\">
        ";
        // line 14
        $this->displayBlock('content', $context, $blocks);
        // line 15
        echo "    </main>

    ";
        // line 17
        $this->loadTemplate("partials/footer.html.twig", "base.html.twig", 17)->display($context);
        // line 18
        echo "
    ";
        // line 19
        $this->displayBlock('javascripts', $context, $blocks);
        // line 20
        echo "</body>
</html>
";
    }

    // line 6
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "TalkTempo - Music Store";
    }

    // line 8
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 14
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 19
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  103 => 19,  97 => 14,  91 => 8,  84 => 6,  78 => 20,  76 => 19,  73 => 18,  71 => 17,  67 => 15,  65 => 14,  61 => 12,  59 => 11,  55 => 9,  53 => 8,  48 => 6,  41 => 1,);
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
    {% block stylesheets %}{% endblock %}
</head>
<body class=\"bg-gray-50\">
    {% include 'partials/header.html.twig' %}

    <main class=\"max-w-7xl mx-auto pt-24 px-6\">
        {% block content %}{% endblock %}
    </main>

    {% include 'partials/footer.html.twig' %}

    {% block javascripts %}{% endblock %}
</body>
</html>
", "base.html.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/templates/base.html.twig");
    }
}
