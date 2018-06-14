<?php namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Controllers\Controller;
use \App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Hash;

class dashBoardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *This methos returns the dashboard view
	 * @return Response
	 */
	public function index(Request $request)
	{
	 $user= $this::getdetails($request);
	 if ($user){
	   echo $user['name'];
	   return view('dashboardView')->with(['user'=>$user]);
	 }
	}
		
	/**this method gets the details of the logged in user, the details gottwn here are displayed on the dashboard
	 * @param request
	 *@return mixed
	 **/
		
  private function getDetails($request){
    
    if($request->session()->has('email')){
     $email= $request->session()->get('email');
     $user= \App\User::where('email',$email)->first();
     $name = $user->username;
     $number = $user->Number;
     $bio = $user->bio;
     $image =$user->image;
    
    return ['name'=>$name, 'number'=>$number, 'bio'=>$bio, 'image'=>$image];
      
    }
  
  }
/**
 * this method returns the view for the updateBio page
 *
 *
 * */
 public function updateBioIndex(){
	  
      return view('updateBio');
      }
/**
 * This is a pretty messed up method, its only function is to pick up the input details from the user and
 * pass it to the method that will update that field in the user's database record
 *
 *
 *
 **/
  public function updateBio(Request $request){
     $email= $request->session()->get('email');
    $user= \App\User::where('email', $email);
    $basePath = 'resources/images/';
    //this lines below checks whetherthe input contains the required values and performs functions in line with the particular inputs given
    if($this::iset($request->input('phone')) && $this::iset($request->input('phone1'))){
      //CALL to the  PHONE NUMBER UPDATE METHOD
      //this line calls all the other methods in the program required for the successful update of the user's phone number, it is enclosed in an 'if' condition all the other methods below are similar to it
      $number= $request->input('phone');
      if($this::update($number,'number', $user)){
        return view('updateBio')->with(['message'=>'number updated']);
      }else{
        return view('updateBio')->with(['message'=>'number not updated']);
      }
      
    }
    else if($this::iset($request->input('bio'))){
      // CALL BIO UPDATE METHOD
      $bio= $this::sanitize($request->input('bio'));
      if($this::update($bio,'bio',$user)){
        return view('updateBio')->with(['message'=>'bio updated']);
      }else{
        return view('updateBio')->with(['message'=>'bio not updated']);
      }
    }
    else if($this::iset($request->file('image'))){
      //CALL IMAGE UPLOAD METHOD
      /*this part of the program is simple albeit poorly designed
      *it has the function of getting the user image from the input and calling methods that upload the image to a folder in the server and finally updates the name of the image in the user's database record
      */
      $image=$request->file('image');
     
      if($this::validateImage($image)){
        if($this::fileUpload($image,$user->first()->username)){
          $this::update(preg_replace('/\s+/','.',$basePath.$user->first()->username).'_'.date('U').'.'.$image->getClientOriginalExtension(),'image',$user);
          return view('updateBio')->with(['message'=>'image updated']);
        }else{ return view('updateBio')->with(['message'=>'image not updated']);
          
                } }
      else {return view('updateBio')->with(['message'=>'image must be one of gif, jpg, jpeg or png']); }
      
      
    }
    else if( ($this::iset($request->input('new_password')) && $this::iset($request->input('new_password1')) ) && $this::iset($request->input('old_password')) ){
      // CALL PASSWORD METHOD
      //this part of the program has the function of checking thepassword in  the user input against the password in the database and if they match, it allows for the update/ change of the password in the user's database record
      $oldPwd= $user->first()->password;
      if( ($request->input('new_password')==$request->input('new_password1') && Hash::check($request->input('old_password'), $oldPwd)) && $this::update(Hash::make($request->input('new_password')), 'password', $user) ){
        return view('updateBio')->with(['message'=>'password updated']);
      }else { return view('updateBio')->with(['message'=>'image not updated']);
          
                }
    }
    else{ return view('updateBio')->with(['message'=>'you might have an error in your input']);}
  }
  /*
  *This method takes the values input by the user and updates the required database table
  *@param1 The value to be updated
  *@param2 the type of value it is
  *@param3 the user whose accoount will be updated
  *@return boolean
 */
  private function update($value, $attr, $user){
      if ($attr=='number') {
      $user->update(['Number'=> $value]);
    } elseif ($attr=='bio') {
    $user->update(['bio'=> $value]);
    }elseif($attr=='image'){
      $user->update(['image'=> $value]);
    }elseif($attr=='password'){
     $user->update(['password'=> $value]);
    }
    else{ return false; }
   
    return true;
    
  }
  /**
   * this function sanitizes the user input
   * @param input
   * @return the sanitized input
  */
  private function sanitize($input){
    $input= trim($input);
    $input = stripslashes($input);
    $input= htmlspecialchars($input);
    return $input;
  }
  /**
   * this function moves the uploaded image to a folder on the server
   * ALTHOUGH I'M STILL WORKING OUT SOME OF THE QUIRKS, IT'S MOSTLY IN ORDER
   *@return boolean
  */
  private function fileUpload($file, $userName){
    $fileName=preg_replace('/\s+/','.',$userName);
    $fileName=$fileName.'_'.date('U').'.'.$file->getClientOriginalExtension();
    if($file->move(base_path('\public\resources\images'),$fileName)){
      return true;
    }else{ return false; }
  }
  /***
   *this checks if the image is of the required/supported type
   * futre types that will be supported can be added with a case
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
  /**
   *this checks if a value is null
   * @reurns true if value is null and false otherwise
   */
  private function iset($val){
    if($val!=null){
      return true;
    }else{ return false;}
  }
}
