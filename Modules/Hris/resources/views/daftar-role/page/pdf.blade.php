<!DOCTYPE html>
<html>
<head>
    <title>Daftar Role</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="text-center">Daftar Role</h2>
    <table>
        <thead>
            <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Nama Role</th>
                            <th>Guard</th>
                            <th>Created At</th>
                        </tr>
        </thead>
        <tbody>
            @foreach($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->guard_name }}</td>
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>