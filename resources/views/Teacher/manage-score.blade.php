@extends('Layouts.master-student')
@section('page_title')
Hồ Sơ Giáo Viên
@endsection
@section('content')
@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    toastr.success('{{ session('
      success ') }}');
  });
</script>
@endif
@if(session('error'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    toastr.error('{{ session('
      error ') }}');
  });
</script>
@endif
<div id="demo_3">
            <section_1 class="m-5">
                <div class="row">
                    <div class="col-12">
                        <div class="studentDetailContainer frameWork p-4">
                            <!-- Bảng học kỳ 1 -->
                            <div class="semester">
                                <h4 class="header-text showMark">XEM ĐIỂM SỐ
                                </h4>
                                <h4 class="text-center text-white ">Học kỳ 1</h4>
                                <table class="table table-bordered text-center">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã môn</th>
                                            <th>Tên môn học</th>
                                            <th>KTTX</th>
                                            <th>Giữa kỳ</th>
                                            <th>Thực hành</th>
                                            <th>Cuối kỳ</th>
                                            <th>Điểm tổng kết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>AGR10114</td>
                                            <td>Đại số</td>
                                            <td>10</td>
                                            <td>10</td>
                                            <td>10</td>
                                            <td>10</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>MTA10305</td>
                                            <td>Giải tích</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td></td>
                                            <td>9</td>
                                            <td>9.4</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>BIN10101</td>
                                            <td>Tin học cơ bản</td>
                                            <td>9.5</td>
                                            <td></td>
                                            <td>9.5</td>
                                            <td></td>
                                            <td>9.5</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>EDS10119</td>
                                            <td>Giáo dục quốc phòng 1</td>
                                            <td></td>
                                            <td></td>
                                            <td>7.2</td>
                                            <td>7.2</td>
                                            <td>7.2</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>EDS10119</td>
                                            <td>Giáo dục quốc phòng 2</td>
                                            <td></td>
                                            <td></td>
                                            <td>5.5</td>
                                            <td>5.8</td>
                                            <td>5.7</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>EDS10119</td>
                                            <td>Giáo dục quốc phòng 3</td>
                                            <td></td>
                                            <td></td>
                                            <td>7.8</td>
                                            <td>7.8</td>
                                            <td>7.8</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>EDS10119</td>
                                            <td>Giáo dục quốc phòng 4</td>
                                            <td></td>
                                            <td></td>
                                            <td>8.4</td>
                                            <td>8.4</td>
                                            <td>8.4</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>LAW10120</td>
                                            <td>Pháp luật đại cương</td>
                                            <td>10</td>
                                            <td></td>
                                            <td></td>
                                            <td>8</td>
                                            <td>8.6</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>PMS10212</td>
                                            <td>Xác suất và Thống kê</td>
                                            <td>10</td>
                                            <td></td>
                                            <td></td>
                                            <td>9.8</td>
                                            <td>9.6</td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>PHE10262</td>
                                            <td>Giáo dục thể chất 2</td>
                                            <td>10</td>
                                            <td>10</td>
                                            <td></td>
                                            <td>10</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td>DMS20105</td>
                                            <td>Hệ quản trị cơ sở dữ liệu</td>
                                            <td>9</td>
                                            <td></td>
                                            <td>7</td>
                                            <td></td>
                                            <td>7.4</td>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>DCM2105</td>
                                            <td>Toán rời rạc</td>
                                            <td>9.5</td>
                                            <td>6.5</td>
                                            <td></td>
                                            <td>4.5</td>
                                            <td>6.3</td>
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td>INT20205</td>
                                            <td>Thực tập nhận thức</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>9.6</td>
                                            <td>9.6</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Bảng học kỳ 2 -->
                            <div class="semester">
                                <h4 class="text-center text-white">Học kỳ 2</h4>
                                <table class="table table-bordered text-center">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã môn</th>
                                            <th>Tên môn học</th>
                                            <th>KTTX</th>
                                            <th>Giữa kỳ</th>
                                            <th>Thực hành</th>
                                            <th>Cuối kỳ</th>
                                            <th>Điểm tổng kết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>1</td><td>AGR10114</td><td>Đại
                                                số</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>2</td><td>MTA10305</td><td>Giải
                                                tích</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>3</td><td>BIN10101</td><td>Tin
                                                học cơ
                                                bản</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>4</td><td>EDS10119</td><td>Giáo
                                                dục quốc phòng
                                                1</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>5</td><td>EDS10119</td><td>Giáo
                                                dục quốc phòng
                                                2</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>6</td><td>EDS10119</td><td>Giáo
                                                dục quốc phòng
                                                3</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>7</td><td>EDS10119</td><td>Giáo
                                                dục quốc phòng
                                                4</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>8</td><td>LAW10120</td><td>Pháp
                                                luật đại
                                                cương</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>9</td><td>PMS10212</td><td>Xác
                                                suất và Thống
                                                kê</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>10</td><td>PHE10262</td><td>Giáo
                                                dục thể chất
                                                2</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>11</td><td>DMS20105</td><td>Hệ
                                                quản trị cơ sở dữ
                                                liệu</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>12</td><td>DCM2105</td><td>Toán
                                                rời
                                                rạc</td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <tr><td>13</td><td>INT20205</td><td>Thực
                                                tập nhận
                                                thức</td><td></td><td></td><td></td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </section_1>

        </div>
@endsection