

<!-- resources/views/livewire/home-component.blade.php -->
<div class="text-center py-5">
    <h1 class="mb-4">Bem-vindo ao soul.ia :D</h1>
    <p class="lead">
    No Soul.ia, ajudamos você a descobrir seu perfil profissional com base em algumas perguntas simples. Com as suas respostas, encontramos as carreiras que mais combinam com você, o ambiente de trabalho ideal e como melhorar suas habilidades para crescer na sua jornada profissional. É rápido, fácil e feito para te ajudar a dar o próximo passo na sua carreira!
    </p>

    
    <!-- Botão para mostrar o Questionário -->
    @if (!$showQuestionario && empty($resultados))
        <a href="javascript:void(0);" class="btn btn-lg btn-primary" wire:click="$set('showQuestionario', true)">
            <i class="fas fa-play"></i> Começar o Questionário
        </a>
    @endif

  

    <!-- Exibe o componente Questionario quando showQuestionario for true -->
    @if ($showQuestionario)
    <livewire:questionario wire:ignore.self />
    @endif 

</div>
