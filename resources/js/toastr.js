import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
window.toastr = toastr;
toastr.options = {
    "positionClass": "toast-top-center",
    "timeOut": "3000",
    "closeButton": true,
    "progressBar": true,
};
