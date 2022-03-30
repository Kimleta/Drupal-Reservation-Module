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

/* modules/custom/reservation/templates/reservation.html.twig */
class __TwigTemplate_efee683ae57111bdeb9d25cdd183eaa9 extends \Twig\Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<h1> List of movies </h1>

  <ol>
    ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["movies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["movie"]) {
            // line 5
            echo "        <li>
            <div>
               <h5 style = \"text-weight:bold\"> ";
            // line 7
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["movie"], "title", [], "any", false, false, true, 7), "value", [], "any", false, false, true, 7), 7, $this->source));
            echo "  </h5>
                <img src=\"";
            // line 8
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getFileUrl($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["movie"], "field_movie_image", [], "any", false, false, true, 8), "entity", [], "any", false, false, true, 8), "fileuri", [], "any", false, false, true, 8), 8, $this->source)), "html", null, true);
            echo "\" width=\"300\" height=\"300\" />
                ";
            // line 9
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["movie"], "field_description", [], "any", false, false, true, 9), "value", [], "any", false, false, true, 9), 9, $this->source));
            echo "
            </div>
        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['movie'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "</ol> ";
    }

    public function getTemplateName()
    {
        return "modules/custom/reservation/templates/reservation.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 13,  60 => 9,  56 => 8,  52 => 7,  48 => 5,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/reservation/templates/reservation.html.twig", "D:\\server\\htdocs\\DRUPALPRAKSA-BIOSKOP\\modules\\custom\\reservation\\templates\\reservation.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 4);
        static $filters = array("raw" => 7, "escape" => 8);
        static $functions = array("file_url" => 8);

        try {
            $this->sandbox->checkSecurity(
                ['for'],
                ['raw', 'escape'],
                ['file_url']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
