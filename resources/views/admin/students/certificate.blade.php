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
</style>
<div id="watermark">
{{--    <img src="{{ url('img/Certificate.jpg') }}" height="100%" width="100%" />--}}
    <img src="img/Certificate.jpg" height="100%" width="100%" />
</div>
<main>
{{--    <h2 style="margin-top: 272px; text-align: center">{{$student['name']}}</h2>--}}
    <h2 style="margin-top: 7.4cm; text-align: center">{{$data['name']}}</h2>
</main>
