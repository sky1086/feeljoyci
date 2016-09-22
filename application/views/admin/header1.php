<!doctype html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FeelJoy</title>
    <link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/font-awesome.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .nav-wrapper {
            background-color: #56B68B;
        }

        .main-sec {
            display: flex;
        }

        .left {
            flex: 0 1 10%;
        }

        .mid {
            flex: 0 1 80%;
        }

        .mid-sec {
            margin-top: 70px;
        }

        .signup-sec {}

        .main {
            background-color: white;
            margin-top: 10px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.19), 0 2px 3px rgba(0, 0, 0, 0.23);
            padding: 10px;
            border-radius: 6px 6px 0 0;
        }
        .extras{
            background:#f0f0f0 ;
            border-radius: 0 0 6px 6px;
            border-top: 1px solid #dadada;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.19), 0 2px 3px rgba(0, 0, 0, 0.23);
            clear: both;
        }

        .extras-btn {
            float: right;
            padding-top: 5%;
            /*box-shadow: 0 2px 3px rgba(0, 0, 0, 0.19), 0 2px 3px rgba(0, 0, 0, 0.23);*/
        }


        .extras ul {
            position: relative;
            bottom: 15px;
            padding-top: 5%;
            margin-left: 10px;
        }

        .login-btn {
            float: right;
            margin-right: 10%;
            align-self: center;
        }

        .details{
          margin-top: 10px;
        }


        .ggl-su {
          background-color: #dd4b39;
          letter-spacing: 0.08em;
          width: 90%;
          height: 40px;
          margin-top: 10px;
          margin-left: 6%;
          margin-right:6%;
        }

        .ggl-su:hover{
            background-color: #ee5c4a;
        }

        .main-head{
          margin-top: -10px;
        }

        .main-head{
          margin-top: -10px;
          float: left;
          margin-left: 10%;
        }

        .main-head h4{
          font-size: 20px;
          font-weight: bold;
        }

        .right {
            flex: 0 1 10%;
        }
        .separate{
            border-color: #eee;
            border: solid rgba(0,0,0,0.18);
            border-width: 1px 0 0;
            color: #eee;
            margin-top: 10%;
            display: block;
            width: 90%;
        }
    </style>
    <?php $this->load->view('user/theme-common');?>
</head>

<body>

    <nav>
        <div class="nav-wrapper theme">
            <a href="#" class="brand-logo center">FeelJoy</a>
        </div>
    </nav>