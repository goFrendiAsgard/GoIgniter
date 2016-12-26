<head>
    <link rel="stylesheet" type="text/css" href="<?=asset_url('test/css/my_file.css')?>" />
</head>
<body>
    <h1>Hello all</h1>
    <h2><?=$date?></h2>
    <?php 
        foreach($articles as $article){
            echo '<h4>' . $article['title'] . '</h4>';
            echo $article['content'];
        }

        echo '<h2>Run some tests</h2>';

        echo '<h3>Run test/mycontroller/harambe/run?food=banana</h3>';
        echo '<pre>';
        run_module_controller('test/mycontroller/harambe/run?food=banana');
        echo '</pre>';

        echo '<h3>$_GET, there should be no food=banana unless you make it so</h3>';
        var_dump($_GET);

        echo '<h3>Add asset_url</h3>';
        var_dump(asset_url('test/js/my_file.js'));

        echo '<h3>Run test without return parameter, should yield the content, and return null</h3>';
        var_dump(run_module_controller('test'));

        echo '<h3>Run test/index without return parameter, should yield the content, and return null</h3>';
        var_dump(run_module_controller('test/index'));

        echo '<h3>Run test/ok without return parameter, should yield the content, and return null</h3>';
        var_dump(run_module_controller('test/ok'));

        echo '<h3>Run test with return parameter, should return the content</h3>';
        var_dump(run_module_controller('test', TRUE));

        echo '<h3>Run test/index with return parameter, should return the content</h3>';
        var_dump(run_module_controller('test/index', TRUE));

        echo '<h3>Run test/ok with return parameter, should return the content</h3>';
        var_dump(run_module_controller('test/ok', TRUE));


    ?>
    <script src="<?=asset_url('test/js/my_file.js')?>"></script>
</body>
