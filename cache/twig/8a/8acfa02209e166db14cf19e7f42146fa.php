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

/* about.html.twig */
class __TwigTemplate_aa6ad7cebe7ad22f498c08217bc231a0 extends Template
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
        $this->parent = $this->loadTemplate("base.html.twig", "about.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "About - TalkTempo";
    }

    // line 5
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <div class=\"max-w-4xl mx-auto\">
        <h2 class=\"text-3xl font-bold mb-6\">About TalkTempo</h2>
        
        <div class=\"prose lg:prose-xl\">
            <p class=\"mb-4\">
                Welcome to TalkTempo, your premier destination for discovering and enjoying music.
                We're passionate about bringing the best musical experience to our users through
                our carefully curated collection and innovative features.
            </p>
            
            <h3 class=\"text-2xl font-semibold mt-8 mb-4\">Our Mission</h3>
            <p class=\"mb-4\">
                At TalkTempo, we believe that music has the power to connect, inspire, and transform.
                Our mission is to make quality music accessible to everyone while supporting artists
                and creating a vibrant musical community.
            </p>
            
            <h3 class=\"text-2xl font-semibold mt-8 mb-4\">Contact Us</h3>
            <p class=\"mb-4\">
                Have questions or suggestions? We'd love to hear from you!
                Reach out to us at <a href=\"mailto:contact@talktempo.com\" class=\"text-indigo-600 hover:text-indigo-800\">contact@talktempo.com</a>
            </p>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "about.html.twig";
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

{% block title %}About - TalkTempo{% endblock %}

{% block content %}
    <div class=\"max-w-4xl mx-auto\">
        <h2 class=\"text-3xl font-bold mb-6\">About TalkTempo</h2>
        
        <div class=\"prose lg:prose-xl\">
            <p class=\"mb-4\">
                Welcome to TalkTempo, your premier destination for discovering and enjoying music.
                We're passionate about bringing the best musical experience to our users through
                our carefully curated collection and innovative features.
            </p>
            
            <h3 class=\"text-2xl font-semibold mt-8 mb-4\">Our Mission</h3>
            <p class=\"mb-4\">
                At TalkTempo, we believe that music has the power to connect, inspire, and transform.
                Our mission is to make quality music accessible to everyone while supporting artists
                and creating a vibrant musical community.
            </p>
            
            <h3 class=\"text-2xl font-semibold mt-8 mb-4\">Contact Us</h3>
            <p class=\"mb-4\">
                Have questions or suggestions? We'd love to hear from you!
                Reach out to us at <a href=\"mailto:contact@talktempo.com\" class=\"text-indigo-600 hover:text-indigo-800\">contact@talktempo.com</a>
            </p>
        </div>
    </div>
{% endblock %}
", "about.html.twig", "/Users/senaraufi/Desktop/SoftwareEngineering-project/SofwareEngineering-Project/templates/about.html.twig");
    }
}
