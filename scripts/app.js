$(document).ready(function () {
    // Fetching Required data from the server
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


        scoreData.forEach(doctor => {
            const row = `<tr>
                            <td>${doctor.name}</td>
                            <td>${getScoreCell(doctor.punctuality_score)}</td>
                            <td>${getScoreCell(doctor.revenue_score)}</td>
                            <td>${getScoreCell(doctor.satisfaction_score)}</td>
                            <td>${getScoreCell(doctor.overall_average)} ${getArrowIndicator(parseFloat(doctor.overall_average), parseFloat(doctor.previous_average))}</td>
                        </tr>`;

            scorecardBody.append(row);
        });

        // Fetching dropdown menu values from database (When Updating)

        const doctorsUpdateDropdown = $('#doctor');
        scoreData.forEach(doctor => {
            const option = `<option value="${doctor.id}">${doctor.name}</option>`;
            doctorsUpdateDropdown.append(option);
        });

        const doctorsDropdown = $('#Idoctor');
        scoreData.forEach(doctor => {
            const option = `<option value="${doctor.id}">${doctor.name}</option>`;
            doctorsDropdown.append(option);
        });

        // Done

        const doctors = scoreData.map(doctor => doctor.name);
        const punctualityScores = scoreData.map(doctor => doctor.punctuality_score);
        const revenueScores = scoreData.map(doctor => doctor.revenue_score);
        const satisfactionScores = scoreData.map(doctor => doctor.satisfaction_score);

        const ctx = document.getElementById('score-graph').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: doctors,
                datasets: [
                    {
                        label: 'Punctuality',
                        data: punctualityScores,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    },
                    {
                        label: 'Revenue',
                        data: revenueScores,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)'
                    },
                    {
                        label: 'Satisfiability',
                        data: satisfactionScores,
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
                            display: true
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

    // Done Fetching data from the server's database




    // Updating Scores to the database
    $('#update-scores-form').submit(function (event) {
        event.preventDefault();
        const doctorId = $('#doctor').val();
        const punctualityScore = $('#punctuality').val();
        const revenueScore = $('#revenue').val();
        const satisfiabilityScore = $('#satisfiability').val();

        $.post('./crud/updateScores.php', { doctorId, punctualityScore, revenueScore, satisfiabilityScore }, function (data) {
            console.log('Received data:', data);
            const response = JSON.parse(data);
            alert(response.message);
            location.reload();
        });
    });

    // Done updating scores to the database


    // Creating new facilities to the database
    $('#add-doctor-form').submit(function (event) {
        event.preventDefault();
        const doctorName = $('#doctorName').val();

        $.post('./crud/addDoctor.php', { doctorName }, function (data) {
            const response = JSON.parse(data);
            alert(response.message);
            // location.reload();
            // $('#add-doctor-form').
        });
        location.reload();
    });
    // Done creating facilities to the database


    // Deleting a doctor Scores to the database
    $('#delete-doctor-form').submit(function (event) {
        event.preventDefault();
        const doctorId = $('#Idoctor').val();

        $.post('./crud/deleteDoctor.php', {doctorId}, function (data) {
            console.log('Received data:', data);
            const response = JSON.parse(data);
            alert(response.message);
            location.reload();
        });
    });

    // Done updating scores to the database

    
    // Updating colors for CSS
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
    // Done updating colors
});
