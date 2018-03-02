<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>Vehikl Parking Ticket</h1>

    <p>A parking space as become available. Please use the following infomation to enter the parking lot:</p>
    <p>
        Ticket number: {{ $ticket_number }}<br>
        PIN: {{ $pin }}
    </p>
    <p>If you no longer need the parking space please
        <a href="http://parking.mattcormier.com/waitlist/cancel?ticket_number={{ $ticket_number }}&pin={{ $pin }}"> click here.</a>
    </p>

</body>
</html>