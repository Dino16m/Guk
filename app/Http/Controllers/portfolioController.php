<?php

namespace App\Http\Controllers;
use App\portfolio;
use Illuminate\Http\Request;

class portofolioController extends Controller
{
    public function index(Request $request){
        $portfolio = portfolio::all()->get();
        
        if($request->ajax()|$request->wantsJson()){
            return response()->json(['portfolio'=>$portfolio]);
        }
        return $portfolio;
    }
    
    public function addPortfolio(Request $request){
        $newJob= new portfolio();
        $title = $request->input('title');
        $newJob->job_desc = $request->input('job_desc');
        $image= $request->file('image');
        if ($this->validateImage($image)&& $this->fileUpload($image, $title)){
            $newJob->picture = preg_replace('/\s+/','.',$title);
        }
        $newJob->url=$request->input('url');
        
        
    }
    private function fileUpload($file, $title){
        $fileName=preg_replace('/\s+/','.',$title);
        $fileName=$fileName.'_'.date('U').'.'.$file->getClientOriginalExtension();
        if($file->move(base_path('\public\portfolio\images'),$fileName)){
             return true;
        }else{ return false; }
  }
    /***
     *this checks if the image is of the required/supported type
     * future types that will be supported can be added with a case statement
     *@return boolean
     *
     */
    private function validateImage($image){
        $valid = false;
         switch($image->getClientOriginalExtension()){
            case 'gif':
              $valid=true;
              break;
            case 'jpg':
              $valid=true;
              break;
            case 'jpeg':
              $valid=true;
              break;
            case 'png':
              $valid=true;
              break;
            default:

          }
        return $valid;
      }
}

