<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use function PHPUnit\Framework\returnArgument;

class StudentApiController extends Controller
{
    public function index()
    {
       // abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource(Student::with(['faculty', 'program', 'convocation'])->get());
    }

    public function store(StoreStudentRequest $request)
    {

$data = $request->all();
$data['hash_code']="dfhksdhkfsdfkdsdfdsfdskf";
$data['certificate_url']="google.com";

$slNo =  $data['serial_no'];

       // Pdf::loadView('admin.students.certificate')->setPaper('a4', 'landscape')->save(public_path().'/certificate/my_stored_file.pdf')->stream('download.pdf');
       $url = public_path()."/certificate/$slNo.pdf";
        Pdf::loadView('admin.students.certificate',compact('data'))->setPaper('a4', 'landscape')->save($url)->stream($url);
        $fileHash = hash_file('sha256', $url);
        $data['hash_code']=$fileHash;
        $data['certificate_url']=$url;

//
//
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'http://192.168.10.113:8080/certificate-verification',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//        ));
//        $response = curl_exec($curl);
//        curl_close($curl);
////        dd(( json_decode($response)));
//        return json_decode($response);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.10.113:8080/certificate-verification',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "hash_code":"'.$fileHash.'",
            "timestamp":987235023,
            "sender_name":"Milton"
}',
            CURLOPT_HTTPHEADER => array(
                'my_secret: test',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);
       // echo $response;
        return json_decode($response);
        $student = Student::create($data);
        return $fileHash;

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Student $student)
    {
        //abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource($student->load(['faculty', 'program', 'convocation']));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
