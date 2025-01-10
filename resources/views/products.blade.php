<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้าสมาชิก</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>สินค้า</h1>
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        @if (Session::has('fail'))
            <div class="alert alert-danger">
                {{Session::get('fail')}}
            </div>
        @endif
        @if(!empty($products))
            <table class="table table-striped">
                <thead>
                    <th>รหัส</th>
                    <th>สินค้า</th>
                    <th>ราคา</th>
                    <th>จัดการ</th>
                </thead>
            @foreach($products as $item)
                <tbody>
                    <td>{{$item['code']}}</td>
                    <td>{{$item['name']}}</td>
                    <td>{{number_format($item['price'])}} บาท</td>
                    <td><a href="/buy?code={{$item['code']}}" class="btn btn-success">สั่งซิ้อ</a></td>
                </tbody>
            @endforeach
            </table>
        @else
            <p>No data available</p>
        @endif
        <div class="m-3"><a href="/dashboard">Dashboard</a></div>
    </div>
</body>
</html>
