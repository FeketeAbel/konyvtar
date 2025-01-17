<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Könyvek listája</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

        tr:nth-child(even) {
            background-color: #eee;
        }
    </style>
</head>
<body>
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

    <h1 style="float: left;">Könyvek listája</h1>
    <a href="{{ route('books.back') }}" class="btn btn-primary" style="float: right;">Vissza a főmenübe</a>
    <table>
        <thead>
            <tr>
                <th>Cím</th>
                <th>Szerző</th>
                <th>Kategória</th>
                <th>Elérhető</th>
                <th>Kölcsönzés/Visszaadás</th>
                <th>Törlés</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr id="book-{{ $book->id }}">
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td id="availability-{{ $book->id }}">
                        {{ $book->available ? 'Igen' : 'Nem' }}
                    </td>
                    <td>
                        @php
                            $borrowed = $book->borrowings->where('user_id', auth()->id())->whereNull('end_date')->first();
                        @endphp

                        @if ($book->available)
                            <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Kölcsönzés</button>
                            </form>
                        @elseif ($borrowed)
                            <form action="{{ route('books.return', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">Visszaadás</button>
                            </form>
                        @else
                            <span>Nem elérhető</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Biztosan törölni szeretnéd ezt a könyvet?')">Törlés</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
