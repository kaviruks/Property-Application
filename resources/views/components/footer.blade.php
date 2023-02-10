<script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
  @if(session()->has('successmsg'))
  <script>
    
$( document ).ready(function() {
 toastr.options = {
 "progressBar": true
};
 toastr.success('{{session()->get('successmsg')}}');

   });   
</script>
@endif
 
@if(session()->has('errormsg'))
  <script>
$( document ).ready(function() {
 toastr.options = {
 "progressBar": true
};
 toastr.error('{{session()->get('errormsg')}}');

   });   
</script>
@endif 
    
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script>

$(document).ready(function() {
   var table = $('#table-55').DataTable({
    
  });
  
 
} );

</script>
<script src="{{ asset('library/toastr/js/toastr.min.js') }}"></script>