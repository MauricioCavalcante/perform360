import sys
import whisper

if len(sys.argv) < 2:
    print("Erro: Caminho do arquivo de áudio não fornecido.")
    sys.exit(1)

audio_file = sys.argv[1]

try:
    model = whisper.load_model("large")  
    result = model.transcribe(audio_file)
    transcricao_bruto = result['text']  


    transcricao = transcricao_bruto.encode('utf-8', errors='ignore').decode('utf-8', errors='ignore')


    print(transcricao)

except Exception as e:
    print(f"Erro ao transcrever o áudio: {str(e)}", file=sys.stderr) 
    sys.exit(1)
