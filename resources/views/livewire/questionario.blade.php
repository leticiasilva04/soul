<div class="container mt-5">
    <h2 class="text-center mb-4">Bem-vindo ao Questionário</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('result'))
        <div class="alert alert-info">
            <h4>Resultados do Questionário</h4>
            <pre>{{ json_encode(session('result'), JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif

    <!-- Quando o botão for clicado, o questionário é exibido -->
    <form wire:submit.prevent="submit">
    @csrf
    @foreach ($questions as $question)
            <div class="mb-3">
                <label for="question{{ $question->id }}" class="form-label">{{ $question->question_text }}</label>

                <!-- Não é necessário o json_decode, pois o campo 'options' já é um array -->
                @foreach ($question->options as $key => $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question{{ $question->id }}" id="question{{ $question->id }}_{{ $key }}" value="{{ $option }}" wire:model="answers.{{ $question->id }}">
                        <label class="form-check-label" for="question{{ $question->id }}_{{ $key }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        
        <button type="submit" class="btn btn-success" >Enviar Respostas</button>
    </form>

    @if ($resultados)
        <livewire:resultados-component />
    @endif

</div>
