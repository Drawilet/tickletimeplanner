<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <header>
        <h1>TickleTime Planner Contact Alert</h1>
    </header>

    <main>
        <p>
            <strong>Name:</strong> {{ $data['name'] }}<br />
            <strong>Email:</strong> {{ $data['email'] }}<br />
            <strong>Message:</strong> {{ $data['message'] }}
        </p>
    </main>
</body>

</html>
