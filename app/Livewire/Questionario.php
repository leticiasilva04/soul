<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Exceptions\LivewireException;
use App\Models\Question;
use Illuminate\Support\Facades\Http;

class Questionario extends Component
{
    public $questions;
    public $resultados = [];
    public $answers = [];
    // O mount carrega as perguntas quando o componente é inicializado
    public function mount()
    {
        $this->questions = Question::all();
    }

    // Método de submit
    public function submit()
    {
        
       // Formatando a entrada para a API
       $input = "Perguntas e Respostas do usuario:\n";
       foreach ($this->answers as $question_id => $answer) {
           if (isset($this->questions[$question_id])) {
            $question_text = $this->questions[$question_id]->question_text; // Pega o texto da pergunta
            $input .= "$question_text: $answer\n"; // Monta a string
        }

       }

    // Estrutura inicial com placeholders que a IA preencherá com base nas respostas
    $estrutura = [
        "input" => "Preencha esse JSON com base nas perguntas e respostas enviadas:\n" . $input, // Concatenando as perguntas e respostas
        "perfil_usuario" => [
            "tipo_profissional" => [
                "descricao" => "Título conciso do tipo de perfil profissional do usuário"
            ],
            "grafico_radar" => [
                "competencias" => [
                    [
                        "nome" => "Liderança",
                        "porcentagem" => "Porcentagem de liderança do usuário"
                    ],
                    [
                        "nome" => "Comunicação",
                        "porcentagem" => "Porcentagem de comunicação do usuário"
                    ],
                    [
                        "nome" => "Gestão de Projetos",
                        "porcentagem" => "Porcentagem de gestão de projetos do usuário"
                    ],
                    [
                        "nome" => "Pensamento Crítico",
                        "porcentagem" => "Porcentagem de pensamento crítico do usuário"
                    ],
                    [
                        "nome" => "Inovação",
                        "porcentagem" => "Porcentagem de inovação do usuário"
                    ]
                ]
            ],
            "carreiras_compativeis" => [
                "descricao" => "Sugestões de carreiras compatíveis com base no perfil do usuário",
                "exemplo" => []
            ],
            "ambiente_trabalho_ideal" => [
                "descricao" => "Descrição do tipo de ambiente de trabalho onde o usuário se destacaria",
                "exemplo" => "Ambientes dinâmicos e inovadores, ou ambientes estruturados e tradicionais"
            ],
            "evolucao_perfil_profissional" => [
                "curto_prazo" => "O que o usuário pode fazer para evoluir profissionalmente no curto prazo (1-2 anos)",
                "medio_prazo" => "Metas de evolução no médio prazo (3-5 anos)",
                "longo_prazo" => "Perspectivas de evolução a longo prazo (5-10 anos)"
            ],
            "areas_aperfeicoamento" => [
                "descricao" => "Áreas específicas onde o usuário pode melhorar suas habilidades para se destacar",
                "exemplo" => []
            ],
            "cursos_certificacoes_recomendados" => [
                "descricao" => "Cursos ou certificações recomendadas para aprimorar as competências do usuário",
                "exemplo" => []
            ]
        ]
    ];


 
        // Enviar para a API do Hugging Face
        $response = Http::timeout(500) // 60 segundos
     ->withHeaders([
        'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
         'Content-Type'  => 'application/json',
     ])->post('https://api-inference.huggingface.co/models/meta-llama/Meta-Llama-3-8B-Instruct/v1/chat/completions', [
         
         "messages" => [
             [
                 "role" => "user",
                 "content" => json_encode($estrutura)
             ]
         ],
         "max_tokens" => 5000,
         "stream" => false,
     ]);
 
     $this->processarDadosDoPerfil($response);

}

public function processarDadosDoPerfil($response)
{
    // Captura o conteúdo retornado pela API
    $responseBody = $response->body();

// Use regex para capturar o JSON dentro de "content"
preg_match('/```(.*?)```/s', $response, $matches);

if (isset($matches[1])) {
    $jsonExtracted = trim($matches[1]);

    

    // Decodificar o JSON se necessário
    $decodedJson = json_decode($jsonExtracted, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo '<h3>Decodificado:</h3>';
        print_r($decodedJson);
    } else {
        echo 'Erro ao decodificar o JSON: ' . json_last_error_msg();
    }
} else {
    echo 'Nenhum JSON encontrado.';
}






    // Processar os dados do JSON decodificado
    if (isset($decodedJson['perfil_usuario'])) {
        $perfil = $decodedJson['perfil_usuario'];


        $resultados = [
            // Tipo de Profissional
            'tipo_profissional' => $perfil['tipo_profissional']['descricao'] ?? 'Não especificado',

            
            // Gráfico de Radar
            'grafico_radar' => array_map(function ($competencia) {
                return [
                    'nome' => $competencia['nome'] ?? 'Indefinido',
                    'porcentagem' => $competencia['porcentagem'] ?? '0%',
                ];
            }, $perfil['grafico_radar']['competencias'] ?? []),

            // Carreiras Compatíveis
            'carreiras_compativeis' => [
                'descricao' => $perfil['reiras_compativeis']['descricao'] ?? 'Não especificado',
                'exemplo' => $perfil['reiras_compativeis']['exemplo'] ?? [],
            ],

            // Ambiente de Trabalho Ideal
            'ambiente_trabalho_ideal' => [
                'descricao' => $perfil['ambiente_trabalho_ideal']['descricao'] ?? 'Não especificado',
                'exemplo' => $perfil['ambiente_trabalho_ideal']['exemplo'] ?? 'Não especificado',
            ],

            // Evolução do Perfil Profissional
            'evolucao_perfil_profissional' => [
                'curto_prazo' => $perfil['evolucao_perfil_profissional']['curto_prazo'] ?? 'Não especificado',
                'medio_prazo' => $perfil['evolucao_perfil_profissional']['medio_prazo'] ?? 'Não especificado',
                'longo_prazo' => $perfil['evolucao_perfil_profissional']['longo_prazo'] ?? 'Não especificado',
            ],

            // Áreas de Aperfeiçoamento
            'areas_aperfeicoamento' => [
                'descricao' => $perfil['areas_aperfeicoamento']['descricao'] ?? 'Não especificado',
                'exemplo' => $perfil['areas_aperfeicoamento']['exemplo'] ?? [],
            ],

            // Cursos e Certificações Recomendados
            'cursos_certificacoes_recomendados' => [
                'descricao' => $perfil['cursos_certificacoes_recomendados']['descricao'] ?? 'Não especificado',
                'exemplo' => $perfil['cursos_certificacoes_recomendados']['exemplo'] ?? [],
            ],
        ];

        dump($resultados);

        // Passar os resultados para a view
        session()->flash('resultados', $resultados);
    } else {
        // Caso o JSON decodificado não contenha o campo esperado
        session()->flash('message', 'Erro: Estrutura do JSON não contém "perfil_usuario".');
    }
}


    // Método que exibe a view com as perguntas
    public function render()
    {
        return view('livewire.questionario')->layout('layouts.app'); // Passando as perguntas diretamente pela propriedade $questions
    }
}

