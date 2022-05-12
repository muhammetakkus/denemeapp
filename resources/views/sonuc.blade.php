<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
          body { font-family: DejaVu Sans, sans-serif !important; }

          table {
            text-align: center !important;
            border-collapse: collapse;
            width: 100%;
          }
          table, th, td {
            border: 1px solid #dadabb !important;
          }
          table tbody {
            color: #222 !important;
            font-size: 11px !important;
          }
          table tbody tr td  {
            padding: 6px 0;
          }
          table thead th {
            vertical-align: middle !important;
          }
          table thead {
            background: #137866;
            color: #fff !important;
            word-wrap: break-word !important;
            font-size: 12px !important;
          }
          table tbody tr td , table thead th, table thead th p { word-wrap: break-word !important;}
          table tbody tr td , table thead th {
            border-color: #d5d5ed !important;
          }

          .page-break {
              page-break-after: always;
          }

          table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
          }

          .dybn , .tdybn {

          }
          .dybn.d {
            position: absolute;
            top: 0;
            left: 12px;
          }
          .dybn.y {
            position: absolute;
            top: 0;
            left: 32px;
          }
          .dybn.b {
            position: absolute;
            top: 0;
            left: 58px;
          }
          .dybn.n {
            position: absolute;
            top: 0;
            left: 78px;
          }


          .tdybn.ss {
            position: absolute;
            top: 0;
            left: 15px;
          }
          .tdybn.d {
            position: absolute;
            top: 0;
            left: 50px;
          }
          .tdybn.y {
            position: absolute;
            top: 0;
            left: 78px;
          }
          .tdybn.b {
            position: absolute;
            top: 0;
            left: 108px;
          }
          .tdybn.n {
            position: absolute;
            top: 0;
            left: 130px;
          }
        </style>



    </head>
    <body>

<div id="main-wrapper">
    <div class="content-body">
      <div class="container-fluid analiz-wrapper">

        <span style="position: absolute; top: -20px; right: 10px;font-size: 13px;"><b>Sınav Tarihi:</b> {{$deneme->uygulama_tarihi}}</span>

        <div class="row" style="text-align: center;font-size: 36px; font-weight: bold;">
          <span>{{$user->kurum_name}}</span>
        </div>
        <div class="row" style="text-align: center;margin-bottom: 20px;font-size: 12px;">
          <span>{{$deneme->deneme_name}}</span> <span>({{$deneme->deneme_type}})</span> NETİCELER
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">

                <div class="card-body">
                  <div class="table-responsive">


                    <table id="my-table" class="table table-primary">
                      <thead class="thead-primary">
                            <th>NO</th>
                            <th>İSİM SOYİSİM</th>

                            @foreach($sonuc[0]->neticeler as $ders)
                            <th>
                              <p>{{$ders->ders_name}}</p>
                              <p class="d-y-b-n">
                                <span> D </span>
                                <span> Y </span>
                                <span> B </span>
                                <span> N </span>
                              </p>
                            </th>
                            @endforeach

                            <th>
                              <p>TOPLAM</p>
                              <p class="d-y-b-n">
                                <span> SS </span>
                                <span> D </span>
                                <span style="margin-left: 4px !important;"> Y </span>
                                <span style="margin-left: 8px !important;"> B </span>
                                <span style="margin-left: 12px !important;"> N </span>
                              </p>
                            </th>

                      </thead>
                      <tbody>
                          @foreach($sonuc as $item)
                          <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$item->student_name}}</td>

                            @foreach($sonuc[$loop->index]->neticeler as $netice)
                            <td>
                              <div style="position: relative;">
                                <span class="dybn d">{{$netice->d}}</span>
                                <span class="dybn y">{{$netice->y}}</span>
                                <span class="dybn b">{{$netice->b}}</span>
                                <span class="dybn n">{{$netice->n}}</span>
                                <p style="clear:both;"></p>
                              </div>

                            </td>
                            @endforeach

                            @foreach($sonuc[$loop->index]->toplam as $toplam)
                            <td>
                              <div style="position: relative;">
                                <span class="tdybn ss">{{$toplam->ss}}</span>
                                <span class="tdybn d">{{$toplam->d}}</span>
                                <span class="tdybn y">{{$toplam->y}}</span>
                                <span class="tdybn b">{{$toplam->b}}</span>
                                <span class="tdybn n">{{$toplam->n}}</span>
                                <p style="clear:both;"></p>
                            </div>
                            </td>
                            @endforeach

                          </tr>
                          @endforeach
                      </tbody>
                  </table>

                  </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>

</div>


</body>
</html>
