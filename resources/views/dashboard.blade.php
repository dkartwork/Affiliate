<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบสมาชิก</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>ระบบสมาชิก</h1>
        @php
            $totalBonus = array_sum($sale['bonus']);
            $subtotalBonus = array_sum($subsale['bonus']);
            $sumBonus = $totalBonus + $subtotalBonus;
        @endphp
        <table class="table table-striped">
            <thead>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>ลิงค์ Tier</th>
                <th>โบนัส</th>
                <th>จัดการ</th>
            </thead>
            <tbody>
                <td>{{$data->name}}</td>
                <td>{{$data->email}}</td>
                <td id="{{$data->id}}" onclick="copyText(this)" class="text-decoration-underline">{{url('/').'/registration?code='.$data->user_code}}</td>
                <td>{{ $sumBonus }}</td>
                <td><a href="logout" class="btn btn-success">Logout</a></td>
            </tbody>
        </table>
        <h3>ลูกทีม</h3>
        @if($totalBonus > 0)
            <table class="table table-striped">
                <thead>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>ซื้อ</th>
                    <th>ผลกำไร</th>
                </thead>
                @foreach($sale['buy'] as $index => $value)
                <tbody>
                    <td>{{ $sale['user'][$index]->name }}</td>
                    <td>{{ $sale['user'][$index]->email }}</td>
                    <td>{{ $value->price }}</td>
                    <td>{{ $sale['bonus'][$index] }}</td>  
                </tbody>
                @endforeach
            </table>     
        @else
            <p>No data available</p>
        @endif
        
        <h4>ลูกทีม2</h4>
        @if($subtotalBonus > 0)
            <table class="table table-striped">
                <thead>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>ซื้อ</th>
                    <th>ผลกำไร</th>
                </thead>
                @foreach($subsale['buy'] as $index => $value)
                    @if($subsale['user'][$index])
                    <tbody>
                        <td>{{ $subsale['user'][$index]->name }}</td>
                        <td>{{ $subsale['user'][$index]->email }}</td>
                        <td>{{ $value->price }}</td>
                        <td>{{ $subsale['bonus'][$index] }}</td>  
                    </tbody>
                    @endif
                @endforeach
            </table>     
        @else
            <p>No data available</p>
        @endif
        <div class="m-3"><a href="/products">สินค้าสมาชิก</a></div>
    </div>
</body>
    <script>
        function copyText(tdElement) {
            // สร้าง range และเลือกข้อความจาก innerText ของ td
            var range = document.createRange();
            range.selectNodeContents(tdElement);  // ใช้ selectNodeContents เพื่อเลือกข้อความภายใน <td>

            // ทำให้ข้อความที่เลือกสามารถคัดลอกได้
            window.getSelection().removeAllRanges();  // ล้างการเลือกเดิม
            window.getSelection().addRange(range);    // เพิ่มการเลือกใหม่

            // คัดลอกข้อความไปยังคลิปบอร์ด
            document.execCommand("copy");

            // แจ้งเตือนผู้ใช้ว่าได้คัดลอกข้อความแล้ว
            alert("Copied the text: " + tdElement.innerText);
        }
    </script>
</html>
