<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Uso do Sistema</h1>

        <div class="row text-center">
            <!-- CPU Usage -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Uso de CPU</h5>
                        <p class="card-text fs-4 fw-bold text-primary" id="cpu-usage">Carregando...</p>
                    </div>
                </div>
            </div>

            <!-- Disk Usage -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                <div class="card-body">
                        <h5 class="card-title">Uso de Memória</h5>
                        <p class="card-text fs-4 fw-bold text-primary" id="memory-usage">Carregando...</p>
                    </div>
                </div>
            </div>

            <!-- Memory Usage -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                <div class="card-body">
                        <h5 class="card-title">Uso de Disco</h5>
                        <p class="card-text fs-4 fw-bold text-primary" id="disk-usage">Carregando...</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Informações do Sistema</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Detalhe</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Arquitetura</td>
                    <td><?= $data['os_info']['architecture'] . ', ' . $data['os_info']['architecture2']; ?></td>
                </tr>
                <tr>
                    <td>Distribuição</td>
                    <td><?= $data['os_info']['release']; ?></td>
                </tr>
                <tr>
                    <td>Sistema</td>
                    <td><?= $data['os_info']['system']; ?></td>
                </tr>
                <tr>
                    <td>Versão</td>
                    <td><?= $data['os_info']['version']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const socket = new WebSocket("<?php echo env('WEBSOCKET_SERVER_URL'); ?>");

        socket.onopen = () => {
            console.log("Conexão WebSocket estabelecida.");
        };

        socket.onmessage = (event) => {
            console.log("Dados recebidos:", event.data); // Adicione este log
            const data = JSON.parse(event.data);

            if (data.cpu_usage) {
                document.getElementById('cpu-usage').innerText = data.cpu_usage;
            } else {
                console.error("Dados inválidos recebidos:", data);
            }

            if (data.memory_usage) {
                document.getElementById('memory-usage').innerText = data.memory_usage;
            } else {
                console.error("Dados inválidos recebidos:", data);
            }

            if (data.disk_usage) {
                document.getElementById('disk-usage').innerText = data.disk_usage;
            } else {
                console.error("Dados inválidos recebidos:", data);
            }
        };

        socket.onerror = (error) => {
            console.error("Erro no WebSocket:", error);
        };

        socket.onclose = () => {
            console.log("Conexão WebSocket encerrada.");
        };
    </script>
<?= $this->endSection() ?>