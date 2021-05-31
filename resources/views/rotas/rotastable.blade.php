<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">

    <style type="text/css">
        .text-white { color: #fff; }
        table { width: 97%; }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th,
        td {
            padding: 15px;
            text-align: left;
        }
        #t01 tr:nth-child(even) {
            background-color: #eee;
        }
        #t01 tr:nth-child(odd) {
            background-color: #fff;
        }
        #t01 th {
            background-color: #051C4B;
            color: white;
            font-size: 13px;
        }

    </style>
</head>

<body class="overflow-x-hidden">

    <div class="container" id="boxes">
        <div id="app" class="content">
            <div style="width:1000px;margin-left: auto;margin-right: auto; background-color: #dddddd26; height: 98vh;">
                <div style="background: #051C4B; padding: 20px 0;">
                    <center><img src="{{ $logo_path }}" style="max-width: 150px" /></center>                                   
                </div>


                <table id="t01" style="margin: 20px 15px;">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            @foreach ($week_date_formate as $date)
                                <th>{{ $date }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($users_name))
                            @foreach ($users_name as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[0], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[1], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[2], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[3], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[4], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[5], $item['id']) !!}</td>
                                <td>{!! \App\Rotas::getdaterotas($week_date[6], $item['id']) !!}</td>
                            </tr>
                            @endforeach
                        @else 
                            <tr> <td colspan="8"> <h2> <center> {{ __('No Data Found') }}  </center> </h2> </td> </tr>
                        @endif
                    </tbody>                                    
                </table>
            </div>                        
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost/posgo/main/saas/main_file/js/html2pdf.bundle.min.js"></script>

    <script>
        function closeScript() {
            setTimeout(function () {
                window.history.back();
                //window.open(window.location, '_self').close();
            }, 1000);
        }

        $(window).on('load', function () {
            var element = document.getElementById('boxes');
            var opt = {
                filename: '#Rotas00010',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A3'}
            };

            html2pdf().set(opt).from(element).save().then(closeScript);
        });

    </script>
</body>

</html>
