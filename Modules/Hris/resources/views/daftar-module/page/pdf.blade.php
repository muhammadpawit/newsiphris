<!DOCTYPE html>
<html>
<head>
    <title>Daftar Module</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="text-center">Daftar Module Aplikasi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Module</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->url }}</td>
                <td>{{ $item->icon }}</td>
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>