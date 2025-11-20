@if (session('success'))
 <script>toastr.success("{{session('success')}}");</script>
@elseif (session('error'))
  <script>toastr.error("{{session('error')}}");</script>
@endif