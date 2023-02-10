<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accura Member List</title>

    {{-- header with necessary styles --}}
    @include('components.header')


</head>

<body>

    <div class="main-content">

        <section class="section">

            <div class="row">
                <div class="col-12">

                    <!-- New Card -->

                    <div class="card">
                        <div class="card-header">
                            <h4>Property Application</h4>
                            <div class="card-header-action">

                            </div>
                        </div>
                        <div class="card-body">
                            <button id="execute" class="btn btn-success btn-lg" type="submit">Execute</button>
                            <span id="message"></span>
                        </div>
                    </div>

                    <!-- New Card End -->




                </div>

        </section>
    </div>

    {{-- Footer with necessary scripts --}}
    @include('components.footer')

    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script>
        $("#execute").click(function() {

            var that = $(this);
            that.addClass("disabled btn-progress");
            $.ajax({
                type: 'POST',
                url: '/create',
                data: {
                    "_token": "{{ csrf_token() }}",
                    
                },
                dataType: 'json',
                success: function(data) {


                    
                    toastr.success(data);
                    that.removeClass("btn-progress");
                    




                },


                error: function(err) {
                    console.log(err);
                }
            });


        });
    </script>


</body>

</html>
