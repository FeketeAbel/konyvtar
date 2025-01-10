<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvek listája</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th,td {
            border: 1px solid black;
            padding: 10px;
            font-size: 18px;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Kölcsönözhető könyvek</h1>
    <table>
        <thead>
            <tr>
                <th>Cím</th>
                <th>Szerző</th>
                <th>Kategória</th>
                <th>Elérhető</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->available ? 'Igen' : 'Nem' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>