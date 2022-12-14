<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Convocation;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use function PHPUnit\Framework\returnArgument;
use File;
use QrCode;
class StudentApiController extends Controller
{
    public function index(Request $request)
    {
       // abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->query('api_key') !== env('Certificate_API_KEY') || $request->query('secret_key') !== env('Certificate_SECRET_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return new StudentResource(Student::with(['faculty', 'program', 'convocation'])->get());
    }

    public function store(StoreStudentRequest $request)
    {
        if ($request->api_key !== env('Certificate_API_KEY') || $request->secret_key !== env('Certificate_SECRET_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $data = $request->all();
        $slNo =  hash('crc32b',$data['serial_no']);
       // Pdf::loadView('admin.students.certificate')->setPaper('a4', 'landscape')->save(public_path().'/certificate/my_stored_file.pdf')->stream('download.pdf');
        $folderPath = $this->makeFolder('certificate');
        $url = $folderPath['uploadPath'].'/'.$slNo.".pdf";
        $db_url = $folderPath['dbPath'].'/'. $slNo.".pdf";
$qc_url = url($db_url);

        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($qc_url));

        if ($data['convocation_id']==9){
            $convocation = Convocation::findOrFail(9);
            Pdf::loadView('admin.students.certificate.nine',compact('qrcode','data','convocation'))->setPaper('a4', 'landscape')->save($url)->stream($url);
        }

        $fileHash = hash_file('sha256', $url);
        $data['hash_code']=$fileHash;
        $data['certificate_url']=$db_url;
        // call to api
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://194.233.78.140:8080/certificate-verification',
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
        $blockChainResponse  =  json_decode($response);
        $res =  (Array)$blockChainResponse;
        if ($res['success']==1){
            $student = Student::create($data);
            $result['message']=true;
            $result['certificate_url']= url($db_url);

        }else{
            $result['message']=true;
            $result['certificate_url']= null;

        }
        return $result;
//        return (new StudentResource($student))
//            ->response()
//            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Student $student)
    {
        //abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource($student->load(['faculty', 'program', 'convocation']));
    }
    public function studentResult($hash_code)
    {
        $student = Student::where('hash_code',$hash_code)->first(['name','serial_no','cgpa','result_published_date','student_id_no']);

        if ($student){
            return response()->json([
                "result" => (object)$student,
                "status"=>true
            ],200);
        }else{
            return response()->json([
                "result" => (object)$student,
                "status"=>false
            ],404);
        }
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


    //create file directory related functionality
    public function makeFolder($path){
        $year_path = public_path($path.'/'.date('Y'));
        $dbPath = $path.'/'.date('Y');
        if (File::exists($year_path)) {
            if (File::exists($year_path.'/'.date('m'))){
                $uploadPath = $year_path.'/'.date('m');
                $dbPath = $dbPath.'/'.date('m');
            }else{
                $month_path =$year_path.'/'.date('m');
                if (!File::makeDirectory($month_path, 0777, true)) {
                    die('Failed to create folders...');
                }
                $uploadPath = $month_path;
                $dbPath = $dbPath.'/'.date('m');
            }
        }else{
            if (!File::makeDirectory($year_path, 0777, true)) {
                die('Failed to create folders...');
            }
            $month_path =$year_path.'/'.date('m');
            if (!File::makeDirectory($month_path, 0777, true)) {
                die('Failed to create folders...');
            }
            $uploadPath = $month_path;
            $dbPath = $dbPath.'/'.date('m');
        }
        $data['uploadPath']=$uploadPath;
        $data['dbPath']=$dbPath;
        return $data;
    }

}
