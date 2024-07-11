import sys
import whisper

# Verifica se o número de argumentos está correto (deve ser pelo menos 1, o caminho do arquivo de áudio)
if len(sys.argv) < 2:
    print("Erro: Caminho do arquivo de áudio não fornecido.")
    sys.exit(1)

# Captura o caminho do arquivo de áudio a partir dos argumentos
audio_file = sys.argv[1]

try:
    model = whisper.load_model("large")  # Carrega o modelo Whisper (substitua com o modelo que você está usando)
    result = model.transcribe(audio_file)  # Realiza a transcrição do áudio
    transcricao = result['text']  # Obtém o texto transcrito

    print(transcricao)  # Imprime o texto transcrito, que será capturado pelo shell_exec no Laravel

except Exception as e:
    print(f"Erro ao transcrever o áudio: {str(e)}")  # Imprime o erro, se ocorrer
    sys.exit(1)  # Termina o script com código de erro 1 em caso de erro
