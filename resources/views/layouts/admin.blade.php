<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>

        @yield('title', 'Admin Dashboard')

        | MMACI Library Services Office

    </title>

    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>

        :root{

            --navy:#0B2E59;
            --blue:#184B8C;
            --yellow:#F4B400;
            --light:#F4F7FB;
            --sidebar:270px;

        }

        *{

            box-sizing:border-box;

        }

        body{

            margin:0;
            font-family:'Poppins',sans-serif;
            background:var(--light);

        }

        .sidebar{

            position:fixed;

            top:0;
            left:0;
            bottom:0;

            width:var(--sidebar);

            background:linear-gradient(
                    180deg,
                    var(--navy),
                    var(--blue)
            );

            overflow-y:auto;

            z-index:1050;

        }

        .main{

            margin-left:var(--sidebar);

            min-height:100vh;

        }

        .content{

            padding:30px;

        }

        .card{

            border:none;

            border-radius:18px;

            box-shadow:
                0 10px 30px rgba(0,0,0,.08);

        }

        .card-header{

            background:white;

            border-bottom:1px solid #eee;

            font-weight:600;

        }

        .btn-admin{

            background:var(--yellow);

            color:#111;

            font-weight:600;

            border:none;

            border-radius:10px;

        }

        .btn-admin:hover{

            background:#dca300;

        }

        .table{

            background:white;

        }

        .table th{

            background:#0B2E59;

            color:white;

        }

        .form-control,
        .form-select{

            border-radius:10px;

            min-height:45px;

        }

        textarea.form-control{

            min-height:150px;

        }

        .dashboard-title{

            color:#0B2E59;

            font-weight:700;

        }

        .stat-card{

            border-radius:20px;

            color:white;

            padding:25px;

            overflow:hidden;

            position:relative;

        }

        .stat-card i{

            font-size:55px;

            opacity:.3;

            position:absolute;

            right:20px;

            top:20px;

        }

        .bg-events{

            background:#0B2E59;

        }

        .bg-books{

            background:#1B7F5B;

        }

        .bg-gallery{

            background:#B77900;

        }

        .bg-users{

            background:#7A2E98;

        }

        .page-header{

            margin-bottom:30px;

        }

        @media(max-width:992px){

            .sidebar{

                left:-270px;

                transition:.3s;

            }

            .sidebar.show{

                left:0;

            }

            .main{

                margin-left:0;

            }

        }

    </style>

    @stack('styles')

</head>

<body>

<div class="sidebar">

    @include('partials.sidebar')

</div>

<div class="main">

    @include('partials.admin-navbar')

    <div class="content">

        @include('partials.flash-messages', ['containerClass' => 'mb-4'])

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script>

const sidebarToggle = document.getElementById('sidebarToggle');

if(sidebarToggle){

    sidebarToggle.addEventListener('click',()=>{

        document
            .querySelector('.sidebar')
            .classList
            .toggle('show');

    });

}

</script>

@stack('scripts')

</body>

</html>
