document.getElementById('edit-btn').addEventListener('click', function() {
    document.getElementById('edit-form').style.display = 'block';
    document.getElementById('question-list').style.display = 'none';
});

document.getElementById('cancel-edit-btn').addEventListener('click', function() {
    document.getElementById('edit-form').style.display = 'none';
    document.getElementById('question-list').style.display = 'block';
});
document.addEventListener('DOMContentLoaded', function() {
  
    const radioElements = document.querySelectorAll('.score');
    const deductionContainers = document.querySelectorAll('.container.deduction');

    function calcularPontuacao() {
        let totalScore = 0;

        
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

      
        deductionContainers.forEach(container => {
            const questionId = container.getAttribute('data-question-id');
            const deductionPercentage = parseFloat(container.getAttribute('data-question-score'));

           
            const noRadio = container.querySelector(`input[type=radio][value="0"]`);

            if (noRadio && noRadio.checked) {
                totalDeductionAmount += (totalScore * (deductionPercentage / 100));
            }
        });

        const finalScore = totalScore - totalDeductionAmount;

       
        document.querySelector('#currentValue').textContent = finalScore.toFixed(2);
        document.querySelector('#totalScore').value = finalScore.toFixed(2);
    }

   
    radioElements.forEach(radio => {
        radio.addEventListener('change', calcularPontuacao);
    });

   
    deductionContainers.forEach(container => {
        container.querySelectorAll('input[type=radio]').forEach(radio => {
            radio.addEventListener('change', calcularPontuacao);
        });
    });

    
    calcularPontuacao();
});
