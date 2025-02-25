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

/* index.html.twig */
class __TwigTemplate_7d79d5d5cd9ef0e3279ee4e26a29ba0d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "TalkTempo - Music Store";
    }

    // line 5
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <!-- Genre Tags -->
    <div class=\"flex space-x-4 mb-8\">
        <span class=\"genre-tag\">Rock</span>
        <span class=\"genre-tag\">Jazz</span>
        <span class=\"genre-tag\">Classical</span>
        <span class=\"genre-tag\">Pop</span>
        <span class=\"genre-tag\">Electronic</span>
    </div>
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 6,  54 => 5,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}TalkTempo - Music Store{% endblock %}

{% block content %}
    <!-- Genre Tags -->
    <div class=\"flex space-x-4 mb-8\">
        <span class=\"genre-tag\">Rock</span>
        <span class=\"genre-tag\">Jazz</span>
        <span class=\"genre-tag\">Classical</span>
        <span class=\"genre-tag\">Pop</span>
        <span class=\"genre-tag\">Electronic</span>
    </div>
{% endblock %}
", "index.html.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/templates/index.html.twig");
    }
}
