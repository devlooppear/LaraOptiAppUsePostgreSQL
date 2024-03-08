<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ucfirst($actionType) }} Reservation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 3em 0;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: -1px 3px 16px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5em;
            margin: 10px auto;
        }

        h2 {
            color: #343a40;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        li strong {
            font-weight: bold;
            margin-right: 10px;
        }

        p {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h2 class="mb-4"><strong>{{ ucfirst($actionType) }} Reservation</strong></h2>

                    <p>A reservation was (Uma reserva foi) {{ $actionType }}:</p>

                    <ul>
                        <li><strong>Reservation ID (Identificação da Reserva):</strong> {{ $reservationData['id'] }}
                        </li>
                        <li><strong>User (Usuário):</strong>
                            {{ isset($reservationData['user']['name']) ? $reservationData['user']['name'] : 'N/A (Não identificado)' }}
                        </li>
                        <li><strong>Book (Livro):</strong>
                            {{ isset($reservationData['book']['title']) ? $reservationData['book']['title'] : 'N/A (Não identificado)' }}
                        </li>
                        <li><strong>Reservation Date (Data da Reserva):</strong>
                            {{ \Carbon\Carbon::parse($reservationData['reservation_date'])->format('d/m/Y H:i:s') }}
                        </li>
                        <li><strong>Is Active (Está Ativa?):</strong>
                            {{ $reservationData['is_active'] ? 'Sim' : 'Não' }}</li>
                    </ul>

                    <p class="mt-4">Thank you for using our application! (Obrigado por usar nossa aplicação!)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
