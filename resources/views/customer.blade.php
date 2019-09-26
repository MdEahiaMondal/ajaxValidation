<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Ajax Validation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="row">
    <div class="col-lg-6 offset-3 mt-5">
        @if (session('success_message'))
            <div id="timeOut" class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif


            @if ($errors)
                @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
            @endforeach
        @endif


        <div class="card">
            <div class="card-header">
                Customer Register
            </div>
            <div class="card-body">
                <form action="{{route('customer.register')}}" method="post"  id="customerForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" id="email"  placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>





<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

<script>
    (function() {
        document.querySelector("#customerForm").addEventListener('submit', function (e) {
            e.preventDefault();

            axios.post(this.action, {
                'name': document.querySelector('#name').value,
                'email': document.querySelector('#email').value,
                'password': document.querySelector('#password').value,
                'password_confirmation': document.querySelector('#password-confirm').value,
            })
                .then((response) => {
                    console.log('success');
                    window.location.reload()
                })
                .catch((error) => {
                    /*console.log(error.response)*/
                    const errors = error.response.data.errors;
                    const firstItem = Object.keys(errors)[0];
                    const firstItemDom = document.getElementById(firstItem);
                    const firstErrorMessage = errors[firstItem][0];
                    /*   console.log(firstErrorMessage);*/

                    // scroll the error message
                    firstItemDom.scrollIntoView({behavior: 'smooth'});

                    // remove all errors
                    const errorMessage = document.querySelectorAll('.text-danger');
                    errorMessage.forEach((element) => element.textContent = '');

                    // show the error message
                    firstItemDom.insertAdjacentHTML('afterend', '<div class="text-danger">'+firstErrorMessage+'</div>');

                    // remove all form control with heighligted error text box
                    const formControls = document.querySelectorAll('.form-control');
                    formControls.forEach((element) => element.classList.remove('border', 'border-danger'));

                    // heighlight the form control with the error
                    firstItemDom.classList.add('border','border-danger')

                })
        });
    })();
</script>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            $("#timeOut").hide('slow');
        },2000)
    })
</script>

</body>
</html>