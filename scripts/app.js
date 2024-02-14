$(document).ready(function () {
    $.get('./crud/fetchData.php', function (data) {
        const scorecardBody = $('#scorecard-body');
        const scoreData = JSON.parse(data);

        function getArrowIndicator(current, previous) {
            if (current > previous) {
                return '<span class="trend-indicator increase">&#9650;</span>';
            } else if (current < previous) {
                return '<span class="trend-indicator decrease">&#9660;</span>';
            } else {
                return '<span class="trend-indicator">&#9654;</span>'; // Stagnant indicator
            }
        }

        // scoreData.forEach(sibling => {
        //     const previousOverallAvg = parseFloat(sibling.previous_overall_average); // Use the correct field
        //     const row = `<tr>
        //         <td>${sibling.name}</td>
        //         <td>${getScoreCell(sibling.punctuality_score)}</td>
        //         <td>${getScoreCell(sibling.eating_score)}</td>
        //         <td>${getScoreCell(sibling.homework_score)}</td>
        //         <td>${getScoreCell(sibling.overall_average)} ${getArrowIndicator(parseFloat(sibling.overall_average), previousOverallAvg)}</td>
        //     </tr>`;
        //     scorecardBody.append(row);
        // });

        scoreData.forEach(sibling => {
            const row = `<tr>
<td>${sibling.name}</td>
<td>${getScoreCell(sibling.punctuality_score)}</td>
<td>${getScoreCell(sibling.eating_score)}</td>
<td>${getScoreCell(sibling.homework_score)}</td>
<td>${getScoreCell(sibling.overall_average)} ${getArrowIndicator(parseFloat(sibling.overall_average), parseFloat(sibling.previous_average))}</td>
</tr>`;
            scorecardBody.append(row);
        });

        const siblingsDropdown = $('#sibling');
        scoreData.forEach(sibling => {
            const option = `<option value="${sibling.id}">${sibling.name}</option>`;
            siblingsDropdown.append(option);
        });

        const siblings = scoreData.map(sibling => sibling.name);
        const punctualityScores = scoreData.map(sibling => sibling.punctuality_score);
        const eatingScores = scoreData.map(sibling => sibling.eating_score);
        const homeworkScores = scoreData.map(sibling => sibling.homework_score);

        const ctx = document.getElementById('score-graph').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: siblings,
                datasets: [
                    {
                        label: 'Punctuality',
                        data: punctualityScores,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    },
                    {
                        label: 'Eating',
                        data: eatingScores,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)'
                    },
                    {
                        label: 'Homework',
                        data: homeworkScores,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                    }
                ]
            },
            options: {
                responsive: true, // This makes the chart responsive to its container
                maintainAspectRatio: true,
                aspectRatio: 3,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },

                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                indexAxis: 'x', // Display data vertically
                elements: {
                    bar: {
                        barPercentage: 0.1, // Adjust the width of individual bars
                        categoryPercentage: 0.9 // Adjust the space between bars
                    }
                }



            }
        });
    });

    $('#update-scores-form').submit(function (event) {
        event.preventDefault();
        const siblingId = $('#sibling').val();
        const punctualityScore = $('#punctuality').val();
        const eatingScore = $('#eating').val();
        const homeworkScore = $('#homework').val();

        $.post('./crud/updateScores.php', { siblingId, punctualityScore, eatingScore, homeworkScore }, function (data) {
            console.log('Received data:', data);
            const response = JSON.parse(data);
            alert(response.message);
            location.reload();
        });
    });

    $('#add-sibling-form').submit(function (event) {
        event.preventDefault();
        const siblingName = $('#siblingName').val();

        $.post('./crud/addSibling.php', { siblingName }, function (data) {
            const response = JSON.parse(data);
            alert(response.message);
            location.reload();
        });
    });

    function getScoreCell(score) {
        let colorClass = '';
        if (score >= 80) {
            colorClass = 'excellent';
        } else if (score >= 50) {
            colorClass = 'fair';
        } else {
            colorClass = 'poor';
        }
        return `<span class="${colorClass}">${score}</span>`;
    }
});
