import sys
import logging
import whisper 

# Configuração de logging para debug
logging.basicConfig(
    format='%(asctime)s - %(levelname)s - %(message)s',
    level=logging.INFO 
)

def transcrever_audio(audio_file):
    try:
        logging.info(f"Iniciando transcrição para o arquivo: {audio_file}")

        model = whisper.load_model("large")
        
        result = model.transcribe(audio_file)
        transcricao = result.get('text', '')

        logging.info(f"Transcrição concluída com sucesso: {transcricao}")

        return transcricao

    except FileNotFoundError:
        logging.error(f"Arquivo de áudio não encontrado: {audio_file}")
        return None
    except Exception as e:
        logging.error(f"Erro durante a transcrição: {str(e)}")
        return None

if __name__ == "__main__":
    if len(sys.argv) < 2:
        logging.error("Caminho do arquivo de áudio não fornecido.")
        sys.exit(1)

    audio_file = sys.argv[1]
    
    sys.stdout.reconfigure(encoding='utf-8')
    
    transcricao = transcrever_audio(audio_file)

    if transcricao is not None:
        print(transcricao)
    else:
        logging.error("Ocorreu um erro durante a transcrição.")
