<style type="text/css">


@font-face {
        font-family: 'serial_no';
        src: url('{{"fonts/micrenc.ttf"}}') format('truetype');
    }
@font-face {
        font-family: 'faculty';
        src: url('{{"fonts/OldEnglishFive.ttf"}}') format('truetype');
    }
    @font-face {
        font-family: 'name';
        font-style: normal;
        font-weight: 700;
        {{--src: url('{{"fonts/zai_CalligraphyScriptHandwritten.ttf"}}') format('truetype');--}}
        src: url('{{"fonts/ENGLISHW.TTF"}}') format('truetype');


    }
@font-face {
        font-family: 'program';
        src: url('{{"fonts/OPTICoyonetBold.otf"}}') format('truetype');

    }
@font-face {
        font-family: 'normaltext';
        src: url('{{"fonts/Amurg-Regular.otf"}}') format('truetype');

    }
@font-face {
        font-family: 'student_id_no';
        {{--src: url('{{"fonts/Grafipaint.ttf"}}') format('truetype');--}}
  {{--src: url('{{"fonts/GreatVibes-Regular.ttf"}}') format('truetype');--}}
  src: url('{{"fonts/MeieScript-Regular.ttf"}}') format('truetype');
    }
    @page {
        margin: 0cm 0cm;
        size: 16.70cm 22.28cm landscape;
    }
    body {
        margin-top:    0cm;
        margin-bottom: 0cm;
        margin-left:   0cm;
        margin-right:  0cm;
    }
    #watermark {
        position: fixed;
        top:   0px;
        left:     0px;
        width:    842px;
        height:   631px;
        z-index:  -1000;
        background-image: url("img/9th.jpg");
{{--        background-image: url("{{ url('img/9th.jpg') }}");--}}
        background-size: cover;
    }

    table{width: 100%}
    .container{border: 0px;width: 100%;  margin: 0 auto; padding: 23px}
    .row{float: left; width: 100%}
    .col-1{width: 100%; float: left; padding: 0px; margin: 0px;}
    .col-2{width:50%; float: left; padding: 0px; margin: 0px}

    td{padding: 20px 0px}
    .serial_no{ padding-top: 4px; padding-left: 682px; font-size: 17px; line-height: 25px; font-family:'serial_no';}
    .qr-code{ padding-top: 4px; padding-left: 685px;}
    .faculty{ padding-top: 70px; text-align: center; padding-left: 32px;  font-size: 14.3px; font-family:'faculty';}
    .program-without-major{ padding-top: 90px; padding-bottom: 12px; text-align: center; line-height: 25px; font-size: 30px;  font-family: 'program'}
    .program-with-major{ padding-top:80px;  text-align: center; line-height: 17px; font-size: 30px;  font-family: 'program'}
    .major{ padding-top: 6px; margin-top: -20px;  text-align: center; line-height: 18px; font-size: 30px;  font-family: 'program'}
    .name{ font-weight: bold; padding-top: 19px; text-align: center; line-height: 36px; font-size: 42px; letter-spacing: -2px; font-family: 'name';}
    .student_id_no{ margin-top: 0px; text-align: center; line-height: 17px; font-size: 45px; font-family: 'student_id_no';}
    .day-month{ padding-top: 18px; padding-left: 200px; font-size: 15px; text-transform: uppercase;}
    .year{ padding-top: 18px; padding-left: 110px; font-size: 15px; text-transform: uppercase}
 .cgpa{ padding-top: 7px; padding-left: 140px; font-size: 18px}
    .published{ padding-top: 7px; padding-left: 110px; font-size: 18px}
.normal-text{
    font-family: 'normaltext';
}

</style>
<div id="watermark">
<table class="container">
    <tr class="row">
        <td class="col-1">
            <table>
                <tr class="row">
                    <td  colspan="2" class="col-1 serial_no">
                        {{ $data['serial_no'] }}
                    </td>
                </tr>

                <tr class="row">
                    <td  colspan="2" class="col-1 qr-code">
                        <img src="data:image/png;base64, {!! $qrcode !!}">
                    </td>
                </tr>
                <tr class="row">
                    <td colspan="2" class="col-1 faculty">
                       {{ $data['faculty_name'] }}
                    </td>
                </tr>

                @if($data['major']!=null)
                    <tr class="row">
                        <td colspan="2" class="col-1 program-with-major">
                            {{ $data['program_name'] }}
                        </td>
                    </tr>
                <tr class="row">
                        <td colspan="2" class="col-1 major">
                            {{ $data['major'] }}
                        </td>
                </tr>

                @else
                    <tr class="row">
                            <td colspan="2" class="col-1 program-without-major">
                                {{ $data['program_name'] }}
                            </td>
                    </tr>
                @endif
                <tr class="row">
                    <td colspan="2" class="col-1 name">
                        {{ $data['name'] }}
                    </td>
                </tr>
                <tr class="row">
                    <td colspan="2" class="col-1 student_id_no">
                       &nbsp;   &nbsp;{{ $data['student_id_no'] }}
                    </td>
                </tr>
                <tr class="row">
                    <td class="col-2 day-month normal-text">
                        {{ $data['certificate_generate_day_month'] }}
                    </td>
                    <td class="col-2 year normal-text">
                        {{ $data['certificate_generate_year'] }}
                    </td>
                </tr>
                <tr class="row">
                    <td class="col-2 cgpa normal-text">
                        {{ $data['cgpa'] }}
                    </td>
                    <td class="col-2 published normal-text">
                        {{ $data['result_published_date'] }}
                    </td>
                </tr>
            </table>
        </td>

    </tr>
</table>
</div>
