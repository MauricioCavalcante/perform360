document.addEventListener("DOMContentLoaded", function() {
    var container = document.getElementById("container");

    if (container) {
        try {
            // Parse os dados JSON do atributo data-chart-data
            var data = JSON.parse(container.getAttribute("data-chart-data"));
            console.log("Dados carregados:", data);

            // Crie o gráfico Highcharts
            Highcharts.chart("container", {
                chart: {
                    type: "pie"
                },
                title: {
                    align: "left",
                    text: "Quantidade de avaliações por cliente"
                },
                xAxis: {
                    type: "category",
                    title: {
                        text: "Cliente"
                    }
                },
                yAxis: {
                    title: {
                        text: "Número de Avaliações"
                    }
                },
                series: [{
                    name: "Avaliações",
                    colorByPoint: true,
                    data: data
                }],
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> avaliações<br/>'
                }
            });
        } catch (e) {
            console.error('Erro ao analisar JSON:', e);
        }
    } else {
        console.error('Elemento com id "container" não encontrado.');
    }
});


document.addEventListener("DOMContentLoaded", function() {
    var historyElement = document.getElementById("history");

    if (historyElement) {
        try {
            // Parse os dados JSON do atributo data-chart-data
            var data = historyElement.getAttribute("data-chart-data");
            var [generalAverageDataJson, clientAverageDataJson] = data.split('|');
            var generalAverageData = JSON.parse(generalAverageDataJson);
            var clientAverageData = JSON.parse(clientAverageDataJson);

            console.log("Dados carregados:", { generalAverageData, clientAverageData });

            // Crie o gráfico Highcharts
            Highcharts.chart('history', {
                title: {
                    text: 'Average Scores Over Time',
                    align: 'left'
                },
                subtitle: {
                    text: 'Comparing General Averages and Client-specific Averages',
                    align: 'left'
                },
                yAxis: {
                    title: {
                        text: 'Average Score'
                    }
                },
                xAxis: {
                    categories: generalAverageData.map(item => item.name), // Definir categorias com base no mês
                    title: {
                        text: 'Month'
                    },
                    tickmarkPlacement: 'on',
                    labels: {
                        rotation: -45
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                        // Não é necessário definir pointStart para gráficos com dados categóricos
                    }
                },
                series: [
                    {
                        name: 'Average General',
                        data: generalAverageData.map(item => item.y)
                    },
                    ...clientAverageData.map(client => ({
                        name: client.name,
                        data: client.data.map(item => item.y)
                    }))
                ],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        } catch (e) {
            console.error('Erro ao analisar JSON:', e);
        }
    } else {
        console.error('Elemento com id "history" não encontrado.');
    }
});




