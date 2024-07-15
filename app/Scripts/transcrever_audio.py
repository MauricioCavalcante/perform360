import sys
import whisper

if len(sys.argv) < 2:
    print("Erro: Caminho do arquivo de áudio não fornecido.")
    sys.exit(1)

audio_file = sys.argv[1]


model = whisper.load_model("large")
result = model.transcribe(audio_file)
transcricao = result['text']  


print(transcricao)

