import os
import sys
import whisper

# Receber o caminho do arquivo de áudio como argumento
audio_file = sys.argv[1]

try:
    model = whisper.load_model("large")
    result = model.transcribe(audio_file)
    conteudo = result['text']
    nome_arquivo = os.path.splitext(os.path.basename(audio_file))[0] + '.txt'

    with open(nome_arquivo, 'w') as arquivo:
        arquivo.write(conteudo)

    print(result)
    print(f'Arquivo {nome_arquivo} foi criado com sucesso!')

except RuntimeError as e:
    print("Erro ao transcrever o áudio:", str(e))
