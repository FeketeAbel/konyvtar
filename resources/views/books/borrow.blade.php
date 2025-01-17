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
        th, td {
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
    <h1>Könyvek listája</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Cím</th>
                <th>Szerző</th>
                <th>Kategória</th>
                <th>Elérhető</th>
                <th>Kölcsönzés</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr id="book-{{ $book->id }}">
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td id="availability-{{ $book->id }}">{{ $book->available ? 'Igen' : 'Nem' }}</td>
                    <td>
                        @if (!$book->available && $book->borrowings->where('user_id', auth()->id())->whereNull('end_date')->count())
                            <form action="{{ route('books.return', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit">Visszaadás</button>
                            </form>
                        @elseif ($book->available)
                            <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit">Kölcsönzés</button>
                            </form>
                        @else
                            <span>Nem elérhető</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
