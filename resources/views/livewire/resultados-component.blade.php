
<div class="container">
 
<h1>aaaaaa</h1>
// Na view, você pode acessar os dados passados pela session
@if(session()->has('resultados'))
    @php
        $resultados = session()->get('resultados');
    @endphp

    <h2>Tipo de Profissional</h2>
    <p>{{ $resultados['tipo_profissional'] }}</p>

    <h2>Gráfico de Radar</h2>
    <ul>
        @foreach($resultados['grafico_radar'] as $competencia)
            <li>{{ $competencia['nome'] }}: {{ $competencia['porcentagem'] }}%</li>
        @endforeach
    </ul>

    <h2>Carreiras Compatíveis</h2>
    <p>{{ $resultados['carreiras_compativeis']['descricao'] }}</p>
    <ul>
        @foreach($resultados['carreiras_compativeis']['exemplo'] as $carreira)
            <li>{{ $carreira }}</li>
        @endforeach
    </ul>

    <h2>Ambiente de Trabalho Ideal</h2>
    <p>{{ $resultados['ambiente_trabalho_ideal']['descricao'] }}</p>
    <ul>
        @foreach($resultados['ambiente_trabalho_ideal']['exemplo'] as $ambiente)
            <li>{{ $ambiente }}</li>
        @endforeach
    </ul>

    <h2>Evolução do Perfil Profissional</h2>
    <p>Curto Prazo: {{ $resultados['evolucao_perfil_profissional']['curto_prazo'] }}</p>
    <p>Médio Prazo: {{ $resultados['evolucao_perfil_profissional']['medio_prazo'] }}</p>
    <p>Longo Prazo: {{ $resultados['evolucao_perfil_profissional']['longo_prazo'] }}</p>

    <h2>Áreas de Aperfeiçoamento</h2>
    <p>{{ $resultados['areas_aperfeicoamento']['descricao'] }}</p>
    <ul>
        @foreach($resultados['areas_aperfeicoamento']['exemplo'] as $area)
            <li>{{ $area }}</li>
        @endforeach
    </ul>

    <h2>Cursos e Certificações Recomendados</h2>
    <p>{{ $resultados['cursos_certificacoes_recomendados']['descricao'] }}</p>
    <ul>
        @foreach($resultados['cursos_certificacoes_recomendados']['exemplo'] as $curso)
            <li>{{ $curso }}</li>
        @endforeach
    </ul>

@else
    <p>Não há resultados disponíveis.</p>
@endif

 


</div>

