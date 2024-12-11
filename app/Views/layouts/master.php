<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Default Title' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }
        .sidebar {
            width: 250px;
            background-color: #007dc5;
            color: white;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background-color: #0a669b;
        }
        .content {
            margin-left: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            width: calc(100% - 250px);
            height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-2 col-md-2 d-md-block sidebar">
                <h4 class="p-3">Menu</h4>
                <div class="p-3">
                    <p>Bem vindo</p>
                    <h3><?= esc(session()->get('user_name')) ?></h3>                    
                </div>
                <a href="<?php echo base_url('pages/dashboard')?>">Dashboard</a>
                <a href="<?php echo base_url('pages/usuarios')?>">Usuários</a>
                <a href="<?php echo base_url('pages/logout')?>">Sair</a>
            </nav>

            <!-- Main content -->
            <main class="col-10 col-md-10 ms-sm-auto content">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/htmx.org@2.0.3/dist/htmx.js" integrity="sha384-BBDmZzVt6vjz5YbQqZPtFZW82o8QotoM7RUp5xOxV3nSJ8u2pSdtzFAbGKzTlKtg" crossorigin="anonymous"></script>
</body>

</html>
