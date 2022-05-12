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
            padding: 3px 0;
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



          ul li {
            box-sizing: border-box;
            list-style: none;
            font-size: 12px;
            margin: 10px 0;
            padding: 0 5px;
            padding-bottom: 2px;
            border: 1px solid #f2f2f2;
          }

          ul li span {
            font-size: 11px;
            border-color: #e5e5ed !important;
            margin: 0 !important;
            padding: 0;
            border: 1px solid #aaa;

          }
          ul li span:nth-child(even) {
            background-color: #efefef;
          }
        </style>



    </head>
    <body>

<div id="main-wrapper">
    <div class="content-body">
      <div class="container-fluid analiz-wrapper">

        <div class="row" style="text-align: center;font-size: 36px; font-weight: bold;">
          <span>CEVAP ANAHTARI</span>
        </div>
        <div class="row" style="text-align: center;margin-bottom: 20px;font-size: 12px;">
          <span>{{$deneme->deneme_name}}</span> <span>({{$deneme->deneme_type}})</span>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">

                <div class="card-body">
                  <div class="table-responsive">

                    <h3 style="margin-left: 30px;">A KİTAPÇIĞI</h3>

                    @php
                      $s_no = 1;
                      $s_no2 = 1;
                    @endphp

                  <ul>
                    @foreach($answer as $item)
                      @php
                        if ($s_no == $item->soru_no) { }
                        else { $s_no = 1; }
                      @endphp

                      @if ($s_no == 1)
                        <li>
                          <b>{{$item->field}}:</b>

                          @foreach($answer as $i)
                            @php
                              if ($s_no2 == $i->soru_no) {}
                              else {
                                $s_no2 = 1;
                              }

                            @endphp

                              @if($item->field == $i->field)
                                <span>{{$s_no2}}-{{$i->answer}}</span>
                              @endif

                            @php
                              $s_no2++;
                            @endphp
                          @endforeach
                        </li>
                      @endif

                      @php
                        $s_no++;
                      @endphp
                    @endforeach
                  </ul>

                  </div>
              </div>


            </div>
          </div>
        </div>

        @if($answer[0]->b_karsiligi)
        <div class="row">
          <div class="col-12">
            <div class="card">

                <div class="card-body">
                  <div class="table-responsive">

                    <h3 style="margin-left: 30px;">B KİTAPÇIĞI</h3>

                    @php
                      $s_no = 1;
                      $s_no2 = 1;
                    @endphp

                  <ul>
                    @foreach($answer as $item)
                      @php
                        if ($s_no == $item->soru_no) { }
                        else { $s_no = 1; }
                      @endphp

                      @if ($s_no == 1)
                        <li>
                          <b>{{$item->field}}:</b>

                          @foreach($answer as $i)
                            @php
                              if ($s_no2 == $i->soru_no) {}
                              else {
                                $s_no2 = 1;
                              }

                            @endphp

                              @if($item->field == $i->field)
                                <span>{{$i->b_karsiligi}}-{{$i->answer}}</span>
                              @endif

                            @php
                              $s_no2++;
                            @endphp
                          @endforeach
                        </li>
                      @endif

                      @php
                        $s_no++;
                      @endphp
                    @endforeach
                  </ul>

                  </div>
              </div>


            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

</div>


</body>
</html>
