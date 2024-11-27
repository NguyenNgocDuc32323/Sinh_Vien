<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Str;

class ManagerTeacherController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $teachers = Teacher::with(['user', 'subject'])->paginate(5);
    return view('Admin.manage-teacher', [
        'user' => $user,
        'teachers' => $teachers
    ]);
}
    public function teacher_search(Request $request)
    {
        $user = auth()->user();
        $search_string = $request->input('search-input');
        $teachers = Teacher::with(['user', 'subject'])
            ->whereHas('user', function ($query) use ($search_string) {
                $query->where('name', 'like', '%' . $search_string . '%') // Họ tên
                    ->orWhere('gender', 'like', '%' . $search_string . '%') // Giới tính
                    ->orWhere('email', 'like', '%' . $search_string . '%') // Email
                    ->orWhere('phone', 'like', '%' . $search_string . '%') // Số điện thoại
                    ->orWhere('address', 'like', '%' . $search_string . '%'); // Địa chỉ
            })
            ->orWhereHas('subject', function ($query) use ($search_string) {
                $query->where('name', 'like', '%' . $search_string . '%');
            })
            ->orWhere('teacher_code', 'like', '%' . $search_string . '%') // Mã giáo viên
            ->paginate(10);

        return view('Admin.manage-teacher', ['teachers' => $teachers,'user'=>$user]);
    }

    public function delete_teacher($teacher_id)
{
    $teacher = Teacher::find($teacher_id);

    if ($teacher) {
        $user_id = $teacher->user_id;
        $teacher->delete();
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
        }

        return redirect()->back()->with('success', 'Giáo viên và người dùng đã được xóa thành công.');
    } else {
        return redirect()->back()->with('error', 'Không tìm thấy giáo viên.');
    }
    }
    public function create_teacher(){
        $user = auth()->user();
        $subjects = Subject::all();
        return view("Admin.create-teacher",[
            'user' => $user,
            'subjects' => $subjects
        ]);
    }
    public function create_teacher_post(Request $request)
{
    $validated = $request->validate([
        'teacher_code' => 'required|unique:teachers,teacher_code',
        'password' => 'required|min:8',
        'name' => 'required|max:255',
        'gender' => 'required|in:Nam,Nữ',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
        'address' => 'nullable|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'subject_id' => 'required|exists:subjects,id',
    ]);

    // Tạo người dùng
    $user = new User();
    $user->name = $validated['name'];
    $user->gender = $validated['gender'];
    $user->email = $validated['email'];
    $user->password = sha1($validated['password']);

    $user->role = 'teacher';
    $user->phone = $validated['phone_number'] ?? null;
    $user->address = $validated['address'] ?? null;

    // Xử lý hình ảnh đại diện
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

    // Tạo giáo viên và liên kết với người dùng
    $teacher = new Teacher();
    $teacher->user_id = $user->id; // Liên kết với bảng `users`
    $teacher->teacher_code = $validated['teacher_code'];
    $teacher->subject_id = $validated['subject_id'];
    $teacher->save();

    return redirect()->route('manage-teacher')->with('success', 'Tạo giáo viên thành công!');
    }

    public function update_teacher($teacher_id)
{
    $user = auth()->user();
    $teacher = Teacher::with('user')->find($teacher_id);
    $subjects = Subject::all();

    if (!$teacher) {
        return redirect()->back()->with('error', 'Giáo viên không tồn tại!');
    }

    return view('Admin.update-teacher', [
        'user' => $user,
        'teacher' => $teacher,
        'subjects' => $subjects
    ]);
    }
    public function update_teacher_post($teacher_id, Request $request)
{
    // Tìm giáo viên theo ID
    $teacher = Teacher::find($teacher_id);
    
    // Kiểm tra nếu giáo viên không tồn tại
    if (!$teacher) {
        return back()->with('error', 'Không tìm thấy giáo viên.');
    }

    // Xác thực dữ liệu đầu vào
    $validated = $request->validate([
        'teacher_code' => 'required|unique:teachers,teacher_code,' . $teacher_id,
        'name' => 'required|string|max:255',
        'class_id' => 'required|exists:subjects,id', // Kiểm tra môn học có tồn tại không
    ]);

    // Cập nhật thông tin giáo viên
    $teacher->teacher_code = $validated['teacher_code'];
    $teacher->subject_id = $validated['class_id'];

    // Cập nhật tên giáo viên trong bảng users (liên quan đến bảng teacher)
    $teacher->user->name = $validated['name'];
    
    // Lưu lại thông tin đã cập nhật
    $teacher->user->save(); // Lưu tên giáo viên trong bảng users
    $teacher->save(); // Lưu lại các thông tin khác trong bảng teachers
    return redirect()->route('manage-teacher')->with('success', 'Cập nhật giáo viên thành công!');
    }
    public function updatePassword(Request $request, $teacher_id)
{
    $validatedData = $request->validate([
        'current_password' => 'required|min:8',
        'new_password' => 'required|min:8|different:current_password',
        'confirm_password' => 'required|min:8|same:new_password',
    ]);

    $teacher = Teacher::findOrFail($teacher_id);
    $user = User::findOrFail($teacher->user_id);

    // Kiểm tra mật khẩu hiện tại bằng sha1
    if (sha1($validatedData['current_password']) !== $user->password) {
        return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác!');
    }

    // Cập nhật mật khẩu mới bằng sha1
    $user->password = sha1($validatedData['new_password']);
    $user->save();

    return redirect()->route('admin')->with('success', 'Cập nhật mật khẩu thành công!');
}



}
