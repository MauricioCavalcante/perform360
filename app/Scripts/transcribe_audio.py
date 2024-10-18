import sys
import logging
import whisper 

# Configuração de logging para debug
logging.basicConfig(
    format='%(asctime)s - %(levelname)s - %(message)s',
    level=logging.INFO 
)

def transcrever_audio(audio_file, model_name):
    try:
        logging.info(f"Iniciando transcrição para o arquivo: {audio_file}")
        logging.info(f"modelo de transcrição: {model_name}")

        model = whisper.load_model(model_name)
        
        result = model.transcribe(audio_file, language="pt")
        transcricao = result.get('text', '')

        logging.info(f"Transcrição concluída com sucesso: {transcricao} , transcrição modelo {model_name}" )

        return transcricao

    except FileNotFoundError:
        logging.error(f"Arquivo de áudio não encontrado: {audio_file}")
        return None
    except Exception as e:
        logging.error(f"Erro durante a transcrição: {str(e)}")
        return None

if __name__ == "__main__":
    if len(sys.argv) < 3:  
        logging.error("Caminho do arquivo de áudio ou modelo não fornecido.")
        sys.exit(1)

    audio_file = sys.argv[1]
    model_name = sys.argv[2] 

    sys.stdout.reconfigure(encoding='utf-8')
    
    transcricao = transcrever_audio(audio_file, model_name)

    if transcricao is not None:
        print(transcricao)
    else:
        logging.error("Ocorreu um erro durante a transcrição.")