@extends('layouts.main')

@section('title', 'Nova Avaliação')
@section('head')
    <link rel="stylesheet" href="/css/evaluation.css">
@endsection
@section('content')

    <main class="container-custom container">
        <div class="container-fluid p-5">
            <h3>Nova Avaliação</h3>
            <form class="form-group mt-4" action="{{ route('evaluations.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-3 d-flex align-items-center">
                    <div class="mb-3 d-flex align-items-center" style="width: auto;">
                        <label for="model" class="form-label m-1">Transcrição:</label>
                        <select class="form-select" id="model" name="model">
                            <option value="turbo">Turbo</option>
                            <option value="tiny">Mínimo</option>
                            <option value="base">Base</option>
                            <option value="small">Pequeno</option>
                            <option value="medium">Médio</option>
                            <option value="large-v3">Grande</option>
                        </select>
                    </div>
                    <div class="col-auto mb-2 mt-1">
                        <span id="alertModel" class="form-text">uso de memória VRAM (6GB)</span>
                    </div>
                </div>
                <div class="d-flex mb-3 align-items-center">
                        <label class="m-1 text-nowrap" for="referent">Data referência:</label>
                        <input class="form-control date" type="date" name="referent">
                </div>
                <label for="audio">Arquivo de Áudio:</label>
                <input type="file" id="audio" name="audio" accept="audio/*">
                <div class="d-flex mt-5 justify-content-center">
                    <button class="btn btn-dark w-50" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>

@endsection

@section('scripts')
    <script>
        document.getElementById('model').addEventListener('change', function() {
            const selectedModel = this.value;
            let memoryUsage = '';

            switch (selectedModel) {
                case 'tiny':
                    memoryUsage = 'uso de memória VRAM (1GB)';
                    break;
                case 'base':
                    memoryUsage = 'uso de memória VRAM (1GB)';
                    break;
                case 'small':
                    memoryUsage = 'uso de memória VRAM (2GB)';
                    break;
                case 'medium':
                    memoryUsage = 'uso de memória VRAM (5GB)';
                    break;
                case 'large':
                    memoryUsage = 'uso de memória VRAM (10GB)';
                    break;
                case 'turbo':
                    memoryUsage = 'uso de memória VRAM (6GB)';
                    break;
                default:
                    memoryUsage = '';
            }

            document.getElementById('alertModel').textContent = memoryUsage;
        });
    </script>
@endsection
