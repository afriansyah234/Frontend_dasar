<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Data dari API</title>
</head>
<body>
    <h1>Daftar Postingan (dari API)</h1>

    @if(empty($siswa))
        <p>Tidak ada data.</p>
    @else
        <ul>
            @foreach($siswa as $s)
                <li>
                    <h3>{{ $s['nama'] }}</h3>
                    <p>{{ $s['kelas'] }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
