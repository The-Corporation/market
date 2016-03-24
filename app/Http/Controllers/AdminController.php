<?php
namespace App\Http\Controllers;

use Auth;
use Redirect;
use App\Admin;
use App\User;
use App\Category;
use App\Product;
use App\Price;
use App\Message;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['getSignin', 'logout', 'postSignin']]);
    }

    public function index()
    {
        $products =Product::all();
        $users = User::all();
        return view('admin.admin')->with(['users'=>$users, 'products'=>$products]);
         //return view('admin.test');
    }
    public function profile($id){
        
        $admin =Admin::findOrFail($id);
        return view('admin.profile',compact('admin',$admin));
    }
    public function getMessage()
    {
        $message =Message::all();
        return view('admin.message')->with('messages', $message);
    }

    public function readMessage(Request $request)
    {
        $id =$request->input('id');
        //dd($id);
        $message = Message::findOrFail($id);
        //dd($messages);
        return view('admin.readmessage')->with('message',$message);
    }
    public function listuser()
    {
        $users = User::paginate(15);
        return view('admin.users')->with('users', $users);
    }
    public function approveuser(Request $request)
    {
        $user =User::findOrFail($request->id);
        if ($user->status =='1') {
            $user->status ='0';
        } else {
            $user->status ='1';
        }
        $user->save();
        return redirect()->route('admin.listuser');
    }
    public function imageupload(Request $request){
        //dd($request);
        //get filename from post request
        $file = $request->file('file');
        //set filename
        $filename = uniqid() . $file->getClientOriginalName();
        //move file to cerrect location
        $file->move('img', $filename);
        //save image details into datavase

    }
    public function delete(Request $request)
    {
        if ($request->scope === "user") {
            $user = new User;
            $user->where('id', $request->id)->delete();
            return redirect()->route('admin.listuser');
        } elseif ($request->scope === "category") {
            $category= new Category;
            $category->where('id', $request->id)->delete();
            return redirect()->route('admin.listcategory');
        }
        elseif ($request->scope === "message") {
            $message= new Message;
            $message->where('id', $request->id)->delete();
            return redirect()->route('admin.message');
        }
        elseif ($request->scope == "product") {
            $product =new Product;
            $product->where('id',$request->prod_id)->delete();
            return redirect()->route('admin.listproducts',['cat_id'=>$request->cat_id])->with('info','product deleted successful');
        }
    }
    public function listcategory()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.addcategory')->with('categories', $categories);
    }
    public function listproducts(Request $request){
        $category =Category::findOrFail($request->cat_id);
        $products = $category->products->all();
        return view('admin.listproducts')->with(['products'=>$products,'category'=>$category]);
    }
    public function addcategory(Request $request)
    {
        $this->validate($request, [
            'category'=>'required|min:3|max:255',
            'description'=>'min:4'
            ]);
        Category::create(['category_name'=>$request->input('category'), 'description'=>$request->input('description')]);
        \Session::flash('info', 'Category Add Successfull');
        return redirect()->route('admin.listcategory');
    }
    public function getprices(Request $request)
    {
        if ($request->id) {
            $price =Price::where('product_id', $request->id)->lists('price');
        } else {
            $price =Price::lists('price');
        }
        return response()->json($price);
    }
    public function getSignin()
    {
        return view('admin.login');
    }
    public function postSignin(Request $request)
    {
        $errors= $this->validate($request, [
            'email'=>'required|email|max:255',
            'password'=>'required|min:4'
            ]);
        if (!$errors) {
            $credentials =$request->only('email', 'password');
            $remember = $request->has('remember');
            if (Auth::admin()->attempt($credentials, $remember)) {
                return redirect()->route('admin.index');
            } else {
                \Session::flash('info', "Username or password is incorrect");
                return redirect()->back();
            }
        } else {
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
    public function logout()
    {
        Auth::admin()->logout();
        return redirect()->route('admin.login');
    }
}
