<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\Board;
class AttachmentsController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    public function store(Request $request) {
        /*
        * 1. 전송받은 파일을 지정된 폴더에 저장 - 폴더 지정
        * 2. 파일정보를 attachments 테이블에 저장
        * 3. 잘 저장 됬다는 결과를 클라이언트에 전송
        */
    	$attachment = null;
    	\Log::debug('AttachmentsController store', ['stpe'=>1]);
    	if($request->hasFile('file')) {
    		$file = $request->file('file');
             
            //file의 원래 name
    		$filename = /*str_random().*/filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
    		$bytes = $file->getSize();
            $user = \Auth::user();
            //경로는 public 이름은 files
            $path = public_path('files') . DIRECTORY_SEPARATOR .  $user->id;
            if (!File::isDirectory($path)) {
                //디렉토리 권한
                File::makeDirectory($path, 0777, true, true);
            }
            
    		$file->move($path, $filename);
        
    		$payload = [
    				'filename'=>$filename,
    				'bytes'=> $bytes,
    				'mime'=>$file->getClientMimeType()
    			];
    			
			$attachment =  Attachment::create($payload);
    	}
    	\Log::debug('AttachmentsController store', ['stpe'=>7]);
    	return response()->json($attachment, 200);
    }
    public function destroy(Request $request, $id) {
        $filename =  $request->filename;
        $attachment = Attachment::find($id);
        $attachment->deleteAttachedFile($filename);
        $attachment->delete();
        $user = \Auth::user();
        /*
        $path = public_path('files') . DIRECTORY_SEPARATOR .  $user->id . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        */
        return $filename;  
    }
}