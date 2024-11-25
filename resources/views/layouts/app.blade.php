<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soul.ia</title>

    <!-- Adicionando o FontAwesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Estilos do Livewire -->
    @livewireStyles

    <link rel="manifest" href="/manifest.json">

    <!-- Axios necessário para Livewire Event Listener -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        /* Personalizando o fundo da barra de navegação */
        .main-header.navbar {
            background-color: #B6D0E2; /* Cor principal do cabeçalho */
            color: #fff;
        }

        /* Alterando a cor do texto da navbar */
        .main-header .navbar-nav .nav-link {
            color: #333 !important;
        }

        /* Alterando o estilo da navbar */
        .navbar-nav .nav-link:hover {
            background-color: #A0C4D7 !important;
            color: #fff !important;
        }

        /* Ajustando o título do sistema */
        .brand-text {
            font-weight: bold;
            color: #333;
        }



        body, .wrapper {
    min-height: 100vh;  /* Garante que o conteúdo ocupe pelo menos a altura da tela */
    display: flex;
    flex-direction: column;
}

/* Fazendo o conteúdo crescer para empurrar o footer para baixo */
.content-wrapper {
    flex-grow: 1;
}

/* Personalizando o footer para ser fixo no fundo da tela */
.main-footer {
    background-color: #B6D0E2;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: relative;  /* Removido o "fixed" para deixá-lo abaixo do conteúdo */
    bottom: 0;
    width: 100%;  /* Garante que o footer ocupe toda a largura da página */
}

        /* Tornando os botões mais visíveis */
        .btn-primary {
            background-color: #B6D0E2 !important;
            border-color: #A0C4D7 !important;
        }

        .btn-primary:hover {
            background-color: #A0C4D7 !important;
            border-color: #B6D0E2 !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 soul ia.</strong> Todos os direitos reservados.
        </footer>
    </div>

    <!-- JQuery e Bootstrap (carregados apenas uma vez) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Livewire Scripts -->
    @livewireScripts
    


    <!-- Script do service worker movido para o final -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(registration => {
                    console.log('Service Worker registrado com sucesso:', registration);
                })
                .catch(error => {
                    console.log('Falha ao registrar o Service Worker:', error);
                });
        }
    </script>

    <!-- Event Listener para Livewire e Axios -->
    <script>
        window.addEventListener('submit-answers', event => {
            axios.post('/api/submit-answers', event.detail)
                .then(response => {
                    console.log(response.data); // Exibir resultados na página de resultados
                })
                .catch(error => {
                    console.error('Erro ao enviar respostas:', error);
                });
        });
    </script>
</body>
</html>
