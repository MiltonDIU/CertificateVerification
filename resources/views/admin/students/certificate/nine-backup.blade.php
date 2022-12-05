<style>
    @page {
        margin: 0cm 0cm;
        size: 15.75cm 22.28cm landscape;
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
        height:   595px;
        z-index:  -1000;
    }
    main{
        position: fixed;
        top:   0px;
        left:     0px;
        width:    842px;
        height:   595px;
    }
    .serial_no{ margin-top: 15px; margin-right: 45px; text-align: right; font-size: 14px}
    .faculty{ margin-top: 138px; text-align: center; font-size: 16px}
    .program{ margin-top: 100px; text-align: center; font-size: 16px}
    .name{ margin-top: 70px; text-align: center; font-size: 16px}
    .student_id{ margin-top: -12px; text-align: center; font-size: 16px}
    .certificate_generate_day_month{ margin-top: -5px; text-align: left; font-size: 16px; margin-left: 220px}
    .certificate_generate_year{ margin-top: -40px; text-align: right; font-size: 16px; margin-right: 100px}
    .cgpa{ margin-top: -40px; text-align: left; font-size: 13px; margin-left: 170px}
    .result_published_date{margin-top: -8px; text-align: right; font-size: 16px; margin-right: 191px}
    .exam_signature { width: 110px;
        float: left;
        margin-left: 75px;
        margin-top: -22px;
    }    .vc_signature {  width: 120px;
        float: right;
        margin-right: 75px;
        margin-top: -22px;
    }
</style>
<div id="watermark">
{{--        <img src="{{ url($convocation->certificate_design->getUrl()) }}" height="100%" width="100%"/>--}}
    <img src="storage/16/637b0c472daba_DIU-Main-Certificate_Blank-Format.jpg" height="100%" width="100%" />
</div>
<main>
{{--    <h2 class="serial_no">{{ $data->serial_no }}</h2>--}}
{{--    <h4 class="faculty">{{ $data->faculty->name }}</h4>--}}
{{--    <h4 class="program">{{ $data->program->name }}</h4>--}}
{{--    <h4 class="name">{{ $data->name }}</h4>--}}
{{--    <h4 class="student_id">{{ $data->student_id_no }}</h4>--}}
{{--    <h4 class="certificate_generate_day_month">{{ $data->certificate_generate_day_month }}</h4>--}}
{{--    <h4 class="certificate_generate_year">{{ $data->certificate_generate_year }}</h4>--}}
{{--    <h4 class="cgpa">{{ $data->cgpa }}</h4>--}}
{{--    <h4 class="out_of_cgpa">{{ $data->out_of_cgpa }}</h4>--}}
{{--    <h4 class="result_published_date">{{ $data->result_published_date }}</h4>   --}}
{{--    --}}
{{--    --}}

    <h2 class="serial_no">{{ $data['serial_no'] }}</h2>
    <h4 class="faculty">{{ $data['faculty_name'] }}</h4>
    <h4 class="program">{{ $data['program_name'] }}</h4>
    <h4 class="name">{{ $data['name'] }}</h4>
    <h4 class="student_id">{{ $data['student_id_no'] }}</h4>
    <h4 class="certificate_generate_day_month">{{ $data['certificate_generate_day_month'] }}</h4>
    <h4 class="certificate_generate_year">{{ $data['certificate_generate_year'] }}</h4>

    <h4 class="result_published_date">{{ $data['result_published_date'] }}</h4>
    <h4 class="cgpa">{{ $data['cgpa'] }}</h4>


{{--    <h2 style="margin-top: 7.4cm; text-align: center">{{$data['name']}}</h2>--}}
</main>
