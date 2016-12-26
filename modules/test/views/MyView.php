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

        echo '<pre>';
        run_module_controller('test/mycontroller/harambe/run?food=banana');
        echo '</pre>';

        var_dump($_GET);
        var_dump(asset_url('test/js/my_file.js'));
    ?>
    <script src="<?=asset_url('test/js/my_file.js')?>"></script>
</body>
