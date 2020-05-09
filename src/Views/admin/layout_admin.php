<html>
    <head>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header>
            <?php include __DIR__ . '/../../src/Views/admin/header_admin.php' ?>
        </header>
        {{ block 'body' }}
        {{ endblock }}
    </body>
</html>