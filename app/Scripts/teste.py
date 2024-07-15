import sys
import whisper

if len(sys.argv) < 2:
    print("Erro: Caminho do arquivo de áudio não fornecido.")
    sys.exit(1)

audio = "/var/www/html/qualitysphere/storage/app/public/upload/audio-668d155ef031b.wav"


model = whisper.load_model("large")
result = model.transcribe(audio)

transcricao = result['text']

print(transcricao)