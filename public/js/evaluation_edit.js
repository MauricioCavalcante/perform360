document.getElementById('edit-btn').addEventListener('click', function() {
    document.getElementById('edit-form').style.display = 'block';
    document.getElementById('question-list').style.display = 'none';
});

document.getElementById('cancel-edit-btn').addEventListener('click', function() {
    document.getElementById('edit-form').style.display = 'none';
    document.getElementById('question-list').style.display = 'block';
});
document.addEventListener('DOMContentLoaded', function() {
    // Selecionar todos os radio buttons e elementos de dedução
    const radioElements = document.querySelectorAll('.score');
    const deductionContainers = document.querySelectorAll('.container.deduction');

    function calcularPontuacao() {
        let totalScore = 0;

        // Calcular a pontuação total
        radioElements.forEach(radio => {
            if (radio.checked) {
                const questionContainer = radio.closest('.container');
                const isDeduction = questionContainer.classList.contains('deduction');

                if (!isDeduction) {
                    totalScore += parseFloat(radio.value);
                }
            }
        });

        let totalDeductionAmount = 0;

        // Calcular o valor total das deduções
        deductionContainers.forEach(container => {
            const questionId = container.getAttribute('data-question-id');
            const deductionPercentage = parseFloat(container.getAttribute('data-question-score'));

            // Verificar se a opção "Não" está selecionada
            const noRadio = container.querySelector(`input[type=radio][value="0"]`);

            if (noRadio && noRadio.checked) {
                totalDeductionAmount += (totalScore * (deductionPercentage / 100));
            }
        });

        const finalScore = totalScore - totalDeductionAmount;

        // Atualizar o valor total no formulário
        document.querySelector('#currentValue').textContent = finalScore.toFixed(2);
        document.querySelector('#totalScore').value = finalScore.toFixed(2);
    }

    // Adicionar eventos de mudança para todos os radio buttons
    radioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

    // Adicionar eventos de mudança para todos os radio buttons dentro dos elementos de dedução
    deductionContainers.forEach(container => {
        container.querySelectorAll('input[type=radio]').forEach(radio => {
            radio.addEventListener('change', calcularPontuacao);
        });
    });

    // Calcular a pontuação inicial ao carregar a página
    calcularPontuacao();
});

