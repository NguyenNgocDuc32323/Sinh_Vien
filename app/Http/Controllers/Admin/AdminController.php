<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Darryldecode\Cart\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Str;

class AdminController extends Controller
{
    public function index()
    {
        $logged_in_user = auth()->user();
        $students = Student::with(['user', 'class', 'course'])->paginate(5);

        return view('Admin.index', [
            'students' => $students,
            'user' => $logged_in_user
        ]);
    }
    public function delete_student($student_id)
    {
        $student = Student::find($student_id);
        if ($student) {
            $student->scores()->delete();
            $user = $student->user;
            if ($user) {
                $user->delete();
            }
            $student->delete();

            return redirect()->back()->with('success', 'Xóa Học Sinh Thành Công!');
        }

        return redirect()->back()->with('error', 'Xóa Học Sinh Thất Bại!');
    }
    public function update_student($student_id)
    {
        $student = Student::with('class', 'course')->find($student_id);
        $user = auth()->user();
        $classes = Classes::all();
        $courses = Course::all();

        return view('Admin.update-student', [
            'user' => $user,
            'student' => $student,
            'classes' => $classes,
            'courses' => $courses,
        ]);
    }

    public function updatePasswordPost($student_id, Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        // Nếu validation thất bại, quay lại với lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lấy thông tin student
        $student = Student::findOrFail($student_id); // Tìm student dựa vào ID
        if (!$student) {
            return redirect()->back()->with('error', 'Không tìm thấy sinh viên.');
        }

        // Lấy thông tin user thông qua user_id từ student
        $user = User::findOrFail($student->user_id); // Tìm user thông qua user_id
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng.');
        }

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->input('current-password'), $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->input('new-password'));
        $user->save();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('update-student', [$student_id])
            ->with('success', 'Đã cập nhật mật khẩu thành công!');
    }

    public function update_student_post(Request $request, $student_id)
    {
        // Tìm sinh viên theo ID
        $student = Student::findOrFail($student_id);
        
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'student_code' => 'required|string|max:255',
            'birth_day' => 'required|date',
            'class_id' => 'required|exists:classes,id', // Kiểm tra lớp học có tồn tại không
            'course_id' => 'required|exists:courses,id', // Kiểm tra khóa học có tồn tại không
            'name' => 'required|max:255' // Kiểm tra tên sinh viên
        ]);
    
        // Cập nhật thông tin sinh viên
        $student->student_code = $validatedData['student_code'];
        $student->birth_day = $validatedData['birth_day'];
        $student->class_id = $validatedData['class_id'];
        $student->course_id = $validatedData['course_id'];
    
        // Cập nhật tên sinh viên trong bảng users (nếu có mối quan hệ với bảng users)
        // Giả sử Student có quan hệ với User thông qua user_id
        $student->user->name = $validatedData['name'];
        
        // Lưu lại thông tin đã cập nhật
        $student->user->save(); // Lưu tên sinh viên trong bảng users (nếu có)
        $student->save(); // Lưu lại các thông tin khác trong bảng students
    
        // Chuyển hướng về trang quản lý sinh viên với thông báo thành công
        return redirect()->route('admin', [$student_id])
            ->with('success', 'Cập nhật sinh viên thành công!');
    }
    
    public function create_student(){
        $classes = Classes::all();
        $courses = Course::all();
        $user = auth::user();
        return view('Admin.create-student', ['classes' => $classes, 'courses' => $courses,'user' => $user]);
    }
    public function create_student_post(Request $request){
        $validated = $request->validate([
            'student_code' => 'required|unique:students,student_code',
            'password' => 'required|min:8',
            'name' => 'required|max:255',
            'gender' => 'required|in:Nam,Nữ',
            'email' => 'required|email',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address' => 'nullable|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_day' => 'nullable|date',
            'class_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
        ]);
    
        $user = new User();
        $user->name = $validated['name'];
        $user->gender = $validated['gender'];
        $user->email = $validated['email'];
        $user->password = sha1($validated['password']);
        $user->role = 'student';
        $user->phone = $validated['phone_number'] ?? null;
        $user->address = $validated['address'] ?? null;
    
        if ($request->hasFile('avatar')) {
            $fileName = Str::random(10);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $storedImage = $fileName . '.' . $extension;
            $request->file('avatar')->storeAs('public/images/Admin/Manage-User', $storedImage);
            $sourcePath = storage_path('app/public/images/Admin/Manage-User/' . $storedImage);
            $destinationPath = public_path('images/Admin/Manage-User/' . $storedImage);
            File::copy($sourcePath, $destinationPath);
            $user->avatar = 'images/Admin/Manage-User/' . $storedImage;
        }
    
        $user->save();
    
        $student = new Student();
        $student->user_id = $user->id;
        $student->student_code = $validated['student_code'];
        $student->birth_day = $validated['birth_day'] ?? null;
        $student->class_id = $validated['class_id'];
        $student->course_id = $validated['course_id'];
        $student->save();
    
        return redirect()->route('admin')->with('success', 'Tạo sinh viên thành công!');
    }
    
    public function student_search(Request $request)
{
    $user = auth()->user();
    $search_string = $request->input('search-input');
    
    $students = Student::with(['class', 'course', 'user'])
        ->whereHas('user', function ($query) use ($search_string) {
            $query->where('name', 'like', '%' . $search_string . '%')
                  ->orWhere('gender', 'like', '%' . $search_string . '%')
                  ->orWhere('email', 'like', '%' . $search_string . '%');
        })
        ->orWhere('student_code', 'like', '%' . $search_string . '%')
        ->orWhere('birth_day', 'like', '%' . $search_string . '%')
        ->orWhereHas('class', function ($query) use ($search_string) {
            $query->where('class_name', 'like', '%' . $search_string . '%');
        })
        ->orWhereHas('course', function ($query) use ($search_string) {
            $query->where('course_name', 'like', '%' . $search_string . '%');
        })
        ->paginate(10);

    return view('Admin.index', ['students' => $students, 'user' => $user]);
    }
    public function updatePassword(Request $request, $student_id)
{
    // Xác thực dữ liệu đầu vào
    $validatedData = $request->validate([
        'current_password' => 'required|min:8',
        'new_password' => 'required|min:8|different:current_password',
        'confirm_password' => 'required|min:8|same:new_password',
    ]);

    $student = Student::findOrFail($student_id);
    $user = User::findOrFail($student->user_id);

    // So sánh mật khẩu hiện tại bằng sha1 hoặc md5
    if (sha1($validatedData['current_password']) !== $user->password) {
        // Hoặc bạn có thể dùng md5:
        // if (md5($validatedData['current_password']) !== $user->password) {
        return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác!');
    }

    // Mã hóa mật khẩu mới bằng sha1 hoặc md5
    $user->password = sha1($validatedData['new_password']);  // Thay thế bằng md5() nếu muốn
    // $user->password = md5($validatedData['new_password']); // Sử dụng md5 nếu cần

    $user->save();

    return redirect()->route('admin')->with('success', 'Cập nhật mật khẩu thành công!');
    }

    

}
