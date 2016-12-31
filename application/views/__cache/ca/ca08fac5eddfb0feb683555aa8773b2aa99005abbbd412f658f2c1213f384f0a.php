<?php

/* __string_template__02f6ad686f1a19c7418864c9b300e99758cf5663197a0714ba1f0b067a754658 */
class __TwigTemplate_db19735787fca06f58427486376615501467249d0749187e567bdbe7b922fed7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <style>
        body
        {
            font-family: arial;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        code
        {
            font-size: smaller;
            font-family: monospace, courier;
        }
        .passed
        {
            color:green;
        }
        .failed
        {
            color:red;
        }
        .summary
        {
            padding-top: 10px;
            padding-bottom: 10px;
            height: 30px;
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #CCC;
        }
        .result-table
        {
            width: 100%;
        }
        .result-table th, .result-table td
        {
            border: 1px solid #CCC;
            font-size: small;
            padding-left: 5px;
            padding-right: 5px;
        }
        .result-table th.separator
        {
            padding-top: 20px;
            font-size: initial;
            text-align: left;
            border: none;
        }
    </style>
</head>
<body>
    <div class=\"summary\">
        ";
        // line 56
        echo twig_escape_filter($this->env, ($context["total"] ?? null), "html", null, true);
        echo " test performed.
        <span class=\"passed\">";
        // line 57
        echo twig_escape_filter($this->env, ($context["passed"] ?? null), "html", null, true);
        echo " passed</span>,
        <span class=\"failed\">";
        // line 58
        echo twig_escape_filter($this->env, ($context["failed"] ?? null), "html", null, true);
        echo " failed.</span>
    </div>
    <table class=\"result-table\">
        <tr><th class=\"separator\" colspan=\"6\">Test Mutation</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Undo Mutation should not work at the first time";
        // line 68
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 73</code></td><td><b>Boolean</b> <code>false</code></td><td><b>Boolean</b> <code>false</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Error message should be set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 76</code></td><td><b>String</b><br /><code>'Cannot undo mutation, mutation has not been performed'</code></td><td><b>String</b><br /><code>'Cannot undo mutation, mutation has not been performed'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Mutation should work at the first time";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 80</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Error message should not be set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 83</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Mutation should not work anymore since it has been performed";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 87</code></td><td><b>Boolean</b> <code>false</code></td><td><b>Boolean</b> <code>false</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Error message should not be set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 90</code></td><td><b>String</b><br /><code>'Cannot do mutation, mutation has already performed'</code></td><td><b>String</b><br /><code>'Cannot do mutation, mutation has already performed'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Undo Mutation should now work";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 94</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Error message should not be set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 97</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Mutation should work after undo mutation has been performed";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 101</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Error message should not be set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 104</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Cms Genesis</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Before anything done, \$genesis->is_db_valid() should yield FALSE";
        // line 75
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 114</code></td><td><b>Boolean</b> <code>false</code></td><td><b>Boolean</b> <code>false</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>genesis->setup() should yield TRUE";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 132</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>You can pass user, password, and database get query to override database setting, i.e: ?user=root&password=&database=mydb. By default this test use Mysql, user:root, password:toor, database:tests. The database should be empty</td></tr><tr><td>DB connection should work after genesis set";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 137</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>hostname should equals SERVER_NAME";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 148</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>hostname : localhost</td></tr><tr><td>sess_cookie_name is not empty";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 152</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>sess_cookie_name : e81009b98c</td></tr><tr><td>encryption_key is not empty";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 156</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>encryption_key : e81009b98ce4ddf4e8476a7b9bc2cd95</td></tr><tr><th class=\"separator\" colspan=\"6\">Test Config</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>config.hostname has been set correctly";
        // line 82
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 167</code></td><td><b>String</b><br /><code>'localhost'</code></td><td><b>String</b><br /><code>'localhost'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Migrator</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>\$migrate->migrate_all()";
        // line 89
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 194</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Count of table should be more than count of available modules";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 200</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>Table : go_cms_config, go_cms_group, go_cms_module, go_cms_site, go_cms_site_alias, go_cms_site_module, go_cms_user, go_migrations_cms, go_migrations_test</td></tr><tr><td>\$migrate->migrate_all(\"current\")";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 208</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Count of table should be equal to count of available modules";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 214</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>Table : go_migrations_cms, go_migrations_test</td></tr><tr><td>\$migrate->migrate(\"cms\")";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 222</code></td><td><b>String</b> <code>''</code></td><td><b>String</b> <code>''</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Count of table should be more than count of available modules";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 228</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td>Table : go_cms_config, go_cms_group, go_cms_module, go_cms_site, go_cms_site_alias, go_cms_site_module, go_cms_user, go_migrations_cms, go_migrations_test</td></tr><tr><th class=\"separator\" colspan=\"6\">Test Site</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Current Site Code should be NULL";
        // line 96
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 238</code></td><td><b>Null</b> <code>NULL</code></td><td><b>Null</b> <code>NULL</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>There should be no site code available";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 242</code></td><td><b>Array</b><br /><code>array (
)</code></td><td><b>Array</b><br /><code>array (
)</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Try add three site: famous, incognito, and oraono. Famous has 3 aliases: bukurai.com, takada.com, and pencuit.com";
        // line 98
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 251</code></td><td><b>Array</b><br /><code>array (
  0 => 'famous',
  1 => 'incognito',
  2 => 'ora ...</code></td><td><b>Array</b><br /><code>array (
  0 => 'famous',
  1 => 'incognito',
  2 => 'ora ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>There should be three aliases of famous site: bukurai.com, takada.com, and pencuit.com";
        // line 104
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 256</code></td><td><b>Array</b><br /><code>array (
  0 => 'bukurai.com',
  1 => 'takada.com',
  2 = ...</code></td><td><b>Array</b><br /><code>array (
  0 => 'bukurai.com',
  1 => 'takada.com',
  2 = ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Delete oraono, available site codes are now: famous and incognito";
        // line 110
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 262</code></td><td><b>Array</b><br /><code>array (
  0 => 'famous',
  1 => 'incognito',
)</code></td><td><b>Array</b><br /><code>array (
  0 => 'famous',
  1 => 'incognito',
)</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Delete takada.com from famous, available site alias for famous is bukurai.com and pencuit.com";
        // line 116
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 268</code></td><td><b>Array</b><br /><code>array (
  0 => 'bukurai.com',
  1 => 'pencuit.com',
)</code></td><td><b>Array</b><br /><code>array (
  0 => 'bukurai.com',
  1 => 'pencuit.com',
)</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Try add two aliases to incognito: ossass.com, uwewe.com. The two aliases should be there";
        // line 122
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 275</code></td><td><b>Array</b><br /><code>array (
  0 => 'ossass.com',
  1 => 'uwewe.com',
)</code></td><td><b>Array</b><br /><code>array (
  0 => 'ossass.com',
  1 => 'uwewe.com',
)</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>ossass.com is alias for incognito";
        // line 128
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 280</code></td><td><b>String</b><br /><code>'incognito'</code></td><td><b>String</b><br /><code>'incognito'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>pencuit.com is alias for famous";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 284</code></td><td><b>String</b><br /><code>'famous'</code></td><td><b>String</b><br /><code>'famous'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>bukurai.com is famous";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 292</code></td><td><b>String</b><br /><code>'famous'</code></td><td><b>String</b><br /><code>'famous'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>bukurai.com is not main site";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 296</code></td><td><b>Boolean</b> <code>false</code></td><td><b>Boolean</b> <code>false</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>incognito.localhost is obviously incognito";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 301</code></td><td><b>String</b><br /><code>'incognito'</code></td><td><b>String</b><br /><code>'incognito'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>incognito is not main site";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 305</code></td><td><b>Boolean</b> <code>false</code></td><td><b>Boolean</b> <code>false</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Main site should not have current code";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 311</code></td><td><b>Null</b> <code>NULL</code></td><td><b>Null</b> <code>NULL</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Obviously main site is main site";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 315</code></td><td><b>Boolean</b> <code>true</code></td><td><b>Boolean</b> <code>true</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Asset Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Asset URL of CMS's Jquery";
        // line 135
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 322</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Asset URL of CMS's Bootstrap";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 326</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/bootstrap-4.0. ...</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/bootstrap-4.0. ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Asset URL of bukurai.com's CMS's Jquery";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 334</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Asset URL of incognito's CMS's Jquery";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 340</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td><b>String</b><br /><code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Site Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>site URL of CMS";
        // line 142
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 349</code></td><td><b>String</b><br /><code>'http://localhost:8080/index.php/cms'</code></td><td><b>String</b><br /><code>'http://localhost:8080/index.php/cms'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>site URL of bukurai.com's CMS";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 360</code></td><td><b>String</b><br /><code>'http://bukurai.com:8080/index.php/cms'</code></td><td><b>String</b><br /><code>'http://bukurai.com:8080/index.php/cms'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>site URL of incognito's CMS";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 366</code></td><td><b>String</b><br /><code>'http://incognito.localhost:8080/index.php/cms'</code></td><td><b>String</b><br /><code>'http://incognito.localhost:8080/index.php/cms'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Run Module Controller</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Run Module Controller: cms/test/nyan?a=tama";
        // line 149
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 376</code></td><td><b>String</b><br /><code>'nyan nyan nyan tama'</code></td><td><b>String</b><br /><code>'nyan nyan nyan tama'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Run Module Controller: cms/test/nyan/gude?a=tama";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 380</code></td><td><b>String</b><br /><code>'nyan nyan gude tama'</code></td><td><b>String</b><br /><code>'nyan nyan gude tama'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Run Module Controller: cms/test/nyan?a=gude&b=tama";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 384</code></td><td><b>String</b><br /><code>'nyan nyan nyan gude tama'</code></td><td><b>String</b><br /><code>'nyan nyan nyan gude tama'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Run Routed Module Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Run Routed Module URL: nyan";
        // line 156
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 391</code></td><td><b>String</b><br /><code>'nyan nyan nyan'</code></td><td><b>String</b><br /><code>'nyan nyan nyan'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Run Routed Module URL: cms/test/nyan?a=tama";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 395</code></td><td><b>String</b><br /><code>'nyan nyan nyan tama'</code></td><td><b>String</b><br /><code>'nyan nyan nyan tama'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Run Routed Module URL: nyan/gude?a=tama";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 399</code></td><td><b>String</b><br /><code>'nyan nyan gude tama'</code></td><td><b>String</b><br /><code>'nyan nyan gude tama'</code></td><td class=\"passed\">Passed</td><td></td></tr><tr><td>Run Routed Module URL: nyan/nyan?a=gude&b=tama";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "Test Name", array(), "array"), "html", null, true);
        echo "</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 403</code></td><td><b>String</b><br /><code>'nyan nyan nyan gude tama'</code></td><td><b>String</b><br /><code>'nyan nyan nyan gude tama'</code></td><td class=\"passed\">Passed</td><td></td></tr>    </table>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "__string_template__02f6ad686f1a19c7418864c9b300e99758cf5663197a0714ba1f0b067a754658";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  295 => 156,  281 => 149,  267 => 142,  251 => 135,  227 => 128,  218 => 122,  209 => 116,  200 => 110,  191 => 104,  182 => 98,  175 => 96,  155 => 89,  145 => 82,  125 => 75,  97 => 68,  84 => 58,  80 => 57,  76 => 56,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__02f6ad686f1a19c7418864c9b300e99758cf5663197a0714ba1f0b067a754658", "");
    }
}
