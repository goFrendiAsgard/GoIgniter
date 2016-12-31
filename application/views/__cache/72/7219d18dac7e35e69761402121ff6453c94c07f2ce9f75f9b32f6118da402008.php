<?php

/* __string_template__a907ae892c982badbfc7bcf8e1e76e4363f20f566077d4aaf8d3fea11302be20 */
class __TwigTemplate_cd70678e16cf71d51a8f6494ecc4f0630a70b071f3a6ee52978d3ff8838f8ab8 extends Twig_Template
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
            color:#0C0;
        }
        .failed
        {
            color:#C00;
        }
        .summary
        {
            padding-top: 10px;
            padding-bottom: 10px;
            height: 30px;
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #EEE;
            border-bottom: 1px solid #CCC;
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
        // line 57
        echo twig_escape_filter($this->env, ($context["total"] ?? null), "html", null, true);
        echo " test performed.
        <span class=\"passed\">";
        // line 58
        echo twig_escape_filter($this->env, ($context["passed"] ?? null), "html", null, true);
        echo " passed</span>,
        <span class=\"failed\">";
        // line 59
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
            </tr><tr><td>Undo Mutation should not work at the first time</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 73</code></td><td><b>boolean</b> <code>false</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Error message should be set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 76</code></td><td><b>string</b> <code>'Cannot undo mutation, mutation has not been performed'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Mutation should work at the first time</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 80</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Error message should not be set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 83</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Mutation should not work anymore since it has been performed</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 87</code></td><td><b>boolean</b> <code>false</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Error message should not be set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 90</code></td><td><b>string</b> <code>'Cannot do mutation, mutation has already performed'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Undo Mutation should now work</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 94</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Error message should not be set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 97</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Mutation should work after undo mutation has been performed</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 101</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Error message should not be set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 104</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Cms Genesis</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Before anything done, \$genesis->is_db_valid() should yield FALSE</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 114</code></td><td><b>boolean</b> <code>false</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>genesis->setup() should yield TRUE</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 132</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>You can pass user, password, and database get query to override database setting, i.e: ?user=root&password=&database=mydb. By default this test use Mysql, user:root, password:toor, database:tests. The database should be empty</td></tr><tr><td>DB connection should work after genesis set</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 137</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>hostname should equals SERVER_NAME</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 148</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>hostname : localhost</td></tr><tr><td>sess_cookie_name is not empty</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 152</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>sess_cookie_name : 8ae3ac971a</td></tr><tr><td>encryption_key is not empty</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 156</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>encryption_key : 8ae3ac971ac4f39d096f6e9d3aeb2bad</td></tr><tr><th class=\"separator\" colspan=\"6\">Test Config</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>config.hostname has been set correctly</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 167</code></td><td><b>string</b> <code>'localhost'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Migrator</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>\$migrate->migrate_all()</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 194</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Count of table should be more than count of available modules</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 200</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>Table : go_cms_config, go_cms_group, go_cms_module, go_cms_site, go_cms_site_alias, go_cms_site_module, go_cms_user, go_migrations_cms, go_migrations_test</td></tr><tr><td>\$migrate->migrate_all(\"current\")</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 208</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Count of table should be equal to count of available modules</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 214</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>Table : go_migrations_cms, go_migrations_test</td></tr><tr><td>\$migrate->migrate(\"cms\")</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 222</code></td><td><b>string</b> <code>''</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Count of table should be more than count of available modules</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 228</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td>Table : go_cms_config, go_cms_group, go_cms_module, go_cms_site, go_cms_site_alias, go_cms_site_module, go_cms_user, go_migrations_cms, go_migrations_test</td></tr><tr><th class=\"separator\" colspan=\"6\">Test Site</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Current Site Code should be NULL</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 238</code></td><td><b>NULL</b> <code>NULL</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>NULL</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>There should be no site code available</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 242</code></td><td><b>array</b> <code>array (
)</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Try add three site: famous, incognito, and oraono. Famous has 3 aliases: bukurai.com, takada.com, and pencuit.com</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 251</code></td><td><b>array</b> <code>array (
  0 => 'famous',
  1 => 'incognito',
  2 => 'ora ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>There should be three aliases of famous site: bukurai.com, takada.com, and pencuit.com</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 256</code></td><td><b>array</b> <code>array (
  0 => 'bukurai.com',
  1 => 'takada.com',
  2 = ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Delete oraono, available site codes are now: famous and incognito</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 262</code></td><td><b>array</b> <code>array (
  0 => 'famous',
  1 => 'incognito',
)</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Delete takada.com from famous, available site alias for famous is bukurai.com and pencuit.com</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 268</code></td><td><b>array</b> <code>array (
  0 => 'bukurai.com',
  1 => 'pencuit.com',
)</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Try add two aliases to incognito: ossass.com, uwewe.com. The two aliases should be there</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 275</code></td><td><b>array</b> <code>array (
  0 => 'ossass.com',
  1 => 'uwewe.com',
)</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>array</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>ossass.com is alias for incognito</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 280</code></td><td><b>string</b> <code>'incognito'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>pencuit.com is alias for famous</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 284</code></td><td><b>string</b> <code>'famous'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>bukurai.com is famous</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 292</code></td><td><b>string</b> <code>'famous'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>bukurai.com is not main site</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 296</code></td><td><b>boolean</b> <code>false</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>incognito.localhost is obviously incognito</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 301</code></td><td><b>string</b> <code>'incognito'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>incognito is not main site</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 305</code></td><td><b>boolean</b> <code>false</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Main site should not have current code</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 311</code></td><td><b>NULL</b> <code>NULL</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>NULL</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Obviously main site is main site</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 315</code></td><td><b>boolean</b> <code>true</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>boolean</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Asset Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Asset URL of CMS's Jquery</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 322</code></td><td><b>string</b> <code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Asset URL of CMS's Bootstrap</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 326</code></td><td><b>string</b> <code>'http://localhost:8080/assets/modules/cms/bootstrap-4.0. ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Asset URL of bukurai.com's CMS's Jquery</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 334</code></td><td><b>string</b> <code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Asset URL of incognito's CMS's Jquery</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 340</code></td><td><b>string</b> <code>'http://localhost:8080/assets/modules/cms/jquery-3.1.1.m ...</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Site Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>site URL of CMS</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 349</code></td><td><b>string</b> <code>'http://localhost:8080/index.php/cms'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>site URL of bukurai.com's CMS</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 360</code></td><td><b>string</b> <code>'http://bukurai.com:8080/index.php/cms'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>site URL of incognito's CMS</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 366</code></td><td><b>string</b> <code>'http://incognito.localhost:8080/index.php/cms'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Run Module Controller</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Run Module Controller: cms/test/nyan?a=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 376</code></td><td><b>string</b> <code>'nyan nyan nyan tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Run Module Controller: cms/test/nyan/gude?a=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 380</code></td><td><b>string</b> <code>'nyan nyan gude tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Run Module Controller: cms/test/nyan?a=gude&b=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 384</code></td><td><b>string</b> <code>'nyan nyan nyan gude tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><th class=\"separator\" colspan=\"6\">Test Run Routed Module Url</th></tr><tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr><tr><td>Run Routed Module URL: nyan</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 391</code></td><td><b>string</b> <code>'nyan nyan nyan'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Run Routed Module URL: cms/test/nyan?a=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 395</code></td><td><b>string</b> <code>'nyan nyan nyan tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Run Routed Module URL: nyan/gude?a=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 399</code></td><td><b>string</b> <code>'nyan nyan gude tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr><tr><td>Run Routed Module URL: nyan/nyan?a=gude&b=tama</td><td><code>/home/gofrendi/public_html/GoIgniter/modules/cms/controllers/Test.php : 403</code></td><td><b>string</b> <code>'nyan nyan nyan gude tama'</code></td>
<div style=\"border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;\">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined index: res</p>
<p>Filename: cms/test_controller_index.php</p>
<p>Line Number: 84</p>


\t<p>Backtrace:</p>
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php<br />
\t\t\tLine: 84<br />
\t\t\tFunction: _error_handler\t\t\t</p>

\t\t
\t
\t\t
\t
\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/go_init.php<br />
\t\t\tLine: 229<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/modules/cms/Test_Controller.php<br />
\t\t\tLine: 127<br />
\t\t\tFunction: view\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/application/core/MY_CodeIgniter.php<br />
\t\t\tLine: 546<br />
\t\t\tFunction: index\t\t\t</p>

\t\t
\t
\t\t
\t\t\t<p style=\"margin-left:10px\">
\t\t\tFile: /home/gofrendi/public_html/GoIgniter/index.php<br />
\t\t\tLine: 327<br />
\t\t\tFunction: require_once\t\t\t</p>

\t\t
\t

</div><td><b>string</b> <code></code></td><td class=\"failed\">passed</td><td></td></tr>    </table>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "__string_template__a907ae892c982badbfc7bcf8e1e76e4363f20f566077d4aaf8d3fea11302be20";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 59,  81 => 58,  77 => 57,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__a907ae892c982badbfc7bcf8e1e76e4363f20f566077d4aaf8d3fea11302be20", "");
    }
}
