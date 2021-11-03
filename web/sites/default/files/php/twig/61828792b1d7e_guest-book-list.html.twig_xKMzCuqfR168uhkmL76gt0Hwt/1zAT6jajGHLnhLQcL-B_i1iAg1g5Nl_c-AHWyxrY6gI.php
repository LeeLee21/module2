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

/* modules/custom/guestbook/templates/guest-book-list.html.twig */
class __TwigTemplate_e3496f3fd0ea4c18e8fe1ead11e8ea558960f7489ace034db451e9173121e5e6 extends \Twig\Template
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
        echo "<div class=\"content-wrapper\">
  <div class=\"user-info\">
    <div class=\"user-ava\">
      <div class=\"avatar\">";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["avatar"] ?? null), 4, $this->source), "html", null, true);
        echo "</div>
    </div>
    <div class=\"user-variables\">
      <div class=\"name\">";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["name"] ?? null), 7, $this->source), "html", null, true);
        echo "</div>
      <div class=\"email\">";
        // line 8
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["email"] ?? null), 8, $this->source), "html", null, true);
        echo "</div>
      <div class=\"phone_number\">";
        // line 9
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["phone_number"] ?? null), 9, $this->source), "html", null, true);
        echo "</div>
      <div class=\"timestamp\">";
        // line 10
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_date_format_filter($this->env, $this->sandbox->ensureToStringAllowed(($context["timestamp"] ?? null), 10, $this->source), "M-d-Y H:i:s"), "html", null, true);
        echo "</div>
    </div>
  </div>
  <div class=\"user-response\">
    <div class=\"response\">";
        // line 14
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["response"] ?? null), 14, $this->source), "html", null, true);
        echo "</div>
    <div class=\"image\">";
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["image"] ?? null), 15, $this->source), "html", null, true);
        echo "</div>
  </div>
  ";
        // line 17
        if (twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "hasPermission", [0 => "administer nodes"], "method", false, false, true, 17)) {
            // line 18
            echo "    <div class=\"btn\">
      <div class=\"edit\"><a href=\"/guestbook/edit/";
            // line 19
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["id"] ?? null), 19, $this->source), "html", null, true);
            echo "\" class=\"use-ajax edit-btn\" data-dialog-type=\"modal\"><img
            src=\"/modules/custom/guestbook/images/editing.png\" alt=\"edit\" class=\"edit-img\"></a></div>
      <div class=\"delete\"><a href=\"/guestbook/delete/";
            // line 21
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["id"] ?? null), 21, $this->source), "html", null, true);
            echo "\" class=\"use-ajax delete-btn\" data-dialog-type=\"modal\"><img
            src=\"/modules/custom/guestbook/images/delete.png\" alt=\"delete\" class=\"delete-img\"></a></div>
    </div>
  ";
        }
        // line 25
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/guestbook/templates/guest-book-list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 25,  88 => 21,  83 => 19,  80 => 18,  78 => 17,  73 => 15,  69 => 14,  62 => 10,  58 => 9,  54 => 8,  50 => 7,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/guestbook/templates/guest-book-list.html.twig", "/var/www/web/modules/custom/guestbook/templates/guest-book-list.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 17);
        static $filters = array("escape" => 4, "date" => 10);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'date'],
                []
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
