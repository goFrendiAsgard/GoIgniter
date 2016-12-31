<?php

/* modules/cms/test_controller_index.php */
class __TwigTemplate_c5929699e92674cf878bdf211c988b9799b46ab48031339852894341c3ae0e3e extends Twig_Template
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
        echo "<head>
    <style>
        body
        {
            font-family: arial;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .passed
        {
            color:green;
        }
        .failed
        {
            color:red;
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
        code
        {
            font-size: smaller;
            font-family: monospace, courier;
        }
    </style>
</head>
<body>
    <div class=\"summary\">
        <?=\$total?> test performed. <span class=\"passed\"><?=\$passed?> passed</span>, <span class=\"failed\"><?=\$failed?> failed.</span>
    </div>
    <table class=\"result-table\">
        <?php
            \$header = '<tr>
                <th>Test Name</th>
                <th>Location</th>
                <th>Test</th>
                <th>Expected</th>
                <th>Result</th>
                <th>Notes</th>
            </tr>';

            for(\$i=0; \$i<count(\$result); \$i++)
            {
                if(array_key_exists(\$i, \$separator))
                {
                    echo '<tr><th class=\"separator\" colspan=\"6\">' . \$separator[\$i] . '</th></tr>';
                    echo \$header;
                }

                // get row and print row content
                \$row = \$result[\$i];

                \$rowTest = \$row['Test'];
                \$rowExpected = \$row['Expected'];
                if(\$row['Test'] == \$row['Expected'] && strlen(\$row['Test']) > 60)
                {
                    if(strpos(\$rowExpected, '<') === FALSE && strpos(\$rowExpected, '<') === FALSE)
                    {
                        \$truncated = substr(\$row['Test'], 0, 56).' ...';
                        \$rowTest = \$truncated;
                        \$rowExpected = \$truncated;
                    }
                }

                echo '<tr>';
                echo '<td>' . \$row['Test Name'] . '</td>';
                echo '<td><code>' . \$row['File Name'] . ' : ' . \$row['Line Number'] . '</code></td>';
                echo '<td><b>' . \$row['Test Datatype'] . '</b>'
                    . (strlen(\$rowTest) > 5 ? '<br />' : ' ')
                    . '<code>'. (\$rowTest) . '</code></td>';
                echo '<td><b>' . \$row['Expected Datatype'] . '</b>'
                    . (strlen(\$rowExpected) > 5 ? '<br />' : ' ')
                    . '<code>'. (\$rowExpected) . '</code></td>';
                echo '<td class=\"' . (\$row['Result'] == 'Passed' ? 'passed' : 'failed') . '\">' . \$row['Result'] . '</td>';
                echo '<td>' . \$row['Notes'] . '</td>';
                echo '</tr>';
            }
        ?>
    </table>
</body>
";
    }

    public function getTemplateName()
    {
        return "modules/cms/test_controller_index.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/cms/test_controller_index.php", "/home/gofrendi/public_html/GoIgniter/application/views/modules/cms/test_controller_index.php");
    }
}
